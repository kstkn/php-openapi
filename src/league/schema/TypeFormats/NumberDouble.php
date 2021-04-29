<?php

namespace cebe\openapi\league\schema\TypeFormats;

class NumberDouble
{
    /**
     * @param mixed $value
     */
    public function __invoke($value)
    {
        // treat integers as valid floats
        return is_float($value + 0) || is_int($value + 0);
    }
}
