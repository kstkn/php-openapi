<?php

namespace cebe\openapi\league\schema\TypeFormats;

class NumberFloat
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
