<head>
<?php
require_once 'googleLib/GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();

function GoogleCode($userDetails){
	
}

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db_connect.php";
$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);

//echo "You attempted login with " .$username . " and " .$password;

//search database for the user
$stmt = $mysqli->prepare("SELECT id, username, password, google_auth_code FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

$stmt->execute();
$stmt->store_result();

$stmt->bind_result($userid, $username, $pw, $secret);

//checking google auth code


if($stmt->num_rows ==1){
	echo "i found one user";
	$stmt->fetch();
		
		//storing username and user id for session
		$_SESSION['username'] = $username;
		$_SESSION['userid'] = $userid; 
		//Storing Google authentication code
		$_SESSION['google_auth_code']=$secret;
		

		/*if($_POST['code'])
		{
		$code=$_POST['code'];
		require_once 'googleLib/GoogleAuthenticator.php';
		$ga = new GoogleAuthenticator();
		$checkResult = $ga->verifyCode($secret, $code, 2);    // 2 = 2*30sec clock tolerance

		if ($checkResult)
		{
		$_SESSION['googleCode']=$code;
		echo"Login success<br>";
		}
		else
		{
		echo 'FAILED';
		session_destroy();
		}
		}
		*/
	
		
		
	}
else{
	$_SESSION = [];
	  session_destroy();
}
  
  echo "SESSION = <br>";
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
  
  // Device Confirmation -- if user exists
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($username, $secret, 'Jokes');
        

  
 ?>
//HTML Code
<!-- Display QR code for authentication -->
        <div id="img">
            <img src='<?php echo $qrCodeUrl; ?>' /><br>
        </div>
<h1>Welcome <?php echo $username; ?></h1>
<a href="<?php echo BASE_URL; ?>logout.php">Logout</a>
