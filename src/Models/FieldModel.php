<?php


namespace ContactForm\Api\V1\Models;


class FieldModel
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var string
	 */
	private $title;
	
	/**
	 * @var string
	 */
	private $fieldInstructions;
	
	/**
	 * @var int
	 */
	private $fieldType;
	
	/**
	 * @var int
	 */
	private $fieldObject;
	
	/**
	 * @var string[]
	 */
	private $fieldValues;
	
	/**
	 * @var bool
	 */
	private $fieldRequired;
	
	/**
	 * FieldModel constructor.
	 *
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->id                = (int) $data->fieldId;
		$this->title             = (string) $data->fieldTitle;
		$this->fieldInstructions = (string) $data->fieldInstructions;
		$this->fieldType         = (int) $data->fieldType;
		$this->fieldObject       = (int) $data->fieldObject;
		$this->fieldValues       = explode('||', $data->fieldValues);
		$this->fieldRequired     = (bool) $data->fieldRequired;
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
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * @return string
	 */
	public function getFieldInstructions()
	{
		return $this->fieldInstructions;
	}
	
	/**
	 * @return int
	 */
	public function getFieldType()
	{
		return $this->fieldType;
	}
	
	/**
	 * @return int
	 */
	public function getFieldObject()
	{
		return $this->fieldObject;
	}
	
	/**
	 * @return string[]
	 */
	public function getFieldValues()
	{
		return $this->fieldValues;
	}
	
	/**
	 * @return bool
	 */
	public function getFieldRequired()
	{
		return $this->fieldRequired;
	}
}