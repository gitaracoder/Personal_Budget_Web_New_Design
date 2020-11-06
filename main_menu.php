<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
		<title>Personal Budget - Aplikacja do zarządzania Budżetem Osobistym</title>
		<meta name="description" content="Aplikacja do zarządzania budżetem osobistym. Rozpocznij kontrolę nad wydatkami, zacznij oszczędzać." />
		<meta name="keywords" content="oszczędzanie, zarabianie, budżet, kontrola, wydatki, przychody, ewidencja" />
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="main.css">
		<link rel="stylesheet" href="css/fontello.css">
	</head>
  
	<body>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-6">
			<a class="navbar-brand" href="main_menu.php"><i class="demo-icon icon-money"></i> Personal Budget</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
				  <li class="nav-item active">
					<a class="nav-link" href="add_income.php"><i class="demo-icon icon-download"></i> Przychód</a>
				  </li>
				  <li class="nav-item active">
					<a class="nav-link" href="add_expense.php"><i class="demo-icon icon-upload"></i> Wydatek</a>
				  </li>
				  <li class="nav-item active">
					<a class="nav-link" href="balance.php"><i class="demo-icon icon-book-open"></i> Bilans</a>
				  </li>
				  <li class="nav-item active">
					<a class="nav-link" href="#"><i class="demo-icon icon-cog-alt"></i> Ustawienia</a>
				  </li>
				</ul>
				<ul class="navbar-nav ml-auto">
				  <li class="nav-item active">
					<a class="nav-link text-danger" href="logout.php"><i class="demo-icon icon-logout"></i> Wyloguj</a>
				  </li>
				</ul>
			</div>
		</nav>

		<main>

			<div class="jumbotron">
				<div id="baner">
					<div id="mainBaner">
						Personal Budget
					</div>
					<div id="subBaner">
						<i class="demo-icon icon-dollar"></i>Aplikacja do zarządzania Budżetem Osobistym<i class="demo-icon icon-dollar"></i>
					</div>
				</div>
			</div>

			<div class="container">
				<div class="jumbotron">
					<h2><i class="demo-icon icon-list"></i> Menu główne</h2>
					<?php
						echo '<h4 class="mb-5 text-center" >Witaj '.$_SESSION['name'].'! Co teraz robimy?</h4>';
						echo $_SESSION['message'];
					?>
					<div class="row">
						<div class="col-md-6">
							<a role="button" href="add_income.php" class="btn mb-5 btn-block btn-outline-primary btn-lg"><i class="demo-icon icon-download"></i> Dodaj przychód</a>
						</div>
						<div class="col-md-6">
							<a role="button" href="add_expense.php" class="btn mb-5 btn-block btn-outline-primary btn-lg"><i class="demo-icon icon-upload"></i> Dodaj wydatek</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<a <a role="button" href="balance.php" class="btn mb-5 btn-block btn-outline-primary btn-lg"><i class="demo-icon icon-book-open"></i> Przeglądaj bilans</a>
						</div>
						<div class="col-md-6">
							<button type="button" class="btn mb-5 btn-block btn-outline-primary btn-lg"><i class="demo-icon icon-cog-alt"></i> Ustawienia</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<a role="button" href="logout.php" class="btn mb-4 btn-block btn-outline-danger btn-lg"><i class="demo-icon icon-logout"></i> Wyloguj się</a>
						</div>
					</div>
				</div>
				<hr>
			</div>
		</main>

		<footer class="container">
			<p>&copy; Personal Budget 2020</p>
		</footer>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		
		<script src="js/bootstrap.min.js"></script>
	  
	</body>
</html>
