<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsFloat extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input value must be an float type';
    }

    public function __execute(): bool
    {
        return is_numeric($this->value) && strval((float)$this->value) === $this->value;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
