<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class MaxItems extends BaseKeyword
{
    /**
     * The value of this keyword MUST be an integer.  This integer MUST be
     * greater than, or equal to, 0.
     *
     * An array instance is valid against "maxItems" if its size is less
     * than, or equal to, the value of this keyword.
     *
     * @param mixed $data
     *
     * @throws KeywordMismatch
     */
    public function validate($data, $maxItems)
    {
        try {
            Validator::arrayType()->assert($data);
            Validator::intVal()->assert($maxItems);
            Validator::trueVal()->assert($maxItems >= 0);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        if (count($data) > $maxItems) {
            throw KeywordMismatch::fromKeyword(
                'maxItems',
                $data,
                sprintf('Size of an array must be less or equal to %d', $maxItems)
            );
        }
    }
}
