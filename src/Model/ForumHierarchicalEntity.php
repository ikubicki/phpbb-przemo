<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;

class ForumHierarchicalEntity extends Entity
{

    protected $children = [];
    protected $nesting = 0;

    public function setNesting($nesting)
    {
        $this->nesting = $nesting;
        foreach ($this->getChildren() as $child) {
            $child->setNesting($this->nesting + 1);
        }
    }

    public function getNesting()
    {
        return $this->nesting;
    }

    public function addChild($entity)
    {
        $entity->setNesting($this->nesting + 1);
        $this->children[$entity->getOrder()] = $entity;
    }

    public function getChildren()
    {
        ksort($this->children);
        return $this->children;
    }

    public function iterate($callback)
    {
        $callback($this);
        foreach ($this->getChildren() as $child) {
            $child->iterate($callback);
        }
    }

    public function trace($entity, $path)
    {
        $path[] = $this;
        if ($entity->getIndex() == $this->getIndex()) {
            return $path;
        }
        foreach ($this->getChildren() as $child) {
            $result = $child->trace($entity, $path);
            if ($result) {
                return $result;
            }
        }
        return false;
    }

}