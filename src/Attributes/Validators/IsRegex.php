<?php

namespace Tusker\Framework\Attributes\Validators;

final class IsRegex extends AbstractValidatorAttribute
{

    private string $message = '';

    public function __construct(private string $regex, string $message = '')
    {
        $this->message = !empty($message) ? $message : 'input value must be valid patteren';
    }

    public function __execute(): bool
    {
        if (preg_match($this->regex, $this->value, $str)) {
            if (strlen($str[0]) === strlen((string)$this->value)) {
                return true;
            } else {
                return false;
            }
        }
        
        return false;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
