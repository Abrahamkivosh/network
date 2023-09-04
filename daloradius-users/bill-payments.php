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
 * Authors:    Liran Tal <liran@enginx.com>
 *
 *********************************************************************************************************
 */
include "library/checklogin.php";
$login = $_SESSION['login_user'];

include_once 'library/config_read.php';
$log = "visited page: ";

?>

<?php

include "menu-billing.php";

?>

	<div id="contentnorightbar">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro', 'billmain.php'); ?>
		<h144>&#x2754;</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo t('helpPage', 'billmain') ?>
			<br/>
		</div>
		<br/>
		


		<!-- bill payment table -->
		<table class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th><?php echo t('all', 'userName'); ?></th>
					<th><?php echo t('all', 'amount'); ?></th>
					<th><?php echo t('all', 'date'); ?></th>
					<th><?php echo t('all', 'paymentMethod'); ?></th>
					<th><?php echo t('all', 'status'); ?></th>


				</tr>
			</thead>
			<tbody>
				<tr class="odd gradeX">
					<td>user1</td>
					<td>1000</td>
					<td>2016-01-01</td>
					<td>Paypal</td>
					<td>Success</td>
				</tr>
				<tr class="odd gradeX">
					<td>user2</td>
					<td>2000</td>
					<td>2016-01-02</td>
					<td>Paypal</td>
					<td>Success</td>
				</tr>
				<tr class="odd gradeX">
					<td>user3</td>
					<td>3000</td>
					<td>2016-01-03</td>
					<td>Paypal</td>
					<td>Success</td>
				</tr>
				<tr class="odd gradeX">
					<td>user4</td>
					<td>4000</td>
					<td>2016-01-04</td>
					<td>Paypal</td>
					<td>Success</td>
				</tr>
				<tr class="odd gradeX">
					<td>user5</td>
					<td>5000</td>
					<td>2016-01-05</td>
					<td>Paypal</td>
					<td>Success</td>
				</tr>
			</tbody>
		</table>
		<!-- end bill payment table -->

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId">
		  Launch
		</button>
		
		<!-- Modal -->
		<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title">Modal title</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
					</div>
					<div class="modal-body">
						<form class="form " action="">
							<div class="form-group ">
								<label for="">label</label>
								<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
								<small id="helpId" class="form-text text-muted">Help text</small>
							</div>
							
						</form>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save</button>
					</div>
				</div>
			</div>
		</div>


<?php
include 'include/config/logging.php';
?>

		</div>

		<div id="footer">

<?php
include 'page-footer.php';
?>

		</div>

</div>
</div>

<script src="js/app.js" type="text/javascript"></script>

 <!-- Link to Bootstrap JS and jQuery -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
