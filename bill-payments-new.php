<?php


include("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include('library/check_operator_perm.php');
include_once("./include/management/helper.php");
include_once "./library/functions.php";
include 'library/opendb.php';

isset($_GET['payment_invoice_id']) ? $invoice_id = $_GET['payment_invoice_id'] : $invoice_id = "";

isset($_POST['payment_invoice_id']) ? $payment_invoice_id = $_POST['payment_invoice_id'] : $payment_invoice_id = "";
isset($_POST['payment_amount']) ? $payment_amount = $_POST['payment_amount'] : $payment_amount = "";
isset($_POST['payment_date']) ? $payment_date = $_POST['payment_date'] : $payment_date = "";
isset($_POST['payment_type_id']) ? $payment_type_id = $_POST['payment_type_id'] : $payment_type_id = "";
isset($_POST['payment_notes']) ? $paymentnotes = $_POST['payment_notes'] : $payment_notes = "";
isset($_POST['payment_status_id']) ? $payment_status_id = $_POST['payment_status_id'] : $payment_status_id = "";

$logAction = "";
$logDebugSQL = "";

$creationdate = date('Y-m-d H:i:s');
$creationby = $updateby = $_SESSION['operator_user'] ;

$edit_invoiceid = $invoice_id;




if (isset($_POST["submit"])) {

	$payment_invoice_id = $invoice_id = $_POST['payment_invoice_id'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_type_id = $_POST['payment_type_id'];
	$payment_notes = $_POST['payment_notes'];
	$payment_status_id = $_POST['payment_status_id'];

	

	$sql = "SELECT * FROM " . $configValues['CONFIG_DB_TBL_DALOPAYMENTS'] . " WHERE invoice_id=" . $dbSocket->escapeSimple($payment_invoice_id) . " AND amount=" . $dbSocket->escapeSimple($payment_amount) . " AND date='" . $dbSocket->escapeSimple($payment_date) . "'";
	$res = $dbSocket->query($sql);
	$logDebugSQL .= $sql . "\n";

	if ($res->numRows() == 0) {
		if (trim($payment_invoice_id) != "" and trim($payment_amount) != "" and trim($payment_date) != "") {


			// insert apyment type info
			$table_invoice_payments = $configValues['CONFIG_DB_TBL_DALOPAYMENTS'];
			$payment_invoice_id = $dbSocket->escapeSimple($payment_invoice_id);
			$amount = $dbSocket->escapeSimple($payment_amount);
			$type_id = $dbSocket->escapeSimple($payment_type_id);
			$date = $dbSocket->escapeSimple($payment_date);
			$notes = $status_message = $dbSocket->escapeSimple($payment_notes);
			$reference_no = $transaction_id = createReferenceNumber();
			$status = $dbSocket->escapeSimple($payment_status_id);
			$sender_number = "";
			$sender_name = $creationby;


			$sql = "INSERT INTO $table_invoice_payments (invoice_id, amount, type_id, date, notes, reference_no, transaction_id, status , status_message, sender_number , sender_name) VALUES " .
				"('$payment_invoice_id', '$amount', '$type_id', '$date', '$notes', '$reference_no', '$transaction_id', '$status', '$status_message', '$sender_number', '$sender_name')";
			$result = $dbSocket->query($sql);
			$logDebugSQL .= $sql . "\n";



			$successMsg = "Added to database new payment for invoice: <b>$payment_invoice_id</b> <br/>";
			$successMsg .= "<a href='bill-invoice-edit.php?invoice_id=$payment_invoice_id'> Show Invoice $payment_invoice_id </a>";
			$logAction .= "Successfully added new payment for invoice [$payment_invoice_id] on page: ";
		} else {
			$failureMsg = "you must provide an invoice, an amount and a date ";
			$logAction .= "Failed adding new payment for invoice [$payment_invoice_id] on page: ";
		}
	} else {
		$failureMsg = "You have tried to add a paymente that already exist in the database for the invoice: $payment_invoice_id";
		$logAction .= "Failed adding new payment already in database for invoice [$payment_invoice_id] on page: ";
	}

	include 'library/closedb.php';
}


$invoiceDetails = getInvoiceDetails($dbSocket,$configValues,$edit_invoiceid);

$balance = floatval($invoiceDetails['totalpayed'] - $invoiceDetails['totalbilled']) ;
if ($balance >=0) {
	$failureMsg = "The Invoice is fully paid";
	header("Location:  bill-invoice-edit.php?invoice_id=$invoice_id&&failureMsg=$failureMsg");
	exit;
}


// if $invoice_id is not set redirect to invoice list page with error message
if ($invoice_id == "") {
	$failureMsg = "You must provide an invoice id to add a payment to";
	header("Location:  bill-invoice-list.php?failureMsg=$failureMsg");
	exit;
}



include_once('library/config_read.php');
$log = "visited page: ";

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	<title> <?php echo $configValues['SYSTEM_NAME'] ?>
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
<script type="text/javascript" src="library/javascript/pages_common.js"></script>
<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/dynamic_attributes.js"></script>
<script type="text/javascript" src="library/javascript/ajaxGeneric.js"></script>
<?php
include_once("library/tabber/tab-layout.php");
?>

<?php

include("menu-bill-payments.php");

?>

<div id="contentnorightbar">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro', 'paymentsnew.php') ?>
			<h144>&#x2754;</h144>
		</a></h2>

	<div id="helpPage" style="display:none;visibility:visible">
		<?php echo t('helpPage', 'paymentsnew') ?>
		<br />
	</div>
	<?php
	include_once('include/management/actionMessages.php');
	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

		<div class="tabber">

			<div class="tabbertab" title="<?php echo t('title', 'PaymentInfo'); ?>">

				<fieldset>

					<h302> <?php echo t('title', 'PaymentInfo'); ?> </h302>
					<br />

					<ul>

						<!-- <li class='fieldset'>
		<label for='name' class='form'><?php  //echo t('all','PaymentInvoiceID') 
										?></label>
		
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('paymentInvoiceTooltip')" /> 
		
		<div id='paymentInvoiceTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php // echo t('Tooltip','paymentInvoiceTooltip') 
			?>
		</div>
		</li> -->

						<li class='fieldset'>
							<input name='payment_invoice_id' type='hidden' id='payment_invoice_id' value='<?php echo $invoice_id ?>' tabindex=100 />
							<label for='payment_amount' class='form'><?php echo t('all', 'PaymentAmount') ?></label>

							<input class="" type="number" value="" id='payment_amount' name='payment_amount' tabindex=103 />
							<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('amountTooltip')" />

							<div id='amountTooltip' style='display:none;visibility:visible' class='ToolTip'>
								<img src='images/icons/comment.png' alt='Tip' border='0' />
								<?php echo t('Tooltip', 'amountTooltip') ?>
							</div>
						</li>

						<label for='payment_date' class='form'><?php echo t('all', 'PaymentDate') ?></label>
						<input value='<?php echo $payment_date ?>' id='payment_date' name='payment_date' tabindex=108 />
						<img src="library/js_date/calendar.gif" onclick="showChooser(this, 'payment_date', 'chooserSpan', 1950, <?php echo date('Y', time()); ?>, 'Y-m-d H:i:s', true);">
						<br />

						<li class='fieldset'>
							<label for='payment_status' class='form'><?php echo t('all', 'PaymentStatus') ?></label>
							<?php
							include_once('include/management/populate_selectbox.php');
							populate_payment_status_id("Select Payment Status", "payment_status_id");
							?>
							<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('paymentStatusTooltip')" />
							<div id='paymentStatusTooltip' style='display:none;visibility:visible' class='ToolTip'>
								<img src='images/icons/comment.png' alt='Tip' border='0' />
								<?php echo t('Tooltip', 'paymentStatusTooltip') ?>
							</div>
						</li>


						<li class='fieldset'>
							<label for='payment_type_id' class='form'><?php echo t('all', 'PaymentType') ?></label>
							<?php
							include_once('include/management/populate_selectbox.php');
							populate_payment_type_id("Select Payment Type", "payment_type_id");
							?>
							<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('paymentTypeIdTooltip')" />
							<div id='paymentTypeIdTooltip' style='display:none;visibility:visible' class='ToolTip'>
								<img src='images/icons/comment.png' alt='Tip' border='0' />
								<?php echo t('Tooltip', 'paymentTypeIdTooltip') ?>
							</div>
						</li>

						<li class='fieldset'>
							<label for='payment_notes' class='form'><?php echo t('all', 'PaymentNotes') ?></label>
							<textarea name='payment_notes' class='form' tabindex=101></textarea>
							<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('paymentNotesTooltip')" />

							<div id='paymentNotesTooltip' style='display:none;visibility:visible' class='ToolTip'>
								<img src='images/icons/comment.png' alt='Tip' border='0' />
								<?php echo t('Tooltip', 'paymentNotesTooltip') ?>
							</div>
						</li>

						<li class='fieldset'>
							<br />
							<hr><br />
							<input type='submit' name='submit' value='<?php echo t('buttons', 'apply') ?>' tabindex=10000 class='button' />
						</li>

					</ul>
				</fieldset>

			</div>


			<div class="tabbertab" title="<?php echo t('title', 'Optional'); ?>">

				<fieldset>

					<h302> Optional </h302>
					<br />

					<br />
					<h301> Other </h301>
					<br />

					<br />
					<label for='creationdate' class='form'><?php echo t('all', 'CreationDate') ?></label>
					<input disabled value='<?php if (isset($creationdate)) echo $creationdate ?>' tabindex=313 />
					<br />

					<label for='creationby' class='form'><?php echo t('all', 'CreationBy') ?></label>
					<input disabled value='<?php if (isset($creationby)) echo $creationby ?>' tabindex=314 />
					<br />

					<label for='updatedate' class='form'><?php echo t('all', 'UpdateDate') ?></label>
					<input disabled value='<?php if (isset($updatedate)) echo $updatedate ?>' tabindex=315 />
					<br />

					<label for='updateby' class='form'><?php echo t('all', 'UpdateBy') ?></label>
					<input disabled value='<?php if (isset($updateby)) echo $updateby ?>' tabindex=316 />
					<br />


					<br /><br />
					<hr><br />

					<input type='submit' name='submit' value='<?php echo t('buttons', 'apply') ?>' tabindex=10000 class='button' />

				</fieldset>


			</div>
			<div id="chooserSpan" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;"></div>

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