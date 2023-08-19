<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsBool extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input value must be boolean';
    }

    public function __execute(): bool
    {
        return is_numeric($this->value) ? true : (in_array(strtolower($this->value), ['true', 'false']) ? true : false);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
