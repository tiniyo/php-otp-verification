<?php
session_start();
?>
<?php
if(isset($_POST['button1'])){
//input from the form
$otp_code=filter_input(INPUT_POST,'otp');
print_r($_SESSION);
$phone_number=$_SESSION["phonenumber"];

echo $phone_number;

//API URL
$auth_id = '{AUTH_ID}';
$url = "https://api.tiniyo.com/v1/Account/".$auth_id."/VerificationsCheck";

//create a new cURL resource
$ch = curl_init($url);

// curl_setopt($ch, CURLOPT_VERBOSE, true);

//setup request to send json via POST
$data=array("code"=> $otp_code, "dst"=> $phone_number);

$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, '{SECRET_AUTH_ID}');
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");


//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set HTTP Header for POST request
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload))
);

//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
$returns = curl_exec($ch);
// check the HTTP Status code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
switch ($httpCode) {
	case 200: 
		$resp = json_decode($returns);
		if ($resp->status) {
			echo "Status: ".$resp->status." Message:".$resp->message."\n";
			if ( $resp->status == "success" ) {
				echo "OTP VERIFIED\n";
			}
		} else {
			echo "OTP Verification Failed\n";	
		}
	break;
	default:
		echo 'Http Error: ' . $httpCode . ' : ' . curl_error($ch);
	break;
}

//close cURL resource
curl_close($ch);
exit();
}
?>