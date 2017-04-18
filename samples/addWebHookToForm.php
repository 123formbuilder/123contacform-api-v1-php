<?php

use ContactForm\Api\V1\ApiClient;
use ContactForm\Api\V1\Resources\Forms;

require_once '../vendor/autoload.php';

$apiClient = (new ApiClient())
	->withApiKey('APY-KEY-HERE');
$formId = 'FORM-ID-HERE';
$webHookUrl = 'WEBHOOK-URL-HERE';

$responseMessage = (new Forms($apiClient))->addWebHook($formId, $webHookUrl);