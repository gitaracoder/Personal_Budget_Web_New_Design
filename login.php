<?php
	session_start();
	
	if((isset($_SESSION['serverErrorMessage'])))
	{
		echo $_SESSION['serverErrorMessage'];
		unset($_SESSION['serverErrorMessage']);
	}
	
	if((isset($_SESSION['LoggedIn'])) && ($_SESSION['LoggedIn'] == true))
	{
		header('Location: main_menu.php');
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
			<a class="navbar-brand" href="index.php"><i class="demo-icon icon-money"></i> Personal Budget</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
				  <li class="nav-item active">
					<a class="nav-link" href="login.php">Zaloguj</a>
				  </li>
				  <li class="nav-item active">
					<a class="nav-link" href="register.php">Rejestracja</a>
				  </li>
				  <li class="nav-item active">
					<a class="nav-link" href="#">Kontakt</a>
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
					<div class="row">
						<div class="col-md-12">
							<h2><i class="demo-icon icon-login"></i> Logowanie</h2>
							<form action="proceed.php" method="post">
								<div class="form-group">
									<label for="inputUserEmailLogIn">Adres e-mail</label>
									<input type="email" class="form-control" name="inputUserEmailLogIn" aria-describedby="emailHelp" placeholder="email">
									<small id="emailHelp" class="form-text text-muted">Dbamy o Twoją prywtność, adres e-mail nie będzie widoczny dla innych.</small>
								</div>
								<div class="form-group">
									<label for="inputUserPasswordLogIn">Hasło</label>
									<input type="password" class="form-control" name="inputUserPasswordLogIn" placeholder="hasło">
								</div>
								<?php
									
									if(isset($_SESSION['loginError'])) 
									echo $_SESSION['loginError'];
								?>
								<button type="submit" class="btn-lg btn btn-outline-success">Zaloguj</button>
							</form>
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
