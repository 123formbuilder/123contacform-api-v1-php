<?php


namespace ContactForm\Api\V1\ObjectTransformers;


use ContactForm\Api\V1\Models\SubmissionFieldModel;
use ContactForm\Api\V1\Models\SubmissionModel;

class SubmissionTransformer implements ObjectTransformerInterface
{
	/**
	 * @param $jsonResponseData
	 *
	 * @return array
	 */
	function transform($jsonResponseData)
	{
		$submissions = array();
		
		foreach($jsonResponseData->submissions as $submission){
			$submissionFields = [];
			foreach($submission->fields as $field)
				$submissionFields[] = new SubmissionFieldModel($field);
			
			$submission->fields = $submissionFields;
			
			$submissions[] = new SubmissionModel($submission);
		}
		
		return $submissions;
	}
}