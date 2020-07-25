<?php
session_start();
?>
<?php
if(isset($_POST['button'])){
//input from the form
$country_code=filter_input(INPUT_POST,'cc');
$phone_number=filter_input(INPUT_POST,'pn');
$channel=filter_input(INPUT_POST,'ch');
$length=filter_input(INPUT_POST,'l');

//API URL
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$auth_id =getenv('AUTH_ID');
$secret_id=getenv('SECRET_ID');
$url = 'https://api.tiniyo.com/v1/Account/'.$auth_id.'/Verifications';
//create a new cURL resource
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_VERBOSE, true);

//setup request to send json via POST
$x=$country_code.$phone_number;

$_SESSION["phonenumber"]=$x;

$data=array("channel"=> $channel,"dst"=> $x,"length"=> $length);

$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, "$auth_id:$secret_id" );
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
			/**if ( $resp->status == "success" ) {
				echo "Message sent successfully\n";
			}**/
		} else {
			echo "Message sent Failed\n";	
		}
	break;
	default:
		echo 'Http Error: ' . $httpCode . ' : ' . curl_error($ch);
	break;
}

//close cURL resource
curl_close($ch);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Phone Verification</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.min.css">
    </head>

    <body>
        <header class="site-home-header">
            <div class="outer site-header-background no-image">        
                <div class="inner">
                    <div class="site-header-content">
                        <h1 class="site-title">
                            <img class="site-logo" src="https://blog.tiniyo.com/content/images/2020/03/logo.png" alt="Tiniyo Phone Verification">
                        </h1>
                        <h2 class="site-description">Phone Verification</h2>
                        <p class="site-sub-description">How to use Tiniyo <a id="tiniyo-link" href="https://tiniyo.com/dist/index-verify.html#section/Introduction"> VERIFICATION API </a> in real time.</p> 
                    </div>
                </div>
            </div>
        </header>
        <form action="result.php" accept-charset="UTF-8" method="POST">
          <div class="container">
            <ul>
            <li>
              <div>
                <input name="otp" placeholder="Enter the OTP code you were sent:" type="text">
              </div>
            </li>
            <li>
              <button name="button1" type="submit">VERIFY</button>
            </li>
            </ul>
          </div>
        </form>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.min.js"></script>
    </body>
</html>
