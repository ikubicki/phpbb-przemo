<?php

use PhpBB\Data\Cache;

function cache($object)
{
    return new Cache($object);
}