<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\spec\Schema as CebeSchema;
use cebe\openapi\league\schema\BreadCrumb;
use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use cebe\openapi\league\schema\Exception\SchemaMismatch;
use cebe\openapi\league\schema\SchemaValidator;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class Not extends BaseKeyword
{
    /** @var int this can be Validator::VALIDATE_AS_REQUEST or Validator::VALIDATE_AS_RESPONSE */
    protected $validationDataType;
    /** @var BreadCrumb */
    protected $dataBreadCrumb;

    public function __construct(CebeSchema $parentSchema, $type, BreadCrumb $breadCrumb)
    {
        parent::__construct($parentSchema);
        $this->validationDataType = $type;
        $this->dataBreadCrumb     = $breadCrumb;
    }

    /**
     * This keyword's value MUST be an object.
     * Inline or referenced schema MUST be of a Schema Object and not a standard JSON Schema.
     *
     * An instance is valid against this keyword if it fails to validate
     * successfully against the schema defined by this keyword.
     *
     * @param mixed $data
     *
     * @throws KeywordMismatch
     */
    public function validate($data, CebeSchema $not)
    {
        try {
            Validator::instance(CebeSchema::class)->assert($not);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        $schemaValidator = new SchemaValidator($this->validationDataType);

        try {
            $schemaValidator->validate($data, $not, $this->dataBreadCrumb);
        } catch (SchemaMismatch $e) {
            return;
        }

        throw KeywordMismatch::fromKeyword('not', $data, 'Data must not match the schema');
    }
}
