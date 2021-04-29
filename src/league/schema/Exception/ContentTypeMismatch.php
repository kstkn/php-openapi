<?php

namespace cebe\openapi\league\schema\Exception;

// Indicates that data did not match a given content-type
final class ContentTypeMismatch extends SchemaMismatch
{
    public static function fromContentType($contentType, $value)
    {
        $exception       = new static(sprintf("Value '%s' does not match content-type %s", $value, $contentType));
        $exception->data = $value;

        return $exception;
    }
}
