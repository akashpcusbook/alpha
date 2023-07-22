<?php

namespace Tusker\Framework\Response;

use Tusker\Framework\Support\Date;

class HttpResponse
{
    public const RESPONSE_TYPE_JSON = 'json';
    public const RESPONSE_TYPE_XML = 'xml';

    public const HTTP_CONTINUE = 100;
    public const HTTP_SWITCHING_PROTOCOLS = 101;
    public const HTTP_PROCESSING = 102;
    public const HTTP_EARLY_HINTS = 103;

    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_ACCEPTED = 202;
    public const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_RESET_CONTENT = 205;
    public const HTTP_PARTIAL_CONTENT = 206;
    public const HTTP_MULTI_STATUS = 207;
    public const HTTP_ALREADY_REPORTED = 208;
    public const HTTP_IM_USED = 226;

    public const HTTP_MULTIPLE_CHOICE = 300;
    public const HTTP_MOVED_PERMANENTLY = 301;
    public const HTTP_FOUND_BUT_PREVIOUSLY_MOVED_TEMPORARYLY = 302;
    public const HTTP_SEE_OTHER = 303;
    public const HTTP_NOT_MODIFIED = 304;
    public const HTTP_USE_PROXY = 305;
    public const HTTP_SWITCH_PROXY = 306;
    public const HTTP_TEMPORARY_REDIRECT = 307;
    public const HTTP_PERMANENT_REDIRECT = 308;

    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_PAYMENT_REQUIRED = 402;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_NOT_ACCEPTABLE = 406;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    public const HTTP_REQUEST_TIMEOUT = 408;
    public const HTTP_CONFLICT = 409;
    public const HTTP_GONE = 410;
    public const HTTP_LENGTH_REQUIRED = 411;
    public const HTTP_PRECONDITION_FAILED = 412;
    public const HTTP_PAYLOAD_TOO_LARGE = 413;
    public const HTTP_URI_TOO_LONG = 414;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    public const HTTP_RANGE_NOT_SATISFIABLE = 416;
    public const HTTP_EXPECTATION_FAILED = 417;
    public const HTTP_IM_A_TEAPOT = 418;
    public const HTTP_MISDIRECTED_REQUEST = 421;
    public const HTTP_UNPROCESSABLE_ENTITY = 422;
    public const HTTP_LOCKED = 423;
    public const HTTP_FAILED_DEPENDENCY = 424;
    public const HTTP_TOO_EARLY = 425;
    public const HTTP_UPGRADE_REQUIRED = 426;
    public const HTTP_PRECONDITION_REQUIRED = 428;
    public const HTTP_TOO_MANY_REQUEST = 429;
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_NOT_IMPLEMENTED = 501;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;
    public const HTTP_GATEWAY_TIMEOUT = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
    public const HTTP_VARIENT_ALSO_NEGOTIATES = 506;
    public const HTTP_INSUFFICIENT_STORAGE = 507;
    public const HTTP_LOOP_DETECTED = 508;
    public const HTTP_NOT_EXTENDED = 510;
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

