<?php

namespace cebe\openapi\league\schema\TypeFormats;

class StringHostname
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_DOMAIN) !== false;
    }
}
