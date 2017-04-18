<?php

namespace ContactForm\Api\V1\ObjectTransformers;

use ContactForm\Api\V1\Models\FormModel;

class FormTransformer implements ObjectTransformerInterface
{
	
	/**
	 * @param $jsonResponseData
	 *
	 * @return array
	 */
	function transform($jsonResponseData)
	{
		$forms = array();
		
		foreach($jsonResponseData->forms as $jsonDecodedForm)
			$forms[] = new FormModel((object) $jsonDecodedForm);
		
		return $forms;
	}
}