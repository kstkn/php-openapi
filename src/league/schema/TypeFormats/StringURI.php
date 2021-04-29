<?php

namespace cebe\openapi\league\schema\TypeFormats;

use League\Uri\UriParser;

class StringURI
{
    public function __invoke($value)
    {
        try {
            (new UriParser)->parse($value);

            return true;
        } catch (\InvalidArgumentException $error) {
            return false;
        }
    }
}
