<?php
	session_start();
	
	$_SESSION['message'] = '';
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
	if(isset($_POST['amountExpense']))
	{
		$allOK = true;
	
		$loggedUserId = $_SESSION['id'];
		$amount = $_POST['amountExpense'];
		$method = $_POST['paymentMethod'];
		$date = $_POST['dateExpense'];
		$category = $_POST['selectedCategory'];
		$comment = $_POST['comment'];
		
		if($amount <= 0)
		{
			$allOK = false;
			$_SESSION['amountExpenseError']='<div class="mb-3 text-danger">Kwota nie może być mniejsza lub równa zero.</div>';
		}
		
		if($date == '')
		{
			$allOK = false;
			$_SESSION['dateExpenseError']='<div class="mb-3 text-danger">Wprowadź datę.</div>';
		}
		
		if($date > date("Y-m-d"))
		{
			$allOK = false;
			$_SESSION['dateExpenseError']='<div class="mb-3 text-danger">Data wydatku nie może wykraczać poza dzisiejszą datę.</div>';
		}

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
				$idOfExpenseCategory=$connection->query("SELECT id FROM expenses_category_assigned_to_users WHERE user_id='$loggedUserId' AND name='$category'");					
				$idOfExpenseCategory = $idOfExpenseCategory->fetch_assoc();
				$idOfExpenseCategory = $idOfExpenseCategory['id'];
				
				$idOfPaymentMethod=$connection->query("SELECT id FROM payment_methods_assigned_to_users WHERE user_id='$loggedUserId' AND name='$method'");				
				$idOfPaymentMethod = $idOfPaymentMethod->fetch_assoc();
				$idOfPaymentMethod = $idOfPaymentMethod['id'];
				
				if($allOK == true)
				{
					if($connection->query("INSERT INTO expenses VALUES(NULL, '$loggedUserId', '$idOfExpenseCategory', '$idOfPaymentMethod', '$amount', '$date', '$comment')"))
					{	
						$_SESSION['message'] = '<h5 class="mb-5 text-center text-success" >Pomyślnie dodano wydatek</h5>';
					}
					else
					{
						throw new Exception($connection->error); 
					}
					
					$connection->close();
				}
				else
				{
					header('Location: add_expense.php');
					exit();
				}
			}
		}
		catch(Exception $e)
		{
			$_SESSION['expenseMessage'] = 'error';
		}
		
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
	<?php
		if(isset($_SESSION['expenseMessage']))
		{
			echo 'Błąd serwera, przepraszamy za niedogodności!';
		}
	?>
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
					<h2><i class="demo-icon icon-upload"></i> Dodaj wydatek</h2>
					<form method="post">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="amountExpense">Kwota wydatku</label>
									<input type="number" class="form-control" name="amountExpense" step=".01" placeholder="wpisz kwotę">
									<?php	
										if(isset($_SESSION['amountExpenseError']))
										echo $_SESSION['amountExpenseError'];
										unset($_SESSION['amountExpenseError']);										
									?>
								</div>
							</div>
							<div class="col-md-6">
								<label for="dateExpense">Data wydatku</label>
								<input type="date" class="form-control" name="dateExpense">
								<?php	
									if(isset($_SESSION['dateExpenseError']))
									echo $_SESSION['dateExpenseError'];
									unset($_SESSION['dateExpenseError']);										
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<p>Forma płatności</p>
								<?php	
									$idZalogowanego = $_SESSION['id'];
									
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
											$result = $connection->query("SELECT * FROM payment_methods_assigned_to_users WHERE user_id='$idZalogowanego'");
								
											if($result->num_rows > 0) 
											{
												$i = 1;
												while($r = $result->fetch_assoc())
												{
													echo '<div class="form-check">';
													
													if($i == 1)
													{
														echo '<input class="form-check-input" type="radio" name="paymentMethod" id="radio'.$i.'" value="'.$r['name'].'" checked>';
													}
													else
													{
														echo '<input class="form-check-input" type="radio" name="paymentMethod" id="radio'.$i.'" value="'.$r['name'].'">';
													}
													echo '<label class="form-check-label" for="radio'.$i.'">';
													echo ''.$r['name'].'';
													echo '</label>';
													echo '</div>';
													
													$i++;
												}
											}
												
											echo '</div>';
											echo '<div class="col-md-6">';
											echo '<p>Kategoria wydatku</p>';
											echo '<select class="custom-select" name="selectedCategory">';
									
											$result = $connection->query("SELECT * FROM expenses_category_assigned_to_users WHERE user_id='$idZalogowanego'");
								
											if($result->num_rows > 0) 
											{
												while($r = $result->fetch_assoc())
												{
													echo '<option value="'.$r['name'].'">'.$r['name'].'</option>';
												}
											}
											
											$connection->close();
										}
									}
									catch(Exception $e)
									{
										$_SESSION['expenseMessage'] = 'error';
									}
								?>	
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 mt-3">
								<p>Komentarz</p>
								<div class="input-group">
									<div class="input-group-prepend"></div>
									<textarea class="form-control" name="comment" aria-label="With textarea"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mt-3 text-center">
								<button type="submit" class="btn btn-block btn-outline-success btn-lg">Zatwierdź</button>
							</div>
							<div class="col-md-6 mt-3 text-center">
								<a role="button" href="main_menu.php" class="btn btn-block btn-outline-danger btn-lg">Anuluj</a>
							</div>
						</div>
					</form>
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
