<?php

namespace cebe\openapi\league\schema\TypeFormats;

class StringUUID
{
    public function __invoke($value)
    {
        $pattern = '/^[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}$/i';

        return (bool) preg_match($pattern, $value);
    }
}
