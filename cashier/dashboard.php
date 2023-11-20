<?php
include './database/connection.php';

include './auth_guard.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dashboard</title>
	<?php include './layouts/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-hidden font-sans bg-gray-50">
	<?php include './components/alerts.php'; ?>
	<?php include './components/logout_loader.php'; ?>
	<?php include './components/modal/signOutModal.php'; ?>
	<?php include './layouts/sidebar.php'; ?>

	<section class="flex min-h-screen grow flex-col bg-gray-100">
		<?php include './layouts/header.php'; ?>
		<?php include './components/subheader.php'; ?>
		<main class="relative flex flex-1 flex-col justify-start px-10 overflow-auto">
			<div class="flex flex-col gap-5 bg-white p-5 rounded-md shadow-md mb-10">
				<?php include './components/dashboard_main.php'; ?>
			</div>
		</main>
	</section>


	<?php include './layouts/scripts.php'; ?>
	<script>
		$("#subheader-title").text("Dashboard")
		$("#subheader-title").siblings("h5").text("View, and Manage Dashboard.")
	</script>
</body>

</html>
<?php
$conn->close();
?>