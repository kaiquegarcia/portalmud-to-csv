<?php

namespace Collection;

use Entity\Entity;

class EntityCollection extends \ArrayObject {
    public function offsetSet(mixed $key, mixed $value): void
    {
        if (!$value instanceof Entity) {
            throw new \InvalidArgumentException('Value must be an implementation of Entity');
        }

        parent::offsetSet($key, $value);
    }
}