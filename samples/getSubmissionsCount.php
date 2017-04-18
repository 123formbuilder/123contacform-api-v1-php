<?php

use ContactForm\Api\V1\ApiClient;
use ContactForm\Api\V1\Resources\Forms;

require_once '../vendor/autoload.php';

$apiClient = (new ApiClient())
	->withApiKey('APY-KEY-HERE');
$formId = 'FORM-ID-HERE';

$submissionsCount = (new Forms($apiClient))->getSubmissionsCount($formId);

echo 'Form #' . $formId . ' has ' . $submissionsCount . ' submissions.';