<?php

namespace Tusker\Framework\Attributes\Validators;

use Tusker\Framework\Attributes\AttributeInterface;

abstract class AbstractValidatorAttribute implements AttributeInterface
{
    /**
     * @var mixed $value
     */
    protected $value = null;

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    abstract public function getMessage(): string;
}
