<?php

namespace cebe\openapi\league\schema\TypeFormats;

class StringByte
{
    /**
     * @param mixed $value
     */
    public function __invoke($value)
    {
        //base64-encoded characters, for example, U3dhZ2dlciByb2Nrcw==

        return base64_encode(base64_decode($value, true)) === $value;
    }
}
