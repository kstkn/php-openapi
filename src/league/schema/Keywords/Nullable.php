<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\league\schema\Exception\KeywordMismatch;

class Nullable extends BaseKeyword
{
    /**
     * Allows sending a null value for the defined schema. Default value is false.
     *
     * @param mixed $data
     *
     * @throws KeywordMismatch
     */
    public function validate($data, $nullable)
    {
        if (! $nullable && ($data === null)) {
            throw KeywordMismatch::fromKeyword('nullable', $data, 'Value cannot be null');
        }
    }
}
