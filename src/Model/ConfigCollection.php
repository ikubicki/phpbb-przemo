<?php

namespace PhpBB\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class ConfigCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('config', Config::class, 'config_name');
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('config', $entity);
    }

    public function export($criteria = [], array $order = [], $limit = null, $offset = 0)
    {
        $data = [];
        $records = parent::export($criteria, $order, $limit, $offset);
        foreach($records as $record) {
            $data[$record['config_name']] = $record['config_value'];
        }
        return $data;
    }
}