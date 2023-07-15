<?php

namespace Tusker\Framework\Auth;

use Tusker\Framework\Support\Date;

class Auth implements AuthInterface
{
    private mixed $data = null;

    private string $jwttoken = '';

    private static int $expirationDays = 7;

    public function authenticate(): bool
    {
        $secret = env('AUTH_SECRET_KEY', '');
        $authorisation = get_header('Authorization');

        if (null === $authorisation || empty($secret)) {
            return false;
        }

        if (!str_contains($authorisation, 'Bearer')) {
            return false;
        }

        $bearerToken = trim(str_replace('Bearer', '', $authorisation), ' ');

        $tokenParts = explode('.', $bearerToken);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        $expiration = Date::unixToDateTime((int)json_decode($payload)->expires);
        $tokenExpired = Date::diff(Date::now(), $expiration) < 0;

        $base64UrlHeader = base64UrlEncode($header);
        $base64UrlPayload = base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = base64UrlEncode($signature);

        $signatureValid = ($base64UrlSignature === $signatureProvided);

        if ($tokenExpired || !$signatureValid) {
            return false;
        }

        $this->data = json_decode($payload)->data;

        return true;
    }

    public function getData()
    {
        return $this->data;
    }

    public function make(mixed $data): bool
    {
        
        $secret = env('AUTH_SECRET_KEY', '');
        
        if (empty($secret) || empty($data)) {
            return false;
        }

        $this->data = $data;

        $header = json_encode([
            'type' => 'JWT',
            'algo' => 'HS256'
        ]);

        $payload = json_encode([
            'data' => $this->data,
            'expires' => Date::toUnix(Date::daysAfter(self::$expirationDays))
        ]);

        $base64UrlHeader = base64UrlEncode($header);
        $base64UrlPayload = base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);

        $base64UrlSignature = base64UrlEncode($signature);

        $this->jwttoken = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return true;
    }

    public function getToken(): string
    {
        return $this->jwttoken;
    }

    public static function setExpiranationDays(int $days): void
    {
        self::$expirationDays = $days;
    }
}
