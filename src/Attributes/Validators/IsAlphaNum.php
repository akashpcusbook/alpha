<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsAlphaNum extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input value must be alphanumeric';
    }

    public function __execute(): bool
    {
        return ctype_alnum($this->value);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
