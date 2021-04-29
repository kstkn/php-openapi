<?php

namespace cebe\openapi\league\schema\Exception;

// Validation for 'type' keyword failed against a given data
class TypeMismatch extends KeywordMismatch
{
    /**
     * @param mixed $value
     *
     * @return TypeMismatch
     */
    public static function becauseTypeDoesNotMatch($expected, $value)
    {
        $exception          = new self(sprintf("Value expected to be '%s', '%s' given.", $expected, gettype($value)));
        $exception->data    =  $value;
        $exception->keyword = 'type';

        return $exception;
    }
}
