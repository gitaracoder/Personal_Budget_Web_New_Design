<?php
	session_start();
	
	if(isset($_POST['inputUserEmailRegister']))
	{
		$allOK = true;
		
		$name = $_POST['inputUserNameRegister'];
		
		//Sprawdzenie długości imienia
		if((strlen($name)<2)||(strlen($name)>20))
		{
			$allOK = false;
			$_SESSION['nameError'] = '<div class="mb-3 text-danger">Imię może mieć od 2 do 20 znaków.</div>';
		}
		
		//sprawdz poprawnosc adresu email
		$email = $_POST['inputUserEmailRegister'];
		
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email))
		{
			$allOK=false;
			$_SESSION['emailError']='<div class="mb-3 text-danger">Wprowadź poprawny adres e-mail.</div>';
		}
		
		//sprawdz poprawnosc hasla
		$password = $_POST['inputUserPasswordRegister'];
		
		if((strlen($password)<8) || (strlen($password)>20))
		{
			$allOK=false;
			$_SESSION['passError']='<div class="mb-3 text-danger">Hasło musi mieć od 8 do 20 znaków.</div>';
		}

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
			if($connection->connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//czy email już istnieje
				$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error); 
				
				$foundEmails = $result->num_rows;
				
				if($foundEmails > 0)
				{
					$allOK = false;
					$_SESSION['emailError']='<div class="mb-3 text-danger">Istnieje już konto przypisane do tego adresu email.</div>';
				}
				
				if($allOK == true)
				{
					//dodawanie usera do bazy
					if($connection->query("INSERT INTO users VALUES(NULL, '$name', '$password_hash', '$email')"))
					{
					}
					else
					{
						throw new Exception($connection->error); 
					}
					
					if ($result = @$connection->query(sprintf("SELECT * FROM users WHERE email='%s'", 
					mysqli_real_escape_string($connection, $emailB))))
					{
						$row = $result->fetch_assoc();
						$newUserID = $row['id'];
					}
					
					if($connection->query("INSERT INTO expenses_category_assigned_to_users(name)
					SELECT name FROM expenses_category_default;"))
					{	
					}
					else
					{
						throw new Exception($connection->error); 
					}
					
					if($connection->query("UPDATE expenses_category_assigned_to_users SET user_id = '$newUserID' WHERE user_id = 0;"))
					{	
					}
					else
					{
						throw new Exception($connection->error); 
					}
					
					//przepisywanie z tabeli default do tabeli assigned to user
					
					if($connection->query("INSERT INTO incomes_category_assigned_to_users(name)
					SELECT name FROM incomes_category_default;"))
					{	
					}
					else
					{
						throw new Exception($connection->error); 
					}
					
					if($connection->query("UPDATE incomes_category_assigned_to_users SET user_id = '$newUserID' WHERE user_id = 0;"))
					{					
					}
					else
					{
						throw new Exception($connection->error); 
					}
					
					if($connection->query("INSERT INTO payment_methods_assigned_to_users(name)
					SELECT name FROM payment_methods_default;"))
					{	
					}
					else
					{
						throw new Exception($connection->error); 
					}
					
					if($connection->query("UPDATE payment_methods_assigned_to_users SET user_id = '$newUserID' WHERE user_id = 0;"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: main_menu.php');
						
					}
					else
					{
						throw new Exception($connection->error); 
					}		
				}
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			echo 'Błąd serwera, przepraszamy za niedogodności!';	
			//echo '<br/>Informacja deweloperska: '.$e;
		}
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
							<h2><i class="demo-icon icon-user-plus"></i> Rejestracja</h2>
							<form method="post">
								<div class="form-group">
									<label for="inputUserNameRegister">Imię</label>
									<input class="form-control" name="inputUserNameRegister" type="text" placeholder="wpisz imię">	
								</div>
								<?php
									if(isset($_SESSION['nameError']))
									{
										echo $_SESSION['nameError'];
										unset($_SESSION['nameError']);
									}
								?>
								<div class="form-group">
									<label for="inputUserEmailRegister">Adres e-mail</label>
									<input type="email" class="form-control" name="inputUserEmailRegister" aria-describedby="emailHelp" placeholder="wpisz e-mail">
									<small id="emailHelp" class="form-text text-muted">Dbamy o Twoją prywtność, adres e-mail nie będzie widoczny dla innych.</small>
								</div>
								<?php
									if(isset($_SESSION['emailError']))
									{
										echo $_SESSION['emailError'];
										unset($_SESSION['emailError']);
									}
								?>
								<div class="form-group">
									<label for="inputUserPasswordRegister">Hasło</label>
									<input type="password" class="form-control" name="inputUserPasswordRegister" placeholder="wpisz hasło">
								</div>
								<?php
									if(isset($_SESSION['passError']))
									{
										echo $_SESSION['passError'];
										unset($_SESSION['passError']);
									}
								?>
								<button type="submit" class="btn-lg btn btn-outline-success">Zarejestruj</button>
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
