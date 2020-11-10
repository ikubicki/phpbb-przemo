<?php

namespace PhpBB\Core;

class Context
{

    private static $registry = [];
    private static $values = [];
    private static $entities = [];
    private static $modules = [];

    public static function register(array $collection)
    {
        self::registerServices($collection['services'] ?? []);
        self::registerValues($collection['values'] ?? []);
    }

    public static function registerService($name, $service)
    {
        self::$registry[$name] = $service;
    }

    public static function registerServices(array $services)
    {
        foreach($services as $name => $service) {
            self::registerService($name, $service);
        }
    }

    public static function registerValue($name, $value)
    {
        self::$values[$name] = $value;
    }

    public static function registerValues(array $values)
    {
        foreach($values as $name => $value) {
            self::registerValue($name, $value);
        }
    }

    public static function registerEntity($namespace, $entity)
    {
        $id = $entity->getKeyValue();
        if ($id !== false) {
            if (is_array($id)) {
                $id = implode(',', $id);
            }
            self::$entities[$namespace][$id] = $entity;
        }
    }

    public static function registerEntities($namespace, array $entities)
    {
        foreach($entities as $entity) {
            self::registerEntity($namespace, $entity);
        }
    }

    public static function getService($name)
    {
        return self::$registry[$name] ?? false;
    }

    public static function getServices(array $names)
    {
        $services = [];
        foreach($names as $name) {
            $services[$name] = self::getService($name);
        }
        return (object) $services;
    }

    public static function getValue($name, $alternative = false)
    {
        return self::$values[$name] ?? $alternative;
    }

    public static function getValues(array $names)
    {
        $values = [];
        foreach($names as $name) {
            $values[$name] = self::getValue($name);
        }
        return (object) $values;
    }

    public static function getEntity($namespace, $id)
    {
        return self::$entities[$namespace][$id] ?? false;
    }

    public static function getEntities($namespace, array $ids)
    {
        $entities = [];
        foreach($ids as $id) {
            $entities[$id] = self::getEntity($namespace, $id);
        }
        return (object) $entities;
    }

    public static function registerModule($namespace, $module)
    {
        if (empty(self::$modules[$namespace])) {
            self::$modules[$namespace] = [];
        }
        self::$modules[$namespace][$module] = self::getModuleClass($namespace, $module);
    }

    public static function getModules($namespace)
    {
        $modules = [];
        foreach(self::$modules[$namespace] as $module => $class) {
            $modules[$module] = new $class;
        }
        return $modules;
    }

    public static function getModule($namespace, $module)
    {
        if (!empty(self::$modules[$namespace][$module])) {
            $class = self::$modules[$namespace][$module];
            return new $class;
        }
        return false;
    }

    protected static function getModuleClass($namespace, $module)
    {
        return "\\PhpBB\\Modules\\$namespace\\$module\\Module";
    }
}