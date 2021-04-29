<?php

namespace cebe\openapi\league\schema\Exception;

// Indicates that data did not match a given type's "format"
class FormatMismatch extends TypeMismatch
{
    /** @var string */
    protected $format;

    /**
     * @param mixed $value
     *
     * @return FormatMismatch
     */
    public static function fromFormat($format, $value, $type)
    {
        $i          = new static(sprintf("Value '%s' does not match format %s of type %s", $value, $format, $type));
        $i->format  = $format;
        $i->data    = $value;
        $i->keyword = 'type';

        return $i;
    }

    public function format()
    {
        return $this->format;
    }
}
