<?php

namespace cebe\openapi\league\schema\TypeFormats;

// This format is used for non-meaningful formats like int64,int32
class None
{
    /**
     * @param mixed $value
     */
    public function __invoke($value)
    {
        return true;
    }
}
