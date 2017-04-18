<?php


namespace ContactForm\Api\V1\ObjectTransformers;


use ContactForm\Api\V1\Models\FieldModel;

class FieldTransformer implements ObjectTransformerInterface
{
	/**
	 * @param $jsonResponseData
	 *
	 * @return array
	 */
	function transform($jsonResponseData)
	{
		$fields = array();
		foreach($jsonResponseData->fields as $field)
			$fields[] = new FieldModel((object) $field);
		
		return $fields;
	}
}