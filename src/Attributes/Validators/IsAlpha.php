<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsAlpha extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input value must be only alphabets';
    }

    public function __execute(): bool
    {
        return ctype_alpha($this->value);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
