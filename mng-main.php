<?php

include("library/checklogin.php");
$operator = $_SESSION['operator_user'];

include_once('library/config_read.php');
include_once('lang/main.php');
$log = "visited page: ";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
	<title>
		<?php
		echo t('title', 'Management');
		?>
	</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<?php

include("menu-mng-users.php");

?>

<div id="contentnorightbar">

	<h2 id="Intro"><a href="#"><?php echo t('Intro', 'mngmain.php') ?></a></h2>

	<p>
		<!-- <table><center><br/> -->
		<!-- <img src="library/chart-mng-total-users.php" /> -->
		<canvas id="users"></canvas>


		<!-- </table></center> -->


	</p>


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

<script>
	const ctx = document.getElementById('users');

	// get the number of users from the radcheck table and display it in a chart
	// from library/chart-mng-total-users.php
	<?php
	$url = getenv('BASE_URL') . "/library/chart-mng-total-users.php";
	?>

	let url = "<?php echo $url; ?>";
	fetch(url).then(response => response.json()).then(data => {
		console.log(data);
		let myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ['Users'],
				datasets: [{
					label: 'Users',
					data: [data.users],
					backgroundColor: 'rgba(5, 229, 2, 0.2)',
					borderColor: 'rgba(0,255, 2, 1)',
					borderWidth: 2,
					fill: true,
					lineTension: 0,
					pointRadius: 3,
					pointHoverRadius: 5,
					pointHitRadius: 10,
					pointBackgroundColor: "rgba(75,192,192,1)",
					tension: 0.1,
					stepped: false
				}]
			},
			options: {
				
				scales: {
					y: {
						beginAtZero: true,
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
                    beginAtZero: false,
                    ticks: {
                        display: true,
                        font: {
                            family: "Poppins",
                            weight: "bold",
                        },
                    },
                    grid: {
                        display: false,
                        drawBorder: false,
                    },
                },
				},
				plugins: {
					legend: {
						display: false,
						labels: {
							font: {
								family: "Poppins",
								weight: "bold",
							},
						},
					},
				},

				



			}
		});

	});
</script>


</body>

</html>