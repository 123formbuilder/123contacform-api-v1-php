<?php


namespace ContactForm\Api\V1\ObjectTransformers;


interface ObjectTransformerInterface
{
	/**
	 * @param $jsonResponseData
	 *
	 * @return array
	 */
	function transform($jsonResponseData);
}