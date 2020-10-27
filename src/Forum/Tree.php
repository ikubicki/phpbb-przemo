<?php

namespace PhpBB\Forum;

use PhpBB\Core\Context;

class Tree
{

    protected $cache;
    protected $children = [];
    protected $orphans = [];
    protected $items = [];

    public function cache($cache)
    {
        $this->cache = $cache;
        if (file_exists($this->cache)) {
            include $this->cache;
        }
    }

    public function storeCache()
    {
        $file = $this->getFile($this->cache);
        $file->clear();
        $file->writeLine('<?php');
        $file->write('$this->children = ');
        $file->write(var_export($this->children, true));
        $file->writeLine(';');
        return $file;
    }

    public function isCached()
    {
        return $this->cache && count($this->children);
    }

    public function import(array $entities)
    {
        foreach ($entities as $entity) {
            $index = $entity->getIndex();
            $parent = $entity->getParentIndex();
            $this->items[$index] = $entity;
            if (!$parent) {
                $this->addChild($entity);
            }
            else {
                if (empty($this->items[$parent])) {
                    $this->orphans[$index] = $entity;
                }
                else {
                    $this->items[$parent]->addChild($entity);
                }
            }
        }
        foreach($this->orphans as $index => $orphan) {
            $parent = $orphan->getParentIndex();
            if (!empty($this->items[$parent])) {
                $this->items[$parent]->addChild($orphan);
                unset($this->orphans[$index]);
            }
        }
    }

    public function flat()
    {
        $entities = [];
        $this->iterate(function($entity) use (&$entities) {
            $entities[] = $entity;
        });
        return $entities;
    }

    public function addChild($entity)
    {
        $this->children[$entity->getOrder()] = $entity;
    }

    public function getChildren()
    {
        ksort($this->children);
        return $this->children;
    }

    public function iterate($callback)
    {
        foreach ($this->getChildren() as $child) {
            $child->iterate($callback);
        }
    }

    public function trace($entity)
    {
        foreach ($this->getChildren() as $child) {
            $result = $child->trace($entity, []);
            if ($result) {
                return $result;
            }
        }
        return [];
    }

    protected function getFile($filename)
    {
        $class = Context::getValue('file-handler');
        return new $class($filename);
    }
}