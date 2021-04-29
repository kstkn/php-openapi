<?php

namespace cebe\openapi\league\schema\TypeFormats;

class StringIP4
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }
}
