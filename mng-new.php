<?php
/*
 *********************************************************************************************************
 * daloRADIUS - RADIUS Web Platform
 * Copyright (C) 2007 - Liran Tal <liran@enginx.com> All Rights Reserved.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 *********************************************************************************************************
 *
 * Authors:	Liran Tal <liran@enginx.com>
 *
 *********************************************************************************************************
 */

include("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include_once("include/management/pages_common.php");
include('library/check_operator_perm.php');
include_once("library/functions.php");
include_once('lang/main.php');

// declaring variables
$logAction = "";
$logDebugSQL = "";


isset($_POST['username']) ? $username = $_POST['username'] : $username = "";
isset($_POST['password']) ? $password = $_POST['password'] : $password = "";
isset($_POST['planName']) ? $planName = $_POST['planName'] : $planName = "";
isset($_POST['profiles']) ? $profiles = $_POST['profiles'] : $profiles = "";

isset($_POST['passwordType']) ? $passwordtype = $_POST['passwordType'] : $passwordtype = "";
// isset($_POST['notificationWelcome']) ? $notificationWelcome = $_POST['notificationWelcome'] : $notificationWelcome = "";


isset($_POST['bi_contactperson']) ? $bi_contactperson = $_POST['bi_contactperson'] : $bi_contactperson = "";
isset($_POST['bi_company']) ? $bi_company = $_POST['bi_company'] : $bi_company = "";
isset($_POST['bi_email']) ? $bi_email = $_POST['bi_email'] : $bi_email = "";
isset($_POST['bi_phone']) ? $bi_phone = $_POST['bi_phone'] : $bi_phone = "";
isset($_POST['bi_address']) ? $bi_address = $_POST['bi_address'] : $bi_address = "";
isset($_POST['bi_city']) ? $bi_city = $_POST['bi_city'] : $bi_city = "";
isset($_POST['bi_state']) ? $bi_state = $_POST['bi_state'] : $bi_state = "";
isset($_POST['bi_country']) ? $bi_country = $_POST['bi_country'] : $bi_country = "";
isset($_POST['bi_zip']) ? $bi_zip = $_POST['bi_zip'] : $bi_zip = "";
isset($_POST['bi_paymentmethod']) ? $bi_paymentmethod = $_POST['bi_paymentmethod'] : $bi_paymentmethod = "";
isset($_POST['bi_cash']) ? $bi_cash = $_POST['bi_cash'] : $bi_cash = "";
isset($_POST['bi_creditcardname']) ? $bi_creditcardname = $_POST['bi_creditcardname'] : $bi_creditcardname = "";
isset($_POST['bi_creditcardnumber']) ? $bi_creditcardnumber = $_POST['bi_creditcardnumber'] : $bi_creditcardnumber = "";
isset($_POST['bi_creditcardverification']) ? $bi_creditcardverification = $_POST['bi_creditcardverification'] : $bi_creditcardverification = "";
isset($_POST['bi_creditcardtype']) ? $bi_creditcardtype = $_POST['bi_creditcardtype'] : $bi_creditcardtype = "";
isset($_POST['bi_creditcardexp']) ? $bi_creditcardexp = $_POST['bi_creditcardexp'] : $bi_creditcardexp = "";
isset($_POST['bi_notes']) ? $bi_notes = $_POST['bi_notes'] : $bi_notes = "";
isset($_POST['bi_lead']) ? $bi_lead = $_POST['bi_lead'] : $bi_lead = "";
isset($_POST['bi_coupon']) ? $bi_coupon = $_POST['bi_coupon'] : $bi_coupon = "";
isset($_POST['bi_ordertaker']) ? $bi_ordertaker = $_POST['bi_ordertaker'] : $bi_ordertaker = "";
isset($_POST['bi_billstatus']) ? $bi_billstatus = $_POST['bi_billstatus'] : $bi_billstatus = "";
isset($_POST['bi_lastbill']) ? $bi_lastbill = $_POST['bi_lastbill'] : $bi_lastbill = "";
isset($_POST['bi_nextbill']) ? $bi_nextbill = $_POST['bi_nextbill'] : $bi_nextbill = "";
isset($_POST['bi_nextinvoicedue']) ? $bi_nextinvoicedue = $_POST['bi_nextinvoicedue'] : $bi_nextinvoicedue = "";
isset($_POST['bi_billdue']) ? $bi_billdue = $_POST['bi_billdue'] : $bi_billdue = "";
isset($_POST['bi_postalinvoice']) ? $bi_postalinvoice = $_POST['bi_postalinvoice'] : $bi_postalinvoice = "";
isset($_POST['bi_faxinvoice']) ? $bi_faxinvoice = $_POST['bi_faxinvoice'] : $bi_faxinvoice = "";
isset($_POST['bi_emailinvoice']) ? $bi_emailinvoice = $_POST['bi_emailinvoice'] : $bi_emailinvoice = "";
isset($_POST['changeUserBillInfo']) ? $bi_changeuserbillinfo = $_POST['changeUserBillInfo'] : $bi_changeuserbillinfo = "0";

isset($_POST['firstname']) ? $firstname = $_POST['firstname'] : $firstname = "";
isset($_POST['lastname']) ? $lastname = $_POST['lastname'] : $lastname = "";
isset($_POST['email']) ? $email = $_POST['email'] : $email = "";
isset($_POST['department']) ? $department = $_POST['department'] : $department = "";
isset($_POST['company']) ? $company = $_POST['company'] : $company = "";
isset($_POST['workphone']) ? $workphone = $_POST['workphone'] : $workphone = "";
isset($_POST['homephone']) ? $homephone = $_POST['homephone'] :  $homephone = "";
isset($_POST['mobilephone']) ? $mobilephone = $_POST['mobilephone'] : $mobilephone = "";
isset($_POST['address']) ? $ui_address = $_POST['address'] : $ui_address = "";
isset($_POST['city']) ? $ui_city = $_POST['city'] : $ui_city = "";
isset($_POST['state']) ? $ui_state = $_POST['state'] : $ui_state = "";
isset($_POST['country']) ? $ui_country = $_POST['country'] : $ui_country = "";
isset($_POST['zip']) ? $ui_zip = $_POST['zip'] : $ui_zip = "";
isset($_POST['notes']) ? $notes = $_POST['notes'] : $notes = "";
isset($_POST['changeUserInfo']) ? $ui_changeuserinfo = $_POST['changeUserInfo'] : $ui_changeuserinfo = "0";
isset($_POST['enableUserPortalLogin']) ? $ui_enableUserPortalLogin = $_POST['enableUserPortalLogin'] : $ui_enableUserPortalLogin = "0";
isset($_POST['portalLoginPassword']) ? $ui_PortalLoginPassword = $_POST['portalLoginPassword'] : $ui_PortalLoginPassword = "";

$logAction = "";
$logDebugSQL = "";


if (isset($_POST["submit"])) {

	include 'library/opendb.php';

	global $username;
	global $password;
	global $passwordtype;


	$sql = "SELECT * FROM " . $configValues['CONFIG_DB_TBL_RADCHECK'] . " WHERE UserName='" .
		$dbSocket->escapeSimple($username) . "'";
	$res = $dbSocket->query($sql);
	$logDebugSQL .= $sql . "\n";

	if ($res->numRows() == 0) {

		if (trim($username) != "" and trim($password) != "") {

			// we need to perform the secure method escapeSimple on $dbPassword early because as seen below
			// we manipulate the string and manually add to it the '' which screw up the query if added in $sql
			$password = $dbSocket->escapeSimple($password);

			switch ($configValues['CONFIG_DB_PASSWORD_ENCRYPTION']) {
				case "cleartext":
					$dbPassword = "'$password'";
					break;
				case "crypt":
					$dbPassword = "ENCRYPT('$password')";
					break;
				case "md5":
					$dbPassword = "MD5('$password')";
					break;
				default:
					$dbPassword = "'$password'";
			}

			// at this stage $dbPassword contains the password string encapsulated by '' and either uses
			// a function to encrypt it like ENCRYPT or it doesn't, it's based on the configuration
			// but here we provide another stage, for Crypt-Password and MD5-Password it's obvious
			// that the password need be encrypted so even if this option is not in the configuration
			// we enforce it.

			// we first check if the password attribute is to be encrypted at all
			if (preg_match("/crypt/i", $passwordtype)) {
				// if we don't find the encrypt function even though we identified
				// a Crypt-Password attribute
				if (!(preg_match("/encrypt/i", $dbPassword))) {
					$dbPassword = "ENCRYPT('$password')";
				}

				// we now perform the same check but for an MD5-Password attribute
			} elseif (preg_match("/md5/i", $passwordtype)) {
				// if we don't find the md5 function even though we identified
				// a MD5-Password attribute
				if (!(preg_match("/md5/i", $dbPassword))) {
					$dbPassword = "MD5('$password')";
				}
			}

			// insert username/password

			// insert username/password
			$sql = "INSERT INTO " . $configValues['CONFIG_DB_TBL_RADCHECK'] . " (id,Username,Attribute,op,Value) " .
				" VALUES (0, '" . $dbSocket->escapeSimple($username) . "', '" . $dbSocket->escapeSimple($passwordtype) .
				"', ':=', $dbPassword)";
			$res = $dbSocket->query($sql);
			$logDebugSQL .= $sql . "\n";



			addGroups($dbSocket, $username, $profiles);
			addPlanProfile($dbSocket, $username, $planName);
			addUserInfo($dbSocket, $username);
			addUserBillInfo($dbSocket, $username);

			// create any invoices if required (meaning, if a plan was chosen)
			if ($planName) {
				# code...
				createUserInvoicePlan($planName, $username);
			}


			// add user to radcheck  and radreply tables via addAttribute function (library/functions.php)
			addAttribute($dbSocket, $username, "Simultaneous-Use", ":=", '1', "check"); // allow only one user to login at a time
			addAttribute($dbSocket, $username, "User-Profile", ":=", $planName, "check"); // add user profile to radcheck table for 
			// add account expiration date
			addAttribute($dbSocket, $username, "Expiration", ":=", date("d M Y H:i:s", time()), "check");

			// addAttributes($dbSocket, $username); // 


			// if ($notificationWelcome == 1) {
			// 	// include("include/common/notificationsWelcome.php");

			// }

			$successMsg = "Added to database new user: <b> $username </b>";
			$logAction .= "Successfully added new user [$username] on page: ";
		} else {
			$failureMsg = "username or password are empty";
			$logAction .= "Failed adding (possible empty user/pass) new user [$username] on page: ";
		}
	} else {
		$failureMsg = "user already exist in database: <b> $username </b>";
		$logAction .= "Failed adding new user already existing in database [$username] on page: ";
	}

	include 'library/closedb.php';
}





include_once('library/config_read.php');
$log = "visited page: ";

if ($configValues['CONFIG_IFACE_PASSWORD_HIDDEN'] == "yes")
	$hiddenPassword = "type=\"password\"";

include_once 'include/management/populate_selectbox.php';
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	<title>
		<?php echo $configValues['SYSTEM_NAME'] ?> - <?php echo t('title', 'UserManagement') ?>
	</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
	<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->
</head>

<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/productive_funcs.js" type="text/javascript"></script>

<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/dynamic_attributes.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script>



<?php
include_once("library/tabber/tab-layout.php");
?>

<?php
include("menu-mng-users.php");
?>
<div id="contentnorightbar">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro', 'mngnew.php') ?>
			<h144>&#x2754;</h144>
		</a></h2>

	<div id="helpPage" style="display:none;visibility:visible">
		<?php echo t('helpPage', 'mngnew') ?>
		<br />
	</div>
	<?php
	include_once('include/management/actionMessages.php');
	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

		<div class="tabber">

			<div class="tabbertab" title="<?php echo t('title', 'AccountInfo'); ?>">

				<fieldset>

					<h302> <?php echo t('title', 'AccountInfo'); ?> </h302>

					<ul>

						<?php
						include_once('include/management/populate_selectbox.php');
						?>

						<div id='UserContainer'>
							<li class='fieldset'>
								<label for='username' class='form'><?php echo t('all', 'Username') ?></label>
								<input name='username' type='text' id='username' value='' tabindex=100 />
								<input type='button' value='Random' class='button' onclick="javascript:randomAlphanumeric('username',8,<?php
																																		echo "'" . $configValues['CONFIG_USER_ALLOWEDRANDOMCHARS'] . "'" ?>)" />
								<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('usernameTooltip')" />

								<div id='usernameTooltip' style='display:none;visibility:visible' class='ToolTip'>
									<img src='images/icons/comment.png' alt='Tip' border='0' />
									<?php echo t('Tooltip', 'usernameTooltip') ?>
								</div>
							</li>

							<li class='fieldset'>
								<label for='password' class='form'><?php echo t('all', 'Password') ?></label>
								<input name='password' type='text' id='password' value='' <?php if (isset($hiddenPassword)) echo $hiddenPassword ?> tabindex=101 />
								<input type='button' value='Random' class='button' onclick="javascript:randomAlphanumeric('password',8,<?php
																																		echo "'" . $configValues['CONFIG_USER_ALLOWEDRANDOMCHARS'] . "'" ?>)" />
								<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('passwordTooltip')" />

								<div id='passwordTooltip' style='display:none;visibility:visible' class='ToolTip'>
									<img src='images/icons/comment.png' alt='Tip' border='0' />
									<?php echo t('Tooltip', 'passwordTooltip') ?>
								</div>
							</li>
						</div>



						<li class='fieldset'>
							<label for='planName' class='form'><?php echo t('all', 'PlanName') ?></label>
							<?php
							populate_plans("Select Plan", "planName", "form");
							?>
							<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planNameTooltip')" />

							<div id='planNameTooltip' style='display:none;visibility:visible' class='ToolTip'>
								<img src='images/icons/comment.png' alt='Tip' border='0' />
								<?php echo t('Tooltip', 'planNameTooltip') ?>
							</div>
						</li>


						<li class='fieldset'>
							<label for='profile' class='form'><?php echo t('all', 'Profile') ?></label>
							<?php
							populate_groups("Select Profile", "profiles[]");
							?>

							<a class='tablenovisit' href='#' onClick="javascript:ajaxGeneric('include/management/dynamic_groups.php','getGroups','divContainerProfiles',genericCounter('divCounter')+'&elemName=profiles[]');">Add</a>

							<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('groupTooltip')" />

							<div id='divContainerProfiles'>
							</div>

							<div id='groupTooltip' style='display:none;visibility:visible' class='ToolTip'>
								<img src='images/icons/comment.png' alt='Tip' border='0' />
								<?php echo t('Tooltip', 'groupTooltip') ?>
							</div>
						</li>

						<!-- <li class='fieldset'>
							<label for='userupdate' class='form'><?php echo t('all', 'SendWelcomeNotification') ?></label>
							<input type='checkbox' class='form' name='notificationWelcome' value='1' />
							<br />
						</li> -->


						<li class='fieldset'>
							<br />
							<hr><br />
							<input type='submit' name='submit' value='<?php echo t('buttons', 'apply') ?>' tabindex=10000 class='button' />
						</li>

					</ul>

				</fieldset>

			</div>


			<div class="tabbertab" title="<?php echo t('title', 'UserInfo'); ?>">
				<?php
				$customApplyButton = "<input type='submit' name='submit' value=" . t('buttons', 'apply') . " class='button' />";
				include_once('include/management/userinfo.php');
				?>
			</div>

			<div class="tabbertab" title="<?php echo t('title', 'BillingInfo'); ?>">
				<?php
				$customApplyButton = "<input type='submit' name='submit' value=" . t('buttons', 'apply') . " class='button' />";
				include_once('include/management/userbillinfo.php');
				?>
			</div>


			<div class="tabbertab" title="<?php echo t('title', 'Advanced'); ?>">

				<fieldset>

					<h302> <?php echo t('title', 'AccountInfo'); ?> </h302>

					<ul>

						<li class='fieldset'>
							<label for='passwordType' class='form'><?php echo t('all', 'PasswordType') ?> </label>
							<select class='form' tabindex=102 name='passwordType'>
								<option value='Cleartext-Password'>Cleartext-Password</option>
								<option value='User-Password'>User-Password</option>
								<option value='Crypt-Password'>Crypt-Password</option>
								<option value='MD5-Password'>MD5-Password</option>
								<option value='SHA1-Password'>SHA1-Password</option>
								<option value='CHAP-Password'>CHAP-Password</option>
							</select>
						</li>

						<li class='fieldset'>
							<br />
							<hr><br />
							<input type='submit' name='submit' value='<?php echo t('buttons', 'apply') ?>' tabindex=10000 class='button' />
						</li>

					</ul>

				</fieldset>

			</div>

		</div>

	</form>


	<?php
	include('include/config/logging.php');
	?>

</div>

<div id="footer">

	<?php
	include 'page-footer.php';
	?>


</div>

</div>
</div>


</body>

</html>