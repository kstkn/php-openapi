<?php

namespace cebe\openapi\league\schema;

use cebe\openapi\spec\Schema;
use cebe\openapi\league\schema\Exception\SchemaMismatch;

interface Validator
{
    /**
     * @param mixed $data
     *
     * @throws SchemaMismatch if data does not match given schema.
     */
    public function validate($data, Schema $schema, $breadCrumb = null);
}
