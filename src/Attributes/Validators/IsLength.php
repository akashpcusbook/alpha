<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsLength extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(private int $min = 0, private int $max = 0, string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input length must be between '. $min . ' to '. $max;
    }

    public function __execute(): bool
    {
        $len = strlen($this->value);

        if ($this->max <= 0) {
            $this->max = $len;
        }

        if ($this->min <= 0) {
            $this->min = 1;
        }

        if ($this->min > $this->max) {
            $this->message = 'invalid min and max value';
            return false;
        }

        return $len >= $this->min && $len <= $this->max;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
