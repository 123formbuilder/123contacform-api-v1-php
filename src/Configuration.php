<?php


namespace ContactForm\Api\V1;


class Configuration
{
	/**
	 * @var Configuration
	 */
	private static $_defaultConfiguration;
	
	/**
	 * @var string[]
	 */
	protected $apiKey;
	
	/**
	 * The default instance of ApiClient
	 *
	 * @var array
	 */
	protected $defaultHeaders = array();
	
	/**
	 * The host
	 *
	 * @var string
	 */
	protected $host = 'https://www.123contactform.com/api';
	
	/**
	 * Timeout (second) of the HTTP request, by default set to 0, no timeout
	 *
	 * @var string
	 */
	protected $curlTimeout = 0;
	
	/**
	 * User agent of the HTTP request, set to "ContactForm-PHP-SDK/1.0.0" by default
	 *
	 * @var string
	 */
	protected $userAgent = "ContactForm-PHP-SDK/1.0.0";
	
	/**
	 * Debug switch (default set to false)
	 *
	 * @var bool
	 */
	protected $debug = false;
	
	/**
	 * Debug file location (log to STDOUT by default)
	 *
	 * @var string
	 */
	protected $debugFile = 'php://output';
	
	/**
	 * Debug file location (log to STDOUT by default)
	 *
	 * @var string
	 */
	protected $tempFolderPath;
	
	/**
	 * Indicates if SSL verification should be enabled or disabled.
	 *
	 * This is useful if the host uses a self-signed SSL certificate.
	 *
	 * @var boolean True if the certificate should be validated, false otherwise.
	 */
	protected $sslVerification = false;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->tempFolderPath = sys_get_temp_dir();
	}
	
	/**
	 * Sets API key
	 *
	 * @param string $key              API key or token
	 *
	 * @return Configuration
	 */
	public function setApiKey($key)
	{
		$this->apiKey = $key;
		return $this;
	}
	
	/**
	 * Gets API key
	 *
	 * @return string API key
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}
	
	/**
	 * Adds a default header
	 *
	 * @param string $headerName  header name (e.g. Token)
	 * @param string $headerValue header value (e.g. 1z8wp3)
	 *
	 * @return Configuration
	 */
	public function addDefaultHeader($headerName, $headerValue)
	{
		if (!is_string($headerName)) {
			throw new \InvalidArgumentException('Header name must be a string.');
		}
		$this->defaultHeaders[$headerName] =  $headerValue;
		return $this;
	}
	
	/**
	 * Gets the default header(s)
	 *
	 * @return array An array of default header(s)
	 */
	public function getDefaultHeaders()
	{
		return $this->defaultHeaders;
	}
	
	/**
	 * Deletes a default header
	 *
	 * @param string $headerName the header to delete
	 */
	public function deleteDefaultHeader($headerName)
	{
		unset($this->defaultHeaders[$headerName]);
	}
	
	/**
	 * Sets the host
	 *
	 * @param string $host Host
	 *
	 * @return Configuration
	 */
	public function setHost($host)
	{
		$this->host = $host;
		return $this;
	}
	
	/**
	 * Gets the host
	 *
	 * @return string Host
	 */
	public function getHost()
	{
		return $this->host;
	}
	
	/**
	 * Sets the user agent of the api client
	 *
	 * @param string $userAgent the user agent of the api client
	 *
	 * @return Configuration
	 */
	public function setUserAgent($userAgent)
	{
		if (!is_string($userAgent)) {
			throw new \InvalidArgumentException('User-agent must be a string.');
		}
		$this->userAgent = $userAgent;
		return $this;
	}
	
	/**
	 * Gets the user agent of the api client
	 *
	 * @return string user agent
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}
	
	/**
	 * Sets the HTTP timeout value
	 *
	 * @param integer $seconds Number of seconds before timing out [set to 0 for no timeout]
	 *
	 * @return Configuration
	 */
	public function setCurlTimeout($seconds)
	{
		if (!is_numeric($seconds) || $seconds < 0) {
			throw new \InvalidArgumentException('Timeout value must be numeric and a non-negative number.');
		}
		$this->curlTimeout = $seconds;
		return $this;
	}
	
	/**
	 * Gets the HTTP timeout value
	 *
	 * @return string HTTP timeout value
	 */
	public function getCurlTimeout()
	{
		return $this->curlTimeout;
	}
	
	/**
	 * Sets debug flag
	 *
	 * @param bool $debug Debug flag
	 *
	 * @return Configuration
	 */
	public function setDebug($debug)
	{
		$this->debug = $debug;
		return $this;
	}
	
	/**
	 * Gets the debug flag
	 *
	 * @return bool
	 */
	public function getDebug()
	{
		return $this->debug;
	}
	
	/**
	 * Sets the debug file
	 *
	 * @param string $debugFile Debug file
	 *
	 * @return Configuration
	 */
	public function setDebugFile($debugFile)
	{
		$this->debugFile = $debugFile;
		return $this;
	}
	
	/**
	 * Gets the debug file
	 *
	 * @return string
	 */
	public function getDebugFile()
	{
		return $this->debugFile;
	}
	
	/**
	 * Sets the temp folder path
	 *
	 * @param string $tempFolderPath Temp folder path
	 *
	 * @return Configuration
	 */
	public function setTempFolderPath($tempFolderPath)
	{
		$this->tempFolderPath = $tempFolderPath;
		return $this;
	}
	
	/**
	 * Gets the temp folder path
	 *
	 * @return string Temp folder path
	 */
	public function getTempFolderPath()
	{
		return $this->tempFolderPath;
	}
	
	/**
	 * Sets if SSL verification should be enabled or disabled
	 *
	 * @param boolean $sslVerification True if the certificate should be validated, false otherwise
	 *
	 * @return Configuration
	 */
	public function setSSLVerification($sslVerification)
	{
		$this->sslVerification = $sslVerification;
		return $this;
	}
	
	/**
	 * Gets if SSL verification should be enabled or disabled
	 *
	 * @return boolean True if the certificate should be validated, false otherwise
	 */
	public function getSSLVerification()
	{
		return $this->sslVerification;
	}
	
	/**
	 * Gets the default configuration instance
	 *
	 * @return Configuration
	 */
	public static function getDefaultConfiguration()
	{
		if (self::$_defaultConfiguration == null) {
			self::$_defaultConfiguration = new static();
		}
		return self::$_defaultConfiguration;
	}
	
	/**
	 * Sets the default configuration instance
	 *
	 * @param Configuration $config An instance of the Configuration Object
	 *
	 * @return void
	 */
	public static function setDefaultConfiguration(Configuration $config)
	{
		self::$_defaultConfiguration = $config;
	}
	
	/**
	 * Gets the essential information for debugging
	 *
	 * @return string The report for debugging
	 */
	public static function toDebugReport()
	{
		$report  = "PHP SDK (ContactForm\\Client) Debug Report:\n";
		$report .= "    OS: ".php_uname()."\n";
		$report .= "    PHP Version: ".phpversion()."\n";
		$report .= "    SDK Package Version: 1.0.0\n";
		$report .= "    Temp Folder Path: ".self::getDefaultConfiguration()->getTempFolderPath()."\n";
		return $report;
	}
}