<?php

namespace cebe\openapi\league\schema\Keywords;

use cebe\openapi\spec\Schema as CebeSchema;
use cebe\openapi\league\schema\BreadCrumb;
use cebe\openapi\league\schema\Exception\InvalidSchema;
use cebe\openapi\league\schema\Exception\KeywordMismatch;
use cebe\openapi\league\schema\Exception\NotEnoughValidSchemas;
use cebe\openapi\league\schema\Exception\SchemaMismatch;
use cebe\openapi\league\schema\SchemaValidator;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Validator;

class AnyOf extends BaseKeyword
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
     * This keyword's value MUST be an array.  This array MUST have at least
     * one element.
     *
     * Inline or referenced schema MUST be of a Schema Object and not a standard JSON Schema.
     *
     * An instance validates successfully against this keyword if it
     * validates successfully against at least one schema defined by this
     * keyword's value.
     *
     * @param mixed        $data
     * @param CebeSchema[] $anyOf
     *
     * @throws KeywordMismatch
     */
    public function validate($data, array $anyOf)
    {
        try {
            Validator::arrayVal()->assert($anyOf);
            Validator::each(Validator::instance(CebeSchema::class))->assert($anyOf);
        } catch (ExceptionInterface $e) {
            throw InvalidSchema::becauseDefensiveSchemaValidationFailed($e);
        }

        $innerExceptions = [];

        foreach ($anyOf as $schema) {
            $schemaValidator = new SchemaValidator($this->validationDataType);
            try {
                $schemaValidator->validate($data, $schema, $this->dataBreadCrumb);

                return;
            } catch (SchemaMismatch $e) {
                $innerExceptions[] = $e;
            }
        }

        throw NotEnoughValidSchemas::fromKeywordWithInnerExceptions(
            'anyOf',
            $data,
            $innerExceptions,
            'Data must match at least one schema'
        );
    }
}
