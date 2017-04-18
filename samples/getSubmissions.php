<?php
use ContactForm\Api\V1\ApiClient;
use ContactForm\Api\V1\Resources\Forms;

require_once '../vendor/autoload.php';

$apiClient = (new ApiClient())
	->withApiKey('APY-KEY-HERE');
$formId = 'FORM-ID-HERE';

$submissions = (new Forms($apiClient))->getSubmissions($formId);

foreach($submissions as $submission){
	echo <<<HTML
		Id: {$submission->getId()} <br />
		Date: {$submission->getDate()} <br />
		Ip: {$submission->getIp()} <br />
		
		<br />
		Fields: <br />
		<ol>
HTML;
	
	foreach ($submission->getFields() as $field)
		echo '<li>' . $field->getId() . ' - ' . $field->getValue() . '</li>';
	
	echo <<<HTML
		</ol>
		-------------------------------------------------------------
		<br />
HTML;
}