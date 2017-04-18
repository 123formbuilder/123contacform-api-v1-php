<?php

use ContactForm\Api\V1\ApiClient;
use ContactForm\Api\V1\Resources\Users;

require_once '../vendor/autoload.php';

$apiClient = (new ApiClient())
	->withApiKey('APY-KEY-HERE');
$formId = 'FORM-ID-HERE';

$emailAddress = 'USER-EMAIL-HERE';

$form = (new Users($apiClient))
	->withEmailAddress($emailAddress)
	->getForm($formId);

echo $form->getId() . '. ' . $form->getName() . ' (' . $form->getNumberOfTotalSubmissions() . ')' . "<br />";