<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class Maximum extends BaseKeyword
{
    /**
     * The value of "maximum" MUST be a number, representing an upper limit
     * for a numeric instance.
     *
     * If the instance is a number, then this keyword validates if
     * "exclusiveMaximum" is true and instance is less than the provided
     * value, or else if the instance is less than or exactly equal to the
     * provided value.
     *
     * The value of "exclusiveMaximum" MUST be a boolean, representing
     * whether the limit in "maximum" is exclusive or not.  An undefined
     * value is the same as false.
     *
     * If "exclusiveMaximum" is true, then a numeric instance SHOULD NOT be
     * equal to the value specified in "maximum".  If "exclusiveMaximum" is
     * false (or not specified), then a numeric instance MAY be equal to the
     * value of "maximum".
     *
     * @param mixed     $data
     * @param int|float $maximum
     *
     * @throws KeywordMismatch
     */
    public function validate($data, $maximum, $exclusiveMaximum = false)
    {
        try {
            Validator::numeric()->assert($data);
            Validator::numeric()->assert($maximum);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        if ($exclusiveMaximum && $data >= $maximum) {
            throw KeywordMismatch::fromKeyword(
                'maximum',
                $data,
                sprintf('Value %d must be less or equal to %d', $data, $maximum)
            );
        }

        if (! $exclusiveMaximum && $data > $maximum) {
            throw KeywordMismatch::fromKeyword(
                'maximum',
                $data,
                sprintf('Value %d must be less than %d', $data, $maximum)
            );
        }
    }
}
