<?php

namespace cebe\openapi\league\schema\TypeFormats;

class StringIP6
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }
}
