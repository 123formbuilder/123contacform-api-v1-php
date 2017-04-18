<?php
$apiKey="your-api-key-here"; //replace it with your own API key from "My Account" page
$curl_post_string="apiKey=".$apiKey;

/*————————-Step 1————————-*/
$url="https://www.123contactform.com/api/forms.xml";
$user_forms_xml=getCurlContentString($url, $curl_post_string);

$doc = new DOMDocument();
$doc->loadXML($user_forms_xml);

$root = $doc->documentElement;
if ($root->nodeName=="errorMessage") 
{
	die($root->nodeName.": ".$root->nodeValue);
}

/*————————-Step 2————————-*/
$firstFormXml="";
foreach ($root->childNodes as $child) 
{
	if ($child->nodeType == 1) 
	{ 
		/*we make sure that the node is an element
		(not an attribute or a text node)*/
		$firstFormXml=$child;
		break;
	}
}

$firstForm=array();
if (!empty($firstFormXml)) 
{
	foreach ($firstFormXml->childNodes as $fieldNode) 
	{
		if ($fieldNode->nodeType == 1) 
		{
			if ($fieldNode->nodeName == "formEmails") 
			{ 	
				//<formEmails> has <email> children
				$firstForm[$fieldNode->nodeName]=array();
				$emails_array=array();
				foreach ($fieldNode->childNodes as $sub_child) 
				{
					$sub_child_value=trim($sub_child->nodeValue);
					if (!empty($sub_child_value)) 
					{
						$emails_array[] = $sub_child_value;
					}
				}
				$firstForm[$fieldNode->nodeName]=$emails_array;
			} 
			else 
			{
				$firstForm[$fieldNode->nodeName] = $fieldNode->nodeValue;
			}
		}
	}
}

echo "First form:";
print_r($firstForm);

/*————————-Step 3————————-*/
$firstFormId=$firstForm["formId"];
$url="https://www.123contactform.com/api/forms/$firstFormId/submissions/count.xml";
$submissions_count_xml=getCurlContentString($url, $curl_post_string);

$doc = new DOMDocument();
$doc->loadXML($submissions_count_xml);

$root = $doc->documentElement;

if ($root->nodeName=="errorMessage") 
{
	die($root->nodeName.": ".$root->nodeValue);
}
$submissionsCount="";
foreach ($root->childNodes as $child) 
{ 	
	if ($child->nodeType == 3) 
	{ 
		//we make sure that it's a text node
		$submissionsCount=$child->nodeValue;
		break;
	}
}
echo "<br /><br />";
echo "Number of submissions: ".$submissionsCount;

/*————————-Step 4————————-*/
$pageNrArray=array(0,1,2,3);
$pageSize=50;
$last_200_submissions=array();
foreach ($pageNrArray as $key=>$pageNr) 
{
	$url="https://www.123contactform.com/api/forms/$firstFormId/submissions.xml";
	$submissions_xml=getCurlContentString($url,
	$curl_post_string."&pageNr=$pageNr&pageSize=$pageSize&sort=DESC");

	$doc = new DOMDocument();
	$doc->loadXML($submissions_xml);

	$root = $doc->documentElement;

	if ($root->nodeName=="errorMessage") 
	{
		die($root->nodeName.": ".$root->nodeValue);
	}

	foreach ($root->childNodes as $child) 
	{
		//we make sure that the node is an element (not an attribute or a text node):
		if ($child->nodeType == 1 && $child->nodeName == "submission") 
		{
			$new_submission=array();
			$new_submission_fields=array();
			foreach ($child->childNodes as $sub_child) 
			{
				if ($sub_child->nodeType==1) 
				{
					foreach ($sub_child->childNodes as $sub_node) 
					{
						if ($sub_node->nodeType==3) 
						{
							$new_submission[$sub_child->nodeName]=$sub_node->nodeValue;
						} 
						elseif ($sub_node->nodeType==1 && $sub_node->nodeName=="field") 
						{
							foreach ($sub_node->childNodes as $child_node) 
							{
								if ($child_node->nodeType==1) 
								{
									$field_name=$child_node->nodeName;
									$field_value=$child_node->nodeValue;
									$new_submission_field[$field_name]=$field_value;
								}
							}
							$new_submission_fields[]=$new_submission_field;
						}
					}
				}
			}
			$new_submission["fields"] = $new_submission_fields;
			$last_200_submissions[] = $new_submission;
		}
	}
}
echo "<br /><br /><br />";
echo "Last 200 submissions:";
print_r($last_200_submissions);

/*————————-Step 5————————-*/
$url="https://www.123contactform.com/api/forms/$firstFormId/webhooks.xml";
$webhook_url="http://www.google.com"; //replace google.com with the desired webhook URL
$post_webhook_xml=getCurlContentString($url, $curl_post_string."&webhookUrl=".
urlencode($webhook_url));

echo "<br /><br /><br />";
echo "Posting a webhook to the form (URL: http://www.google.com)…";

$doc = new DOMDocument();
$doc->loadXML($post_webhook_xml);

$root = $doc->documentElement;

if ($root->nodeName=="errorMessage") 
{
	echo "<br /><br />";
	die($root->nodeName.": ".$root->nodeValue);
}
$message="";
foreach ($root->childNodes as $child) 
{ 
	if ($child->nodeType == 3) 
	{ 
		//we make sure that it's a text node
		$message=$child->nodeValue;
		break;
	}
}
echo "<br /><br />";
echo "Message: ".$message;

/*————————-Step 6————————-*/
$subuserEmail="subuser-email-address-here";
$subuserEmailEncoded=urlencode($subuserEmail);
$url="https://www.123contactform.com/api/subusers/$subuserEmailEncoded/forms.xml";
$user_forms_xml=getCurlContentString($url, $curl_post_string);

$doc = new DOMDocument();
$doc->loadXML($user_forms_xml);

$root = $doc->documentElement;
if ($root->nodeName=="errorMessage") 
{
	die($root->nodeName.": ".$root->nodeValue);
}

$subuserForms=array();
if (!empty($root->childNodes)) 
{
	foreach ($root->childNodes as $formNode) 
	{
		$subuserFormArray=array();
		if ($formNode->nodeType == 1) 
		{
			foreach ($formNode->childNodes as $fieldNode) 
			{
				if ($fieldNode->nodeType == 1) 
				{
					if ($fieldNode->nodeName == "formEmails")
					{ 
						//<formEmails> has <email> children
						$subuserFormArray[$fieldNode->nodeName]=array();
						$emails_array=array();
						foreach ($fieldNode->childNodes as $sub_child) 
						{
							$sub_child_value=trim($sub_child->nodeValue);
							if (!empty($sub_child_value)) 
							{
								$emails_array[] = $sub_child_value;
							}
						}
						$subuserFormArray[$fieldNode->nodeName]=$emails_array;
					} 
					else 
					{
						$subuserFormArray[$fieldNode->nodeName] = $fieldNode->nodeValue;
					}
				}
			}
		}
		if (!empty($subuserFormArray)) {
		$subuserForms[]=$subuserFormArray;
		}
	}
}

echo "<br /><br /><br />";
echo "Forms of subuser with e-mail $subuserEmail:";
print_r($subuserForms);

//function used to make an API call
function getCurlContentString($url, $curl_post_string) 
{
	$ch = curl_init($url);
	$fp = fopen("script_api_cache.txt", "w");
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_post_string);

	curl_exec($ch);
	curl_close($ch);
	fclose($fp);

	$page_string = file_get_contents("script_api_cache.txt");

	return $page_string;
}
?>