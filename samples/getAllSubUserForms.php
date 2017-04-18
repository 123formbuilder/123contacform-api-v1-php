<?php

use ContactForm\Api\V1\ApiClient;
use ContactForm\Api\V1\Resources\Users;

require_once '../vendor/autoload.php';

$apiClient = (new ApiClient())
	->withApiKey('APY-KEY-HERE');

$emailAddress = 'USER-EMAIL-HERE';

$forms = (new Users($apiClient))
	->withEmailAddress($emailAddress)
	->getForms();

foreach($forms as $form){
	echo $form->getId() . '. ' . $form->getName() . ' (' . $form->getNumberOfTotalSubmissions() . ')' . "<br />";
}