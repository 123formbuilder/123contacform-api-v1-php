<?php

use ContactForm\Api\V1\ApiClient;
use ContactForm\Api\V1\Resources\Forms;

require_once '../vendor/autoload.php';

$apiClient = (new ApiClient())
	->withApiKey('APY-KEY-HERE');

$forms = (new Forms($apiClient))->getForms();

foreach($forms as $form){
	echo $form->getId() . '. ' . $form->getName() . ' (' . $form->getNumberOfTotalSubmissions() . ')' . "<br />";
}