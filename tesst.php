<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
if($_POST['customer_first_name']){
$states = array(
'Alabama'=>'AL',
'Alaska'=>'AK',
'Arizona'=>'AZ',
'Arkansas'=>'AR',
'California'=>'CA',
'Colorado'=>'CO',
'Connecticut'=>'CT',
'Delaware'=>'DE',
'Florida'=>'FL',
'Georgia'=>'GA',
'Hawaii'=>'HI',
'Idaho'=>'ID',
'Illinois'=>'IL',
'Indiana'=>'IN',
'Iowa'=>'IA',
'Kansas'=>'KS',
'Kentucky'=>'KY',
'Louisiana'=>'LA',
'Maine'=>'ME',
'Maryland'=>'MD',
'Massachusetts'=>'MA',
'Michigan'=>'MI',
'Minnesota'=>'MN',
'Mississippi'=>'MS',
'Missouri'=>'MO',
'Montana'=>'MT',
'Nebraska'=>'NE',
'Nevada'=>'NV',
'New Hampshire'=>'NH',
'New Jersey'=>'NJ',
'New Mexico'=>'NM',
'New York'=>'NY',
'North Carolina'=>'NC',
'North Dakota'=>'ND',
'Ohio'=>'OH',
'Oklahoma'=>'OK',
'Oregon'=>'OR',
'Pennsylvania'=>'PA',
'Rhode Island'=>'RI',
'South Carolina'=>'SC',
'South Dakota'=>'SD',
'Tennessee'=>'TN',
'Texas'=>'TX',
'Utah'=>'UT',
'Vermont'=>'VT',
'Virginia'=>'VA',
'Washington'=>'WA',
'West Virginia'=>'WV',
'Wisconsin'=>'WI',
'Wyoming'=>'WY'
);
$sta = $_POST['address_province'];
$c = array("customer"=>array("first_name"=>$_POST['customer_first_name'],"last_name"=>$_POST['customer_last_name'],"email"=>$_POST['customer_email'],"phone"=>$_POST['customer_phone'],"verified_email"=>true,"note"=>$_POST['customer_message'],"addresses"=>array(array("address1"=>$_POST['address_address1'],"address2"=>$_POST['address_address2'],"city"=>$_POST['address_city'],"country"=>"united states","first_name"=>$_POST['customer_first_name'],"last_name"=>$_POST['customer_last_name'],"phone"=>$_POST['customer_phone'],"province"=>$_POST['address_province'],"zip"=>$_POST['address_zip'],"province_code"=>$states[$sta],"country_code"=>"US","country_name"=>"United States","default"=>true)),"metafields"=>array(array("key"=>"customer_legal_name","value"=>$_POST['customer_legal_name'],"value_type"=>"string","namespace"=>"global"),array("key"=>"customer_dba","value"=>$_POST['customer_DBA'],"value_type"=>"integer","namespace"=>"global"),array("key"=>"customer_mobile","value"=>$_POST['customer_mobile'],"value_type"=>"integer","namespace"=>"global"),array("key"=>"reselno","value"=>$_POST['customer_resell_certificate_number'],"value_type"=>"integer","namespace"=>"global"),array("key"=>"customer_date","value"=>$_POST['customer_date'],"value_type"=>"string","namespace"=>"global"),array("key"=>"resell_address_province","value"=>$_POST['resell_address_province'],"value_type"=>"string","namespace"=>"global"),array("key"=>"customer_taxid","value"=>$_POST['customer_taxid'],"value_type"=>"string","namespace"=>"global"),array("key"=>"customer_gpo","value"=>$_POST['customer_gpo'],"value_type"=>"string","namespace"=>"global"),array("key"=>"customer_website","value"=>$_POST['customer_website'],"value_type"=>"string","namespace"=>"global"),array("key"=>"customer_title","value"=>$_POST['customer_title'],"value_type"=>"string","namespace"=>"global")),"send_email_invite"=>true));
$ch = curl_init("https://4fd3cfaa660cbfa12a5798011646a5cc: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@acmepets.myshopify.com/admin/api/2020-07/customers.json");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($c)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
$response = curl_exec($ch);

echo $response;

// $arr = json_decode($response,true);

// if($arr['customer']['id'] != ""){
// 	$a = array("message"=>"success");
// }else{
// 	$a = array("message"=>"error");
// }
// echo json_encode($a);
}