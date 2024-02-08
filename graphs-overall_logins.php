<?php

include("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include('library/check_operator_perm.php');


//setting values for the order by and order type variables
isset($_REQUEST['orderBy']) ? $orderBy = $_REQUEST['orderBy'] : $orderBy = "username";
isset($_REQUEST['orderType']) ? $orderType = $_REQUEST['orderType'] : $orderType = "asc";


$username = (isset($_REQUEST['username'])) ? $_REQUEST['username'] : null ;
$type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : null ;


//feed the sidebar variables
$overall_logins_username = $username;

include_once('library/config_read.php');
$log = "visited page: ";
$logQuery = "performed query for user [$username] of type [$type] on page: ";


?>

<?php
include("menu-graphs.php");
?>

<?php
include_once("library/tabber/tab-layout.php");
?>


<div id="contentnorightbar">

	<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo t('Intro', 'graphsoveralllogins.php'); ?>
			<h144>&#x2754;</h144>
		</a></h2>

	<div id="helpPage" style="display:none;visibility:visible">
		<?php echo t('helpPage', 'graphsoveralllogins') ?>
		<br />
	</div>
	<br />

	<div class="tabber">

		<div class="tabbertab" title="Graph">
			<br />

			<?php
			echo "<center>";
			echo "<canvas id='user'></canvas>";
			echo "</center>";
			?>
		</div>
		<div class="tabbertab" title="Statistics">
			<br />

			<?php
			include 'library/tables-overall-users-login.php';
			?>

		</div>
	</div>


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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
	<?php
	if (isset($type) && isset($username)) {
		# code...
		$url = getenv('BASE_URL') . "/library/graphs-overall-users-login.php?type=$type&user=$username";
	}else{
		$url = null ;
	}
	
	?>

	let url = "<?php echo $url; ?>";
	// Fetch data from PHP script
	fetch(url)
		.then(response => response.json())
		.then(data => {
			// Data received, create chart
			createChart(data);
		})
		.catch(error => {
			console.error('Error fetching data:', error);
		});

	// Function to create the bar chart
	function createChart(data) {
		var ctx = document.getElementById('user').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: data.map(item => item[1]), // Days
				datasets: [{
					label: 'Count',
					data: data.map(item => item[0]), // Count
					backgroundColor: 'rgba(75, 192, 192, 0.2)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1
				}]
			},
			options: {

				scales: {
					y: {
						beginAtZero: true,
						title: {
							display: true,
							text: 'Counts' // Y-axis title
						},
						ticks: {
							display: true,
							font: {
								family: "Poppins",
								weight: "bold",
							},
						},
						grid: {
							display: true,
							drawBorder: false,
							drawTicks: false,
							borderDash: [5, 5],
							borderDashOffset: 0.0,
							color: "rgba(0, 0, 0, 0.1)",
							zeroLineWidth: 1,
							zeroLineColor: "rgba(0,0,0,0.25)",


						}
					},
					x: {
						beginAtZero: true,
						title: {
							display: true,
							text: 'Days'
						},
						ticks: {
							display: true,
							font: {
								family: "Poppins",
								weight: "bold",
							},
						},
						grid: {
							display: true,
							drawBorder: false,
						},
					},
				},
				plugins: {
					legend: {
						display: false,

					},
					title: {
                            display: true,
                            text: 'User Logins', // Chart title
                            font: {
                                size: 18
                            }
                        }
				},

			}
		});
	}
</script>

</body>

</html>