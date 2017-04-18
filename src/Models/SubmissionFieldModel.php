<?php


namespace ContactForm\Api\V1\Models;


class SubmissionFieldModel
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var string
	 */
	private $value;
	
	/**
	 * SubmissionFieldModel constructor.
	 *
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->id    = $data->fieldid;
		$this->value = $data->fieldvalue;
	}
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}
}