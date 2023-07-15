<?php

namespace Tusker\Framework\Manager\Object;

use Reflection;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Tusker\Framework\Exception\DIException;

final class ObjectManager {

    /**
     * stores instances
     *
     * @var array<mixed,mixed>
     */
    private static $instances = [];

    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a ObjectManager.");
    }

    /**
     * get instance of object manager
     *
     * @return ObjectManager
     */
    public static function getInstance(): ObjectManager
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * add class to object manager
     *
     * @param string $class
     * @param string $implClass
     * @return void
     */
    public function add(string $class, string $implClass = ''): void
    {
        $cls = new ReflectionClass($class);
        
        if ($cls->isInterface()) {
            if (empty($implClass)) {
                throw new DIException('Dependency can not be added. Please provide implementation class.');
            }
            $implClassInstance = new ReflectionClass($implClass);
            $implClassConstructor = $implClassInstance->getConstructor();
            $this->createAndAddInstance($implClass, $implClassConstructor, $class);

        } else {
            $constructor = $cls->getConstructor();
            $this->createAndAddInstance($class, $constructor);
        }
    }

    /**
     * add variables as dependency
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addVariables(string $key, $value): void
    {
        self::$instances[$key] = $value;
    }

    /**
     * create and add instance
     *
     * @param string $class
     * @param ReflectionMethod|null $constructor
     * @param string $interface
     * @return void
     */
    private function createAndAddInstance(string $class, ?ReflectionMethod $constructor, string $interface = ''): void
    {
        if (!in_array($class, array_keys(self::$instances))) {
            if (null === $constructor) {
                self::$instances[!empty($interface) ? $interface : $class] = new $class;
            } else {
                $params = $this->getDependency($constructor);
    
                self::$instances[!empty($interface) ? $interface : $class] = new $class(...$params);
            }
        }
    }

    /**
     * get instanse of objects
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return in_array($key, array_keys(self::$instances)) ? self::$instances[$key] : null ;
    }

    /**
     * get dependency as array
     *
     * @param ReflectionMethod|null $method
     * @return array<mixed, mixed>
     */
    public function getDependency(?ReflectionMethod $method): array
    {
        $params = [];
        $parameters = $method->getParameters();
        foreach ($parameters as $parameter) {
            /**
             * @var ReflectionNamedType|null $parameterType
             */
            $parameterType = $parameter->getType();
            $parameterName = $parameter->getName();
            if (null !== $parameterType) {
                if (in_array($parameterType, ['string', 'int', 'bool', 'float', 'array'])) {
                    $params[$parameter->getPosition()] = in_array($parameterName, array_keys(self::$instances)) ? self::$instances[$parameterName] : ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : throw new DIException('Dependency for $'. $parameterName .' not found'));
                } else {
                    $typeName = $parameterType->getName();
                    $params[$parameter->getPosition()] = in_array($typeName, array_keys(self::$instances)) ? self::$instances[$typeName] : throw new DIException('Dependency for $'. $parameterName .' of type'. $typeName .' not found');
                }
            } else {
                $params[$parameter->getPosition()] = in_array($parameterName, array_keys(self::$instances)) ? self::$instances[$parameterName] : ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : throw new DIException('Dependency for $'. $parameterName .' not found'));
            }
        }

        return $params;
    }
}
