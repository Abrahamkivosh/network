<?php

include("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include_once('library/config_read.php');
$log = "visited page: ";
include('include/config/logging.php');

include_once("library/functions.php");
include_once('lang/main.php');

$pathSMSService = "library/services/SMSService.php";
if (!file_exists($pathSMSService)) {
	die("File not found");
}
if (!class_exists('SMSService')) {
	include_once $pathSMSService;
	define('SMSSERVICE_INCLUDED', true);
}

// declaring variables
$logAction = "";
$logDebugSQL = "";


isset($_POST['contact']) ? $contact = $_POST['contact'] : $contact = "";
isset($_POST['message']) ? $message = $_POST['message'] : $message = "";

function selected_phone_number($mobilephone = null, $workphone = null, $homePhone)
{
	$phone = null;
	if (isset($mobilephone)) {
		# code...
		$phone = $mobilephone;
	} else if (isset($workphone)) {
		# code...
		$phone = $workphone;
	} else if (isset($homePhone)) {
		$phone = $homePhone;
	} else {
		$phone;
	}
	return  $phone;
}

$successMessage = null;
if (isset($_POST["submit"])) {

	include 'library/opendb.php';

	global $contact;
	global $message;
	$smsService = new SMSService();
	$userInfoTable = $configValues['CONFIG_DB_TBL_DALOUSERINFO'];
	$radCheckTable = $configValues['CONFIG_DB_TBL_RADCHECK'];


	try {
		switch ($contact) {
			case 'all_users':
				# code...
				# send SMS to all Users
				$sql = "SELECT username, mobilephone, workphone, homephone FROM $userInfoTable";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				while ($row = $res->fetchRow(PDO::FETCH_ASSOC)) {
					if (selected_phone_number($row['workphone'], $row['homephone'], $row['mobilephone'])) {
						$smsService->sendSMS($phone_number, trim($message));
					}
				}
				break;

			case 'active_users':
				# code...
				# send SMS to all Users
				$sql = "SELECT username, value, mobilephone, workphone, homephone FROM $radCheckTable INNER JOIN $userInfoTable  USING (username) WHERE attribute = 'Expiration'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				while ($row = $res->fetchRow(PDO::FETCH_ASSOC)) {
					$expiry = strtotime($row['value']);
					$ctime = time();
					if ($expiry > $ctime) {
						if (selected_phone_number($row['workphone'], $row['homephone'], $row['mobilephone'])) {
							$smsService->sendSMS($phone_number, trim($message));
						}
					}
				}
				break;

			case 'inactive_users':
				# code...
				# send SMS to all Users
				$sql = "SELECT username, value, mobilephone, workphone, homephone FROM $radCheckTable INNER JOIN $userInfoTable  USING (username) WHERE attribute = 'Expiration'";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				while ($row = $res->fetchRow(PDO::FETCH_ASSOC)) {
					$expiry = strtotime($row['value']);
					$ctime = time();
					if ($expiry < $ctime) {
						if (selected_phone_number($row['workphone'], $row['homephone'], $row['mobilephone'])) {
							$smsService->sendSMS($phone_number, trim($message));
						}
					}
				}
				break;

			default:
				# code...
				$sql = "SELECT username, mobilephone, workphone, homephone FROM $userInfoTable WHERE username= $dbSocket->escapeSimple($contact)";
				$result = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				if ($result->numRows() > 0) {
					$row = $result->fetchRow(PDO::FETCH_ASSOC);
					if (selected_phone_number($row['workphone'], $row['homephone'], $row['mobilephone'])) {
						$smsService->sendSMS($phone_number, trim($message));
					}
				} else {
					return false;
				}
				break;
		}
		$successMsg = "Message sent successfully";
	} catch (\Throwable $th) {
		//throw $th;
		$failureMsg = "Error : " . $th->getMessage();
	}
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	<title>SMS - <?php echo $configValues['SYSTEM_NAME'] ?>
	</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

	<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->


	<link rel="stylesheet" href="css/sms_style.css">
	<?php
	include_once "./include/management/populate_selectbox.php";

	?>
</head>

<?php

include("menu-sms.php");

?>

<div id="contentnorightbar">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo "SMS" ?>
			<h144>&#x2754;</h144>
		</a></h2>

	<div id="helpPage" style="display:none;visibility:visible">
		<?php echo t('helpPage', 'smsMain') ?>
		<br />
	</div>
	<?php
	include_once('include/management/actionMessages.php');
	?>


	<form name="smsForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div class="tabber">

			<div class="tabbertab" title="<?php echo t('title', 'SMS'); ?>">

				<fieldset>

					<h302> <?php echo t('title', 'SMS') ?> </h302>
					<br />
					<div class="row">

						<label for='contact' class='form'>Select Contact</label>

						<?php
						populate_username_full_names()
						?>
					</div>
					<div class="row">
						<label for='message' class='form'><?php echo "Message"; ?></label>
						<textarea name="message" class="success" id="message" cols="10" rows="5" aria-describedby="help-block" placeholder="Message Here......."></textarea>
						<span class="help-block">
							<p id="characterLeft" class="help-block ">You have reached the limit</p>
						</span>
					</div>

					<hr><br />

					<button type="submit" name="submit" id="btnSubmit" class="submit-button">Sent Message</button>

				</fieldset>


			</div>

		</div>
	</form>


</div>

<div id="footer">

	<?php
	include 'page-footer.php';
	?>

</div>

</div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="js/sms_send.js"></script>
</body>

</html>