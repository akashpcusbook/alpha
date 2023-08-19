<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsEmail extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input value must be an email';
    }

    public function __execute(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
