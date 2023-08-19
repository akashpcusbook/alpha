<?php

namespace Tusker\Framework\Attributes;

interface AttributeInterface
{
    /**
     * used to execucte attribute implementation
     *
     * @return boolean
     */
    public function __execute(): bool;

    /**
     * used to get attribute response message
     *
     * @return string
     */
    public function getMessage(): string;
}
