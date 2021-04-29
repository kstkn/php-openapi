<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\spec\Schema as CebeSchema;

abstract class BaseKeyword
{
    /** @var CebeSchema */
    protected $parentSchema;

    public function __construct(CebeSchema $parentSchema)
    {
        $this->parentSchema = $parentSchema;
    }
}
