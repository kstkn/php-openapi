<?php

namespace cebe\openapi\league\schema\Exception;

use cebe\openapi\league\schema\BreadCrumb;

class SchemaMismatch extends \Exception
{
    /** @var BreadCrumb */
    protected $dataBreadCrumb;
    /** @var mixed */
    protected $data;

    public function dataBreadCrumb()
    {
        return $this->dataBreadCrumb;
    }

    public function hydrateDataBreadCrumb(BreadCrumb $dataBreadCrumb)
    {
        if ($this->dataBreadCrumb !== null) {
            return;
        }

        $this->dataBreadCrumb = $dataBreadCrumb;
    }

    public function withBreadCrumb(BreadCrumb $breadCrumb)
    {
        $this->dataBreadCrumb = $breadCrumb;

        return $this;
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }
}
