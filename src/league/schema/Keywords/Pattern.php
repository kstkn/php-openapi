<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class Pattern extends BaseKeyword
{
    /**
     * The value of this keyword MUST be a string.  This string SHOULD be a
     * valid regular expression, according to the ECMA 262 regular
     * expression dialect.
     *
     * A string instance is considered valid if the regular expression
     * matches the instance successfully.  Recall: regular expressions are
     * not implicitly anchored.
     *
     * @param mixed $data
     *
     * @throws KeywordMismatch
     */
    public function validate($data, $pattern)
    {
        try {
            Validator::stringType()->assert($data);
            Validator::stringType()->assert($pattern);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        $pattern = sprintf('#%s#', str_replace('#', '\#', $pattern));

        if (! preg_match($pattern, $data)) {
            throw KeywordMismatch::fromKeyword('pattern', $data, sprintf('Data does not match pattern \'%s\'', $pattern));
        }
    }
}
