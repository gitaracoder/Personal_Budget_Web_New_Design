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
    
				<div class="row mb-4">
					<div class="col-sm-12">
						<h2>Dlaczego warto prowadzić budżet domowy?</h2>
						<p class="text-justify">Kontrola. W zarządzaniu domowymi finansami chodzi przede wszystkim o to, by mieć kontrolę. Kontrolę nad własną sytuacją finansową. Tak aby mieć realny wpływ na to ile, kiedy i na co wydajemy – zamiast dostosowywać się do tego ile zostaje nam w portfelu na koniec miesiąca. I tu przydaje się nam domowy budżet.</p>

						<p class="text-justify">Budżet domowy to pierwszy krok do przejęcia kontroli nad własnymi finansami. Daje on wiedzę o tym, na co wydajemy pieniądze i jest jednocześnie narzędziem do tego, aby mądrze planować przyszłe wydatki.</p>
					</div>
				</div>
	
				<div class="jumbotron">
					<div class="row">
						<div class="col-md-6">
						
							<h2><i class="demo-icon icon-login"></i> Zaloguj się</h2>
							<p>Jeżeli posiadasz już konto pamiętaj by zapisywać wszystkie przychody i wydatki, by jak najdokładniej planować swój budżet.</p>
							<p><a class="btn-lg btn btn-outline-success" href="login.php" role="button">Zaloguj</a></p> 
						</div>
						
						<div class="col-md-6">
							<h2><i class="demo-icon icon-user-plus"></i> Zarejestruj się</h2>
							<p>Jeżeli nie posiadasz jeszcze konta, załóż je już teaz i rozpocznij kontrolę nad swoim budżerem, to nic nie kosztuje, możesz jedynie zyskać! </p>
							<p><a class="btn-lg btn btn-outline-primary" href="register.php" role="button">Zarejestruj</a></p>
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
