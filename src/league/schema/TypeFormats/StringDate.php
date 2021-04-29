<?php

namespace cebe\openapi\league\schema\TypeFormats;

use DateTime;

class StringDate
{
    /**
     * @param mixed $value
     */
    public function __invoke($value)
    {
        // full-date notation as defined by RFC 3339, section 5.6, for example, 2017-07-21

        return DateTime::createFromFormat('Y-m-d', $value) !== false;
    }
}
