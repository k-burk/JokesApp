<?php
include "db_connect.php";
echo "device confirm";
require_once 'googleLib/GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();

$sql = "SELECT * FROM users WHERE id='$_SESSION['userid']'";
$result = $mysqli->query($sql) or die (mysqli_error($mysqli));
if ($result == 1){
	$username = $mysqli->query("SELECT username FROM users WHERE id='$_SESSION['userid']'");
	$secret =  $mysqli->query("SELECT google_auth_code FROM users WHERE id='$_SESSION['userid']'");
	$qrCodeUrl = $ga->getQRCodeGoogleUrl($username, $secret,'Your Application Name');
	echo "QR code should work";
}
else{
	echo "An error with device confirmation";
}
?>

<div id="img">
    <img src='<?php echo $qrCodeUrl; ?>' />
</div>

<form method="post" action="index.php">
    <label>Enter Google Authenticator Code</label>
    <input type="text" name="code"/>
    <input type="submit" class="button">
</form>