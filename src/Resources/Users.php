<?php


namespace ContactForm\Api\V1\Resources;


use ContactForm\Api\V1\ApiClient;
use ContactForm\Api\V1\ApiException;
use ContactForm\Api\V1\Models\FormModel;
use ContactForm\Api\V1\ObjectTransformer;

class Users
{
	/**
	 * API Client
	 * @var ApiClient instance of the ApiClient
	 */
	private $apiClient;
	
	/**
	 * @var string
	 */
	private $emailAddress;
	
	/**
	 * @param $emailAddress
	 *
	 * @return $this
	 */
	public function withEmailAddress($emailAddress)
	{
		$this->emailAddress = $emailAddress;
		return $this;
	}
	
	/**
	 * Constructor
	 * @param ApiClient|null $apiClient The api client to use
	 */
	function __construct($apiClient = null)
	{
		if ($apiClient == null) {
			$apiClient = new ApiClient();
		}
		
		$this->apiClient = $apiClient;
	}
	
	/**
	 * @return FormModel[]
	 * @throws ApiException
	 */
	public function getForms(){
		
		if (empty($this->emailAddress)) {
			throw new \InvalidArgumentException('Missing the required parameter emailAddress when calling getForms');
		}
		
		$resourcePath = "/subusers/{$this->emailAddress}/forms.json";
		
		list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, 'GET');
		
		if(!$response || isset($response->errorMessage)){
			
			$errorMessage = isset($response->errorMessage) ? $response->errorMessage : ApiException::UNKNOWN_API_EXCEPTION;
			
			throw new ApiException($errorMessage, $statusCode, $httpHeader);
			
		}
		
		return ObjectTransformer::transform($response, ObjectTransformer::FORM_TRANSFORMER);
	}
	
	/**
	 * @param $formId
	 *
	 * @return FormModel
	 * @throws ApiException
	 */
	public function getForm($formId){
		
		if (!is_numeric($formId)) {
			throw new \InvalidArgumentException('Invalid $formId parameter type when calling getForm');
		}
		
		if (empty($this->emailAddress)) {
			throw new \InvalidArgumentException('Missing the required parameter emailAddress when calling getForm');
		}
		
		$resourcePath = "/subusers/{$this->emailAddress}/forms/{$formId}.json";
		
		list($response, $statusCode, $httpHeader) = $this->apiClient->callApi($resourcePath, 'GET');
		
		if(!$response || isset($response->errorMessage)){
			
			$errorMessage = isset($response->errorMessage) ? $response->errorMessage : ApiException::UNKNOWN_API_EXCEPTION;
			
			throw new ApiException($errorMessage, $statusCode, $httpHeader);
			
		}
		
		return current(ObjectTransformer::transform($response, ObjectTransformer::FORM_TRANSFORMER));
	}
}