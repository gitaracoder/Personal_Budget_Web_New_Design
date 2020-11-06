<?php
	session_start();
	
	$_SESSION['message'] = '';
	
	if(isset($_POST['period']))
	{
		$_SESSION['selectOption'] = $_POST['period'];
	}
	else
	{
		$_SESSION['selectOption'] = "currentMonth";
	}
							
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
		
		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>  
		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
	</head>
  
	<body>
	<?php
		if(isset($_SESSION['balanceMessage']))
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
					<h2><i class="demo-icon icon-book-open"></i> Przeglądaj bilans</h2>
					<form method="post">
						<div class="row mb-3">
							<div class="col-md-6">
								<p>Wybierz okres</p>
								<?php
								if($_SESSION['selectOption'] == "currentMonth")
								{
									echo '<select class="custom-select" name="period">';
									echo '<option value="currentMonth" selected>Bieżący miesiąc</option>';
									echo '<option value="lastMonth">Poprzedni miesiąc</option>';
									echo '<option value="currentYear">Bieżący rok</option>';
									echo '<option value="custom">Niestandardowy</option>';
								}
								else if($_SESSION['selectOption'] == "lastMonth")
								{
									echo '<select class="custom-select" name="period">';
									echo '<option value="currentMonth">Bieżący miesiąc</option>';
									echo '<option value="lastMonth" selected>Poprzedni miesiąc</option>';
									echo '<option value="currentYear">Bieżący rok</option>';
									echo '<option value="custom">Niestandardowy</option>';
								}
								else if($_SESSION['selectOption'] == "currentYear")
								{
									echo '<select class="custom-select" name="period">';
									echo '<option value="currentMonth">Bieżący miesiąc</option>';
									echo '<option value="lastMonth">Poprzedni miesiąc</option>';
									echo '<option value="currentYear" selected>Bieżący rok</option>';
									echo '<option value="custom">Niestandardowy</option>';
								}
								else if($_SESSION['selectOption'] == "custom")
								{
									echo '<select class="custom-select" name="period">';
									echo '<option value="currentMonth">Bieżący miesiąc</option>';
									echo '<option value="lastMonth">Poprzedni miesiąc</option>';
									echo '<option value="currentYear">Bieżący rok</option>';
									echo '<option value="custom" selected>Niestandardowy</option>';
								}
								?>
								</select>
							</div>							
							<div class="col-md-6">
								<label for="beginDate">Początek zakresu</label>
								<input type="date" class="form-control" name="beginDate">
							</div>
							
							<div class="col-md-6 mt-3 text-center">
								<button type="submit" class="btn btn-block btn-outline-success btn-lg">Pokaż dane z wybranego okresu</button>
							</div>
							
							<div class="col-md-6">
								<label for="endDate">Koniec zakresu</label>
								<input type="date" class="form-control" name="endDate">
							</div>
						</div>
						</form>
						
						<?php
							if(isset($_POST['beginDate']))
							{							
								$beginDate = $_POST['beginDate'];
								$endDate = $_POST['endDate'];							
							}
							
							$periodTime = $_SESSION['selectOption'];

							$loggedInUserID = $_SESSION['id'];
							
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
									echo '
										<div class="row">
										<div class="col-md-6">
										<p class="font-weight-bold">Przychody</p>
										<table class="table table-hover">
										<thead>
										<tr>
										<th scope="col">#</th>
										<th scope="col">Kategoria</th>
										<th scope="col">Kwota</th>
										</tr>
										</thead>
										<tbody>										
									';
									
									if($periodTime == "currentMonth")
									{
										$result = $connection->query("SELECT * FROM incomes WHERE user_id='$loggedInUserID' AND Year(date_of_income) = Year(Now()) And Month(date_of_income) = Month(Now())");
										$sumOfIncomes=$connection->query("SELECT SUM(amount) FROM incomes WHERE user_id='$loggedInUserID' AND Year(date_of_income) = Year(Now()) And Month(date_of_income) = Month(Now())");
									}
									else if($periodTime == "lastMonth")
									{
										$result=$connection->query("SELECT * FROM incomes WHERE user_id='$loggedInUserID' AND YEAR(date_of_income) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date_of_income) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");									
										$sumOfIncomes=$connection->query("SELECT SUM(amount) FROM incomes WHERE user_id='$loggedInUserID' AND YEAR(date_of_income) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date_of_income) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");
									}									
									else if($periodTime == "currentYear")
									{
										$result = $connection->query("SELECT * FROM incomes WHERE user_id='$loggedInUserID' AND YEAR(`date_of_income`) = YEAR(CURDATE())");
										$sumOfIncomes=$connection->query("SELECT SUM(amount) FROM incomes WHERE user_id='$loggedInUserID' AND YEAR(`date_of_income`) = YEAR(CURDATE())");
									}
									else if($periodTime == "custom")
									{
										$result = $connection->query("SELECT * FROM incomes WHERE user_id='$loggedInUserID' AND date_of_income BETWEEN '$beginDate' AND '$endDate'");
										$sumOfIncomes = $connection->query("SELECT SUM(amount) FROM incomes WHERE user_id='$loggedInUserID' AND date_of_income BETWEEN '$beginDate' AND '$endDate'");
									}
									
									$sumOfIncomes = $sumOfIncomes->fetch_assoc();
									
									if($result->num_rows > 0) 
									{
										$i = 0;
										while($r = $result->fetch_assoc())
										{	
											$i++;	
											
											echo '<tr>';
											echo '<th scope="row">'.$i.'</th>';
											$idOfSearchedCategory = $r['income_category_assigned_to_user_id'];
											$nameOfCategory = $connection->query("SELECT name FROM incomes_category_assigned_to_users WHERE id='$idOfSearchedCategory'");
											$nameOfCategory = $nameOfCategory->fetch_assoc();
											echo '<td>'.$nameOfCategory['name'].'</td>';
											echo '<td>'.$r['amount'].'</td>';
											echo '</tr>';										   
										}
									}	
									$incomes = $sumOfIncomes['SUM(amount)'];	
									
									echo '											
										</tbody>
										</table>
										<p class="font-weight-bold">Suma przychodów: '.$sumOfIncomes['SUM(amount)'].'</p>
										</div>																	
										<div class="col-md-6">
										<p class="font-weight-bold">Wydatki</p>
										<table class="table table-hover">
										<thead>
										<tr>
										<th scope="col">#</th>
										<th scope="col">Kategoria</th>
										<th scope="col">Kwota</th>
										</tr>
										</thead>
										<tbody>										
									';
									
									if($periodTime == "currentMonth")
									{
										$result = $connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND Year(date_of_expense) = Year(Now()) And Month(date_of_expense) = Month(Now())");
										$sumOfExpenses = $connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND Year(date_of_expense) = Year(Now()) And Month(date_of_expense) = Month(Now())");
									}
									else if($periodTime == "lastMonth")
									{
										$result=$connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(date_of_expense) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date_of_expense) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");
										$sumOfExpenses=$connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(date_of_expense) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date_of_expense) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");
									}
									else if($periodTime == "currentYear")
									{
										$result = $connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(`date_of_expense`) = YEAR(CURDATE())");
										$sumOfExpenses = $connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(`date_of_expense`) = YEAR(CURDATE())");
									}
									else if($periodTime == "custom")
									{
										$result = $connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND date_of_expense BETWEEN '$beginDate' AND '$endDate'");
										$sumOfExpenses = $connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND date_of_expense BETWEEN '$beginDate' AND '$endDate'");
									}
		
									$sumOfExpenses = $sumOfExpenses->fetch_assoc();
									
									if($result->num_rows > 0) 
									{
										$i = 0;
										while($r = $result->fetch_assoc())
										{	
											$i++;
											
											echo '<tr>';
											echo '<th scope="row">'.$i.'</th>';
											$idOfSearchedCategory = $r['expense_category_assigned_to_user_id'];
											$nameOfCategory=$connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE id='$idOfSearchedCategory'");
											$nameOfCategory = $nameOfCategory->fetch_assoc();
											echo '<td>'.$nameOfCategory['name'].'</td>';
											echo '<td>'.$r['amount'].'</td>';
											echo '</tr>';										   
										}
									}	

									$expenses = $sumOfExpenses['SUM(amount)'];						
										
									echo '											
										</tbody>
										</table>
										<p class="font-weight-bold">Suma wydatków: '.$sumOfExpenses['SUM(amount)'].'</p>
										</div>		
										</div>
									';
									
									$connection->close();
								}
							}
							catch(Exception $e)
							{
								$_SESSION['balanceMessage'] = 'error';
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
							
									if($periodTime == "currentMonth")
									{
										$result = $connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND Year(date_of_expense) = Year(Now()) And Month(date_of_expense) = Month(Now())");
										$sumOfExpenses=$connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND Year(date_of_expense) = Year(Now()) And Month(date_of_expense) = Month(Now())");
									}
									else if($periodTime == "lastMonth")
									{
										$result = $connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(date_of_expense) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date_of_expense) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");
										$sumOfExpenses=$connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(date_of_expense) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date_of_expense) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");
									}
									else if($periodTime == "currentYear")
									{
										$result = $connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(`date_of_expense`) = YEAR(CURDATE())");
										$sumOfExpenses=$connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND YEAR(`date_of_expense`) = YEAR(CURDATE())");
									}
									else if($periodTime == "custom")
									{
										$result = $connection->query("SELECT * FROM expenses WHERE user_id='$loggedInUserID' AND date_of_expense BETWEEN '$beginDate' AND '$endDate'");
										$sumOfExpenses = $connection->query("SELECT SUM(amount) FROM expenses WHERE user_id='$loggedInUserID' AND date_of_expense BETWEEN '$beginDate' AND '$endDate'");
									}
		
									$sumOfExpenses = $sumOfExpenses->fetch_assoc();
																
									echo '				
									<script type="text/javascript">		
									window.onload = function() {
									var options = {

									backgroundColor: "",  title: {
									fontStyle: "Arial",
										text: ""
									},
									data: [{
									fontStyle: "Arial",
											type: "pie",
											startAngle: 45,
											showInLegend: "true",
											legendText: "{label}",
											indexLabel: "{label} ({y})",
											yValueFormatString:"#,##0.#"%"",
											dataPoints: [
									';
									if($result->num_rows > 0) 
									{
										while($c = $result->fetch_assoc())
										{	
											$idOfSearchedCategory = $c['expense_category_assigned_to_user_id'];
											$nameOfCategory = $connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE id='$idOfSearchedCategory'");
											$nameOfCategory = $nameOfCategory->fetch_assoc();
											echo '{ label: "'.$nameOfCategory['name'].'", y: '.$c['amount'].' },';											   
										}
									}
									
									echo '
										]
										}]
										};
										$("#chartContaine").CanvasJSChart(options);
										}
										</script>
	
									';
									
									$connection->close();
								}
							}
							catch(Exception $e)
							{
								$_SESSION['balanceMessage'] = 'error';
							}
							
							
							echo '
								<div class="row">
								<div class="col-md-12 mt-3">
								<div id="chartContaine" style="height: 370px; margin: 0px auto; margin-bottom: 30px; margin-top: 20px;">
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-md-12 mt-3">
								';
								
								if(!isset($_SESSION['balanceMessage']))
								{
									if($incomes >= $expenses)
									{
										echo '<h2 class="text-center text-success">Gratulacje. Świetnie zarządzasz finansami!</h2>';
									}
									else
									{
										echo '<h2 class="text-center text-danger">Uważaj, wydajesz więcej niż zarabiasz!</h2>';
									}
								}
									
								echo '
									</div>
									</div>
								';
						?>
					
					<div class="row">
						<div class="col-md-12">
							<a role="button" href="main_menu.php" class="btn mb-3 mt-3 btn-block btn-outline-primary btn-lg"><i class="demo-icon icon-list"></i> Menu główne</a>
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
		
		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>  
		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
		
		<script src="js/bootstrap.min.js"></script>
		
	  
	</body>
</html>










