<?php

namespace ContactForm\Api\V1;

use ContactForm\Api\V1\ObjectTransformers\FieldTransformer;
use ContactForm\Api\V1\ObjectTransformers\FormTransformer;
use ContactForm\Api\V1\ObjectTransformers\SubmissionTransformer;

class ObjectTransformer
{
	const FORM_TRANSFORMER = 'Form';
	const FIELD_TRANSFORMER = 'Field';
	const SUBMISSION_TRANSFORMER = 'Submission';
	
	/**
	 * @param $jsonResponseData
	 *
	 * @param $type
	 *
	 * @return array
	 * @throws ApiException
	 */
	public static function transform($jsonResponseData, $type)
	{
		switch($type){
			case self::FORM_TRANSFORMER:
				return (new FormTransformer())->transform($jsonResponseData);
				break;
			case self::FIELD_TRANSFORMER:
				return (new FieldTransformer())->transform($jsonResponseData);
				break;
			case self::SUBMISSION_TRANSFORMER:
				return (new SubmissionTransformer())->transform($jsonResponseData);
				break;
			default:
				throw new ApiException('Transformer of type ' . $type . ' not recognized.');
		}
	}
}