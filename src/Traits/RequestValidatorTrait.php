<?php

namespace Tusker\Framework\Traits;

use ReflectionClass;
use Tusker\Framework\Exception\ValidationException;
use Tusker\Framework\Request\HttpRequest;

trait RequestValidatorTrait
{
    /**
     * @var array<mixed, mixed> $validationErrors
     */
    private array $validationErrors = [];

    /**
     * used to check validations
     *
     * @param string $class
     * @return boolean
     */
    public function checkValidation(string $class): bool
    {
        $request = getObjectManager()->get(HttpRequest::class);
        $refClass = new ReflectionClass($class);

        foreach ($refClass->getProperties() as $property)
        {
            $propName = $property->getName();

            if (property_exists($request, $propName)) {
                $propValue = $request->{$propName};
                foreach ($property->getAttributes() as $attribute)
                {
                    $attrName = $attribute->getName();
                    $attrArgs = $attribute->getArguments();
                    $attrClass = new $attrName(...$attrArgs);
                    $attrClass->setValue($propValue);
                    if (!$attrClass->__execute()) {
                        $this->validationErrors[$propName][] = $attrClass->getMessage();
                    }
                }
            } else {
                throw new ValidationException('Property '. $propName . ' not found in request');
            }
        }

        return count($this->validationErrors) === 0 ? true : false;
    }

    /**
     * return validation errors
     *
     * @return array<mixed, mixed>
     */
    public function getValidatonErrors(): array
    {
        return $this->validationErrors;
    }
}
