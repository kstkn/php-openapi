<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class MaxProperties extends BaseKeyword
{
    /**
     * The value of this keyword MUST be an integer.  This integer MUST be
     * greater than, or equal to, 0.
     *
     * An object instance is valid against "maxProperties" if its number of
     * properties is less than, or equal to, the value of this keyword.
     *
     * @param mixed $data
     *
     * @throws KeywordMismatch
     */
    public function validate($data, $maxProperties)
    {
        try {
            Validator::arrayType()->assert($data);
            Validator::trueVal()->assert($maxProperties >= 0);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        if (count($data) > $maxProperties) {
            throw KeywordMismatch::fromKeyword(
                'maxProperties',
                $data,
                sprintf("The number of object's properties must be less or equal to %d", $maxProperties)
            );
        }
    }
}