    public const RESPONSE_MESSAGES = [
        self::HTTP_CONTINUE => 'continue',
        self::HTTP_SWITCHING_PROTOCOLS => 'switching protocols',
        self::HTTP_PROCESSING => 'processing',
        self::HTTP_EARLY_HINTS => 'early hints',

        self::HTTP_OK => 'ok',
        self::HTTP_CREATED => 'created',
        self::HTTP_ACCEPTED => 'accepted',
        self::HTTP_NON_AUTHORITATIVE_INFORMATION => 'non authoritative information',
        self::HTTP_NO_CONTENT => 'no content',
        self::HTTP_RESET_CONTENT => 'reset content',
        self::HTTP_PARTIAL_CONTENT => 'partial content',
        self::HTTP_MULTI_STATUS => 'multi status',
        self::HTTP_ALREADY_REPORTED => 'already reported',
        self::HTTP_IM_USED => 'IM used',

        self::HTTP_MULTIPLE_CHOICE => 'multiple choice',
        self::HTTP_MOVED_PERMANENTLY => 'moved parmanently',
        self::HTTP_FOUND_BUT_PREVIOUSLY_MOVED_TEMPORARYLY => 'found (previously "moved temporarily")',
        self::HTTP_SEE_OTHER => 'see other',
        self::HTTP_NOT_MODIFIED => 'not modified',
        self::HTTP_USE_PROXY => 'use proxy',
        self::HTTP_SWITCH_PROXY => 'switch proxy',
        self::HTTP_TEMPORARY_REDIRECT => 'temporary redirect',
        self::HTTP_PERMANENT_REDIRECT => 'permanent redirect',

        self::HTTP_BAD_REQUEST => 'bad request',
        self::HTTP_UNAUTHORIZED => 'unauthorized',
        self::HTTP_PAYMENT_REQUIRED => 'payment required',
        self::HTTP_FORBIDDEN => 'forbidden',
        self::HTTP_NOT_FOUND => 'not found',
        self::HTTP_METHOD_NOT_ALLOWED => 'method not allowed',
        self::HTTP_NOT_ACCEPTABLE => 'not acceptable',
        self::HTTP_PROXY_AUTHENTICATION_REQUIRED => 'proxy authentication required',
        self::HTTP_REQUEST_TIMEOUT => 'request timeout',
        self::HTTP_CONFLICT => 'conflict',
        self::HTTP_GONE => 'gone',
        self::HTTP_LENGTH_REQUIRED => 'length required',
        self::HTTP_PRECONDITION_REQUIRED => 'precondition required',
        self::HTTP_PAYLOAD_TOO_LARGE => 'payload too large',
        self::HTTP_URI_TOO_LONG => 'uri too long',
        self::HTTP_UNSUPPORTED_MEDIA_TYPE => 'unsupported media type',
        self::HTTP_RANGE_NOT_SATISFIABLE => 'range not satisfiable',
        self::HTTP_EXPECTATION_FAILED => 'expectation failed',
        self::HTTP_IM_A_TEAPOT => 'I\'m a teapot',
        self::HTTP_MISDIRECTED_REQUEST => 'misdirected request',
        self::HTTP_UNPROCESSABLE_ENTITY => 'unprocessable entity',
        self::HTTP_LOCKED => 'locked',
        self::HTTP_FAILED_DEPENDENCY => 'failed dependency',
        self::HTTP_TOO_EARLY => 'too early',
        self::HTTP_UPGRADE_REQUIRED => 'upgrade required',
        self::HTTP_TOO_MANY_REQUEST => 'too many request',
        self::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE => 'request header fields too large',
        self::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS => 'unavailable for legal reasons',

        self::HTTP_INTERNAL_SERVER_ERROR => 'internal server error',
        self::HTTP_NOT_IMPLEMENTED => 'not implemented',
        self::HTTP_BAD_GATEWAY => 'bad gateway',
        self::HTTP_SERVICE_UNAVAILABLE => 'service unavailable',
        self::HTTP_GATEWAY_TIMEOUT => 'gateway timeout',
        self::HTTP_VERSION_NOT_SUPPORTED => 'http version not supported',
        self::HTTP_VARIENT_ALSO_NEGOTIATES => 'variants also negotiates',
        self::HTTP_INSUFFICIENT_STORAGE => 'insufficient storage',
        self::HTTP_LOOP_DETECTED => 'loop detected',
        self::HTTP_NOT_EXTENDED => 'not extended',
        self::HTTP_NETWORK_AUTHENTICATION_REQUIRED => 'network authentication required',
    ];

    /**
     * get json response
     *
     * @param array<mixed, mixed> $data
     * @param string $message
     * @param int $status
     * @param array<mixed, mixed> $headers
     * @return string
     */
    public static function json(array $data, string $message = '', int $status = self::HTTP_OK, array $headers = []): string
    {
        return self::custom(
            self::RESPONSE_TYPE_JSON,
            [
                'status' => $status,
                'time' => Date::toUnix(Date::now()),
                'message' => empty($message) ? self::generateMessage($status) : $message,
                'data' => $data
            ],
            $status,
            $headers
        );
    }

    /**
     * get xml response data
     *
     * @param array<mixed, mixed> $data
     * @param string $message
     * @param int $status
     * @param array<mixed, mixed> $headers
     * @return string
     */
    public static function xml(array $data, string $message = '', int $status = self::HTTP_OK, array $headers = []): string
    {
        return self::custom(
            self::RESPONSE_TYPE_XML,
            [
                'status' => $status,
                'time' => Date::toUnix(Date::now()),
                'message' => empty($message) ? self::generateMessage($status) : $message,
                'data' => $data
            ],
            $status,
            $headers
        );
    }

    /**
     * create custom response
     *
     * @param string $type
     * @param array<mixed, mixed> $data
     * @param int $status
     * @param array<mixed, mixed> $headers
     * @return string
     */
    public static function custom(string $type, array $data, int $status = self::HTTP_OK, array $headers = []): string
    {
        HttpHeader::set(
            'Content-Type', 
            (self::RESPONSE_TYPE_XML === $type ? 'text/'.self::RESPONSE_TYPE_XML : 'application/'.self::RESPONSE_TYPE_JSON)
        );
        HttpHeader::cors();

        if (!empty($headers)) {
            foreach ($headers as $key => $value) {
                HttpHeader::set($key, $value);
            }
        }

        http_response_code($status);

        return self::RESPONSE_TYPE_XML === $type ? arrayToXml($data) : json_encode($data, JSON_INVALID_UTF8_SUBSTITUTE);
    }

    private static function generateMessage(int $status): string
    {
        $message = 'ok';
        if (in_array($status, array_keys(self::RESPONSE_MESSAGES))) {
            $message = self::RESPONSE_MESSAGES[$status];
        }

        return $message;
    }
}
