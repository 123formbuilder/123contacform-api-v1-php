<?php


namespace ContactForm\Api\V1\Models;


class FormModel
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var string[]
	 */
	private $emails;
	
	/**
	 * @var string
	 */
	private $createdAt;
	
	/**
	 * @var string
	 */
	private $activeBetweenDateStart;
	
	/**
	 * @var string
	 */
	private $activeBetweenDateEnd;
	
	/**
	 * @var string
	 */
	private $encoding;
	
	/**
	 * @var string
	 */
	private $redirectMessage;
	
	/**
	 * @var array
	 */
	private $redirectUrl;
	
	/**
	 * @var int
	 */
	private $numberOfSubmissionsToday;
	
	/**
	 * @var int
	 */
	private $numberOfTotalSubmissions;
	
	/**
	 * FormModel constructor.
	 *
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->id                       = (int) $data->formId;
		$this->name                     = (string) $data->formName;
		$this->emails                   = $data->formEmails;
		$this->createdAt                = (string) $data->formCreated;
		$this->activeBetweenDateStart   = (string) $data->formDateStart;
		$this->activeBetweenDateEnd     = (string) $data->formDateEnd;
		$this->encoding                 = (string) $data->formEncoding;
		$this->redirectMessage          = (string) $data->formRedirectMessage;
		$this->redirectUrl              = $data->formRedirectUrl;
		$this->numberOfSubmissionsToday = (int) $data->formSubmissionsToday;
		$this->numberOfTotalSubmissions = (int) $data->formSubmissionsTotal;
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
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @return \string[]
	 */
	public function getEmails()
	{
		return $this->emails;
	}
	
	/**
	 * @return string
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}
	
	/**
	 * @return string
	 */
	public function getActiveBetweenDateStart()
	{
		return $this->activeBetweenDateStart;
	}
	
	/**
	 * @return string
	 */
	public function getActiveBetweenDateEnd()
	{
		return $this->activeBetweenDateEnd;
	}
	
	/**
	 * @return string
	 */
	public function getEncoding()
	{
		return $this->encoding;
	}
	
	/**
	 * @return string
	 */
	public function getRedirectMessage()
	{
		return $this->redirectMessage;
	}
	
	/**
	 * @return array
	 */
	public function getRedirectUrl()
	{
		return $this->redirectUrl;
	}
	
	/**
	 * @return int
	 */
	public function getNumberOfSubmissionsToday()
	{
		return $this->numberOfSubmissionsToday;
	}
	
	/**
	 * @return int
	 */
	public function getNumberOfTotalSubmissions()
	{
		return $this->numberOfTotalSubmissions;
	}
}