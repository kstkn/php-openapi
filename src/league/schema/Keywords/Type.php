<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\spec\Type as CebeType;
use cebe\openapi\league\ArrayHelper;
use cebe\openapi\league\schema\Exception\FormatMismatch;
use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\TypeMismatch;
use cebe\openapi\league\schema\TypeFormats\FormatsContainer;
use RuntimeException;

class Type extends BaseKeyword
{
    /**
     * The value of this keyword MUST be either a string ONLY.
     *
     * String values MUST be one of the seven primitive types defined by the
     * core specification.
     *
     * An instance matches successfully if its primitive type is one of the
     * types defined by keyword.  Recall: "number" includes "integer".
     *
     * @param mixed $data
     *
     * @throws TypeMismatch
     */
    public function validate($data, $type, $format = null)
    {
        switch ($type) {
            case CebeType::OBJECT:
                if (! is_object($data) && ! (is_array($data) && ArrayHelper::isAssoc($data)) && $data !== []) {
                    throw TypeMismatch::becauseTypeDoesNotMatch(CebeType::OBJECT, $data);
                }

                break;
            case CebeType::ARR:
                if (! is_array($data) || ArrayHelper::isAssoc($data)) {
                    throw TypeMismatch::becauseTypeDoesNotMatch('array', $data);
                }

                break;
            case CebeType::BOOLEAN:
                if (! is_bool($data)) {
                    throw TypeMismatch::becauseTypeDoesNotMatch(CebeType::BOOLEAN, $data);
                }

                break;
            case CebeType::NUMBER:
                if (is_string($data) || ! is_numeric($data)) {
                    throw TypeMismatch::becauseTypeDoesNotMatch(CebeType::NUMBER, $data);
                }

                break;
            case CebeType::INTEGER:
                if (! is_int($data)) {
                    throw TypeMismatch::becauseTypeDoesNotMatch(CebeType::INTEGER, $data);
                }

                break;
            case CebeType::STRING:
                if (! is_string($data)) {
                    throw TypeMismatch::becauseTypeDoesNotMatch(CebeType::STRING, $data);
                }

                break;
            default:
                throw InvalidSchema::becauseTypeIsNotKnown($type);
        }

        // 2. Validate format now

        if (! $format) {
            return;
        }

        $formatValidator = FormatsContainer::getFormat($type, $format); // callable or FQCN
        if ($formatValidator === null) {
            return;
        }

        if (is_string($formatValidator) && ! class_exists($formatValidator)) {
            throw new RuntimeException(sprintf("'%s' does not loaded", $formatValidator));
        }

        if (is_string($formatValidator)) {
            $formatValidator = new $formatValidator();
        }

        if (! $formatValidator($data)) {
            throw FormatMismatch::fromFormat($format, $data, $type);
        }
    }
}
