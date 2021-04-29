<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class MultipleOf extends BaseKeyword
{
    /**
     * The value of "multipleOf" MUST be a number, strictly greater than 0.
     * A numeric instance is only valid if division by this keyword's value results in an integer.
     *
     * @param mixed $data
     * @param int|float $multipleOf
     *
     * @throws KeywordMismatch
     */
    public function validate($data, $multipleOf)
    {
        try {
            Validator::numeric()->assert($data);
            Validator::numeric()->positive()->assert($multipleOf);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        $value = (float)($data / $multipleOf);
        if ($value - (int)$value !== 0.0) {
            throw KeywordMismatch::fromKeyword('multipleOf', $data, sprintf('Division by %d did not resulted in integer', $multipleOf));
        }
    }
}
