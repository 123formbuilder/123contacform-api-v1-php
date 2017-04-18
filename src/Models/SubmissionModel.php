<?php


namespace ContactForm\Api\V1\Models;


class SubmissionModel
{
	/**
	 * @var string
	 */
	private $id;
	
	/**
	 * @var SubmissionFieldModel[]
	 */
	private $fields;
	
	/**
	 * @var string
	 */
	private $date;
	
	/**
	 * @var string
	 */
	private $ip;
	
	/**
	 * @var string
	 */
	private $countryCode;
	
	/**
	 * @var string
	 */
	private $referrer;
	
	/**
	 * @var string
	 */
	private $referrerId;
	
	/**
	 * @var string
	 */
	private $couponCode;
	
	/**
	 * @var string
	 */
	private $browser;
	
	/**
	 * @var int
	 */
	private $quizScore;
	
	/**
	 * @var string
	 */
	private $language;
	
	/**
	 * @var string
	 */
	private $formHost;
	
	/**
	 * @var int
	 */
	private $approved;
	
	/**
	 * @var bool
	 */
	private $paymentDone;
	
	/**
	 * @var string
	 */
	private $paymentType;
	
	/**
	 * @var string
	 */
	private $paymentAmount;
	
	/**
	 * @var string
	 */
	private $paymentCurrency;
	
	/**
	 * @var string
	 */
	private $paymentProcessorSelected;
	
	/**
	 * SubmissionModel constructor.
	 *
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->id                       = (string) $data->xml_id;
		$this->fields                   = (array) $data->fields;
		$this->date                     = (string) $data->date;
		$this->ip                       = (string) $data->ip;
		$this->countryCode              = (string) $data->cc;
		$this->referrer                 = (string) $data->referer;
		$this->referrerId               = (string) $data->refid;
		$this->couponCode               = (string) $data->couponcode;
		$this->browser                  = (string) $data->browser;
		$this->quizScore                = (int) $data->quizScore;
		$this->language                 = (string) $data->lang;
		$this->formHost                 = (string) $data->formhost;
		$this->approved                 = (int) $data->approved;
		$this->paymentDone              = (bool) $data->paymdone;
		$this->paymentType              = (string) $data->paymtype;
		$this->paymentAmount            = (string) $data->paymsum;
		$this->paymentCurrency          = (string) $data->paymcur;
		$this->paymentProcessorSelected = (string) $data->paymsel;
	}
	
	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return array|SubmissionFieldModel[]
	 */
	public function getFields()
	{
		return $this->fields;
	}
	
	/**
	 * @return string
	 */
	public function getDate()
	{
		return $this->date;
	}
	
	/**
	 * @return string
	 */
	public function getIp()
	{
		return $this->ip;
	}
	
	/**
	 * @return string
	 */
	public function getCountryCode()
	{
		return $this->countryCode;
	}
	
	/**
	 * @return string
	 */
	public function getReferrer()
	{
		return $this->referrer;
	}
	
	/**
	 * @return string
	 */
	public function getReferrerId()
	{
		return $this->referrerId;
	}
	
	/**
	 * @return string
	 */
	public function getCouponCode()
	{
		return $this->couponCode;
	}
	
	/**
	 * @return string
	 */
	public function getBrowser()
	{
		return $this->browser;
	}
	
	/**
	 * @return int
	 */
	public function getQuizScore()
	{
		return $this->quizScore;
	}
	
	/**
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->language;
	}
	
	/**
	 * @return string
	 */
	public function getFormHost()
	{
		return $this->formHost;
	}
	
	/**
	 * @return int
	 */
	public function getApproved()
	{
		return $this->approved;
	}
	
	/**
	 * @return bool
	 */
	public function isPaymentDone()
	{
		return $this->paymentDone;
	}
	
	/**
	 * @return string
	 */
	public function getPaymentType()
	{
		return $this->paymentType;
	}
	
	/**
	 * @return string
	 */
	public function getPaymentAmount()
	{
		return $this->paymentAmount;
	}
	
	/**
	 * @return string
	 */
	public function getPaymentCurrency()
	{
		return $this->paymentCurrency;
	}
	
	/**
	 * @return string
	 */
	public function getPaymentProcessorSelected()
	{
		return $this->paymentProcessorSelected;
	}
}