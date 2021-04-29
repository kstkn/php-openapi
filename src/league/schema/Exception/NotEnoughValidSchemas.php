<?php

namespace cebe\openapi\league\schema\Exception;

class NotEnoughValidSchemas extends KeywordMismatch
{
    /** @var \Exception[] */
    protected $innerExceptions = [];

    /**
     * @param mixed       $data
     * @param \Exception[] $innerExceptions
     *
     * @return self
     */
    public static function fromKeywordWithInnerExceptions(
        $keyword,
        $data,
        array $innerExceptions,
        $message = null
    ) {
        $instance                  = new self('Keyword validation failed: ' . $message, 0);
        $instance->keyword         = $keyword;
        $instance->data            = $data;
        $instance->innerExceptions = $innerExceptions;

        return $instance;
    }

    /**
     * @return \Exception[]
     */
    public function innerExceptions()
    {
        return $this->innerExceptions;
    }
}
