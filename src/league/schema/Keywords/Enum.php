<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class Enum extends BaseKeyword
{
    /**
     * The value of this keyword MUST be an array.  This array SHOULD have
     * at least one element.  Elements in the array SHOULD be unique.
     *
     * Elements in the array MAY be of any type, including null.
     *
     * An instance validates successfully against this keyword if its value
     * is equal to one of the elements in this keyword's array value.
     *
     * @param mixed   $data
     * @param mixed[] $enum - can be strings or numbers
     *
     * @throws KeywordMismatch
     */
    public function validate($data, array $enum)
    {
        try {
            Validator::arrayType()->assert($enum);
            Validator::trueVal()->assert(count($enum) >= 1);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        if (! in_array($data, $enum, true)) {
            throw KeywordMismatch::fromKeyword('enum', $data, 'Value must be present in the enum');
        }
    }
}
