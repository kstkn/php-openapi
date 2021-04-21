<?php

/**
 * @copyright Copyright (c) 2018 Carsten Brandt <mail@cebe.cc> and contributors
 * @license https://github.com/cebe/php-openapi/blob/master/LICENSE
 */

namespace cebe\openapi;

/**
 * ReferenceContextCache represents a cache storage for caching content of referenced files.
 */
class ReferenceContextCache
{
    private $_cache = [];


    public function set($ref, $type, $data)
    {
        $this->_cache[$ref][isset($type) ? $type : ''] = $data;

        // store fallback value for resolving with unknown type
        if ($type !== null && !isset($this->_cache[$ref][''])) {
            $this->_cache[$ref][''] = $data;
        }
    }

    public function get($ref, $type)
    {
        return isset($this->_cache[$ref][isset($type) ? $type : '']) ? $this->_cache[$ref][isset($type) ? $type : ''] : null;
    }

    public function has($ref, $type)
    {
        return isset($this->_cache[$ref]) &&
            array_key_exists(isset($type) ? $type : '', $this->_cache[$ref]);
    }
}
