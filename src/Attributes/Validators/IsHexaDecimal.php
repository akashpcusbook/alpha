<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsHexaDecimal extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input value must be hexadecimal';
    }

    public function __execute(): bool
    {
        return ctype_xdigit($this->value);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
