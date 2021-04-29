<?php

namespace cebe\openapi\league\schema;

use RuntimeException;

// Breadcrumb addresses a value in a complex structure.
// It can address an index in the compound array(object)
class BreadCrumb
{
    /** @var string|null */
    protected $compoundIndex;
    /** @var self|null link to a previous crumb */
    protected $prevCrumb;

    /**
     * @param int|string|null $compoundIndex suitable for array index
     */
    public function __construct($compoundIndex = null)
    {
        if (($compoundIndex !== null) && ! is_scalar($compoundIndex)) {
            throw new RuntimeException(sprintf('BreadCrumb cannot have non-scalar index: %s', $compoundIndex));
        }

        $this->compoundIndex = $compoundIndex;
    }

    /**
     * @param string|int $index
     *
     * @return BreadCrumb
     */
    public function addCrumb($index)
    {
        $i            = new self($index);
        $i->prevCrumb = $this;

        return $i;
    }

    /**
     * Follow the chain of crumbs to build a full chain of keys
     *
     * @return mixed[] - string/int values are allowed
     */
    public function buildChain()
    {
        $keys = [];

        $crumb = $this;
        do {
            array_unshift($keys, $crumb->compoundIndex);
            $crumb = $crumb->prevCrumb;
        } while ($crumb && ($crumb->compoundIndex !== null));

        return $keys;
    }
}
