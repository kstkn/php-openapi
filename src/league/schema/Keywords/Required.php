<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\spec\Schema as CebeSchema;
use cebe\openapi\league\schema\BreadCrumb;
use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use cebe\openapi\league\schema\SchemaValidator;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class Required extends BaseKeyword
{
    /** @var int this can be Validator::VALIDATE_AS_REQUEST or Validator::VALIDATE_AS_RESPONSE */
    protected $validationDataType;
    /** @var BreadCrumb */
    private $breadCrumb;

    public function __construct(CebeSchema $parentSchema, $type, BreadCrumb $breadCrumb)
    {
        parent::__construct($parentSchema);
        $this->validationDataType = $type;
        $this->breadCrumb         = $breadCrumb;
    }

    /**
     * The value of this keyword MUST be an array.  This array MUST have at
     * least one element.  Elements of this array MUST be strings, and MUST
     * be unique.
     *
     * An object instance is valid against this keyword if its property set
     * contains all elements in this keyword's array value.
     *
     * If a readOnly or writeOnly property is included in the required list, required affects just the relevant scope – responses only or requests only.
     * That is, read-only required properties apply to responses only, and write-only required properties – to requests only.
     *
     * @param mixed    $data
     * @param string[] $required
     *
     * @throws KeywordMismatch
     */
    public function validate($data, array $required)
    {
        try {
            Validator::arrayType()->assert($data);
            Validator::arrayType()->assert($required);
            Validator::each(Validator::stringType())->assert($required);
            Validator::trueVal()->assert(count(array_unique($required)) === count($required));
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        foreach ($required as $reqProperty) {
            $propertyFound = false;
            foreach ($data as $property => $value) {
                $propertyFound = $propertyFound || ($reqProperty === $property);
            }

            if (! $propertyFound) {
                // respect writeOnly/readOnly keywords
                if (
                    (
                        (isset($this->parentSchema->properties[$reqProperty]->writeOnly) ? $this->parentSchema->properties[$reqProperty]->writeOnly : false) &&
                        $this->validationDataType === SchemaValidator::VALIDATE_AS_RESPONSE
                    )
                    ||
                    (
                        (isset($this->parentSchema->properties[$reqProperty]->readOnly) ? $this->parentSchema->properties[$reqProperty]->readOnly : false) &&
                        $this->validationDataType === SchemaValidator::VALIDATE_AS_REQUEST
                    )
                ) {
                    continue;
                }

                throw KeywordMismatch::fromKeyword(
                    'required',
                    $data,
                    sprintf("Required property '%s' must be present in the object", $reqProperty)
                )->withBreadCrumb($this->breadCrumb->addCrumb($reqProperty));
            }
        }
    }
}
