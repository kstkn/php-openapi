<?php

namespace cebe\openapi\league\schema\Exception;

use cebe\openapi\spec\Schema;

class TooManyValidSchemas extends KeywordMismatch
{
    /** @var Schema[] */
    protected $validSchemas = [];

    /**
     * @param mixed    $data
     * @param Schema[] $validSchemas
     *
     * @return self
     */
    public static function fromKeywordWithValidSchemas(
        $keyword,
        $data,
        array $validSchemas,
        $message = null
    ) {
        $instance               = new self('Keyword validation failed: ' . $message, 0);
        $instance->keyword      = $keyword;
        $instance->data         = $data;
        $instance->validSchemas = $validSchemas;

        return $instance;
    }

    /**
     * @return Schema[]
     */
    public function validSchemas()
    {
        return $this->validSchemas;
    }
}
