<?php

namespace cebe\openapi\league\schema\TypeFormats;

class StringEmail
{
    public function __invoke($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
