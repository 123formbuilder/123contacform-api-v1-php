<?php

namespace ContactForm\Api\V1;

class ApiClient
{
	public static $PATCH   = "PATCH";
	public static $POST    = "POST";
	public static $GET     = "GET";
	public static $HEAD    = "HEAD";
	public static $OPTIONS = "OPTIONS";
	public static $PUT     = "PUT";
	public static $DELETE  = "DELETE";
	
	/**
	 * Configuration
	 *
	 * @var Configuration
	 */
	protected $config;
	
	/**
	 * Constructor of the class
	 *
	 * @param Configuration $config config for this api client
	 */
	public function __construct(Configuration $config = null)
	{
		if ($config == null) {
			$config = Configuration::getDefaultConfiguration();
		}
		
		$this->config = $config;
	}
	
	/**
	 * Get the config
	 *
	 * @return Configuration
	 */
	public function getConfig()
	{
		return $this->config;
	}
	
	/**
	 * @param $apiKey
	 *
	 * @return $this
	 */
	public function withApiKey($apiKey)
	{
		$this->config->setApiKey($apiKey);
		
		return $this;
	}
	
	/**
	 * Make the HTTP call (Sync)
	 *
	 * @param string $resourcePath path to method endpoint
	 * @param string $method       method to call
	 * @param array  $queryParams  parameters to be place in query URL
	 * @param array  $postData     parameters to be placed in POST body
	 * @param array  $headerParams parameters to be placed in request header
	 *
	 * @throws ApiException on a non 2xx response
	 * @return mixed
	 */
	public function callApi($resourcePath, $method, $queryParams = null, $postData = null, $headerParams = null)
	{
		
		$headers = array();
		
		// construct the http header
		$headerParams = array_merge(
			(array) $this->config->getDefaultHeaders(),
			(array) $headerParams
		);
		
		foreach ($headerParams as $key => $val) {
			$headers[] = "$key: $val";
		}
		
		// form data
		if ($postData) {
			$postData = http_build_query($postData);
		}
		
		$url = $this->config->getHost() . $resourcePath;
		
		$curl = curl_init();
		
		// set timeout, if needed
		if ($this->config->getCurlTimeout() != 0) {
			curl_setopt($curl, CURLOPT_TIMEOUT, $this->config->getCurlTimeout());
		}
		
		// return the result on success, rather than just true
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		// disable SSL verification, if needed
		if ($this->config->getSSLVerification() == false) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		}
		
		//Adding apiKey to URL
		$url .= '?apiKey=' . $this->config->getApiKey();
		
		if (!empty($queryParams)) {
			$url = ($url . '&' . http_build_query($queryParams));
		}
		
		if ($method == self::$POST) {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		} elseif ($method == self::$HEAD) {
			curl_setopt($curl, CURLOPT_NOBODY, true);
		} elseif ($method == self::$OPTIONS) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "OPTIONS");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		} elseif ($method == self::$PATCH) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		} elseif ($method == self::$PUT) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		} elseif ($method == self::$DELETE) {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		} elseif ($method != self::$GET) {
			throw new ApiException('Method ' . $method . ' is not recognized.');
		}
		
		curl_setopt($curl, CURLOPT_URL, $url);
		
		// Set user agent
		curl_setopt($curl, CURLOPT_USERAGENT, $this->config->getUserAgent());
		
		// debugging for curl
		if ($this->config->getDebug()) {
			error_log("[DEBUG] HTTP Request body  ~BEGIN~\n" . print_r($postData, true) . "\n~END~\n", 3, $this->config->getDebugFile());
			
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			curl_setopt($curl, CURLOPT_STDERR, fopen($this->config->getDebugFile(), 'a'));
		} else {
			curl_setopt($curl, CURLOPT_VERBOSE, 0);
		}
		
		// obtain the HTTP response headers
		curl_setopt($curl, CURLOPT_HEADER, 1);
		
		// Make the request
		$response         = curl_exec($curl);
		$http_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$http_header      = $this->http_parse_headers(substr($response, 0, $http_header_size));
		$http_body        = substr($response, $http_header_size);
		$response_info    = curl_getinfo($curl);
		
		// debug HTTP response body
		if ($this->config->getDebug()) {
			error_log("[DEBUG] HTTP Response body ~BEGIN~\n" . print_r($http_body, true) . "\n~END~\n", 3, $this->config->getDebugFile());
		}
		
		// Handle the response
		if ($response_info['http_code'] == 0) {
			throw new ApiException("API call to $url timed out: " . serialize($response_info), 0, null, null);
		} elseif ($response_info['http_code'] >= 200 && $response_info['http_code'] <= 299) {
			
			$data = json_decode($http_body);
			if (json_last_error() > 0) { // if response is a string
				$data = $http_body;
			}
			
		} else {
			
			$data = json_decode($http_body);
			if (json_last_error() > 0) { // if response is a string
				$data = $http_body;
			}
			
			throw new ApiException(
				"[" . $response_info['http_code'] . "] Error connecting to the API ($url)",
				$response_info['http_code'], $http_header, $data
			);
		}
		
		return array($data, $response_info['http_code'], $http_header);
	}
	
	/**
	 * Return an array of HTTP response headers
	 *
	 * @param string $raw_headers A string of raw HTTP response headers
	 *
	 * @return string[] Array of HTTP response headers
	 */
	protected function http_parse_headers($raw_headers)
	{
		$headers = array();
		$key     = '';
		
		foreach (explode("\n", $raw_headers) as $i => $h) {
			$h = explode(':', $h, 2);
			
			if (isset($h[1])) {
				if (!isset($headers[$h[0]]))
					$headers[$h[0]] = trim($h[1]);
				elseif (is_array($headers[$h[0]])) {
					$headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
				} else {
					$headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1])));
				}
				
				$key = $h[0];
			} else
			{
				if (substr($h[0], 0, 1) == "\t")
					$headers[$key] .= "\r\n\t" . trim($h[0]);
				elseif (!$key)
					$headers[0] = trim($h[0]);
				trim($h[0]);
			}
		}
		
		return $headers;
	}
}