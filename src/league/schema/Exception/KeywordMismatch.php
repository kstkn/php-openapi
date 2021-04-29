<?php

namespace cebe\openapi\league\schema\Exception;

// Indicates that data was not matched against a schema's keyword
class KeywordMismatch extends SchemaMismatch
{
    /** @var string */
    protected $keyword;

    /**
     * @param mixed $data
     *
     * @return KeywordMismatch
     */
    public static function fromKeyword($keyword, $data, $message = null, \Exception $prev = null)
    {
        $instance          = new static('Keyword validation failed: ' . $message, 0, $prev);
        $instance->keyword = $keyword;
        $instance->data    = $data;

        return $instance;
    }

    public function keyword()
    {
        return $this->keyword;
    }
}
