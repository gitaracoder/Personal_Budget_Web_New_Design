<?php
	session_start();
	
	$_SESSION['message'] = '';
	
	if((!isset($_POST['inputUserEmailLogIn'])) || (!isset($_POST['inputUserPasswordLogIn'])))
	{
		header('Location: login.php');
		exit();
	}

	require_once "connect.php";
	
	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno != 0)
	{
		$_SESSION['serverErrorMessage'] = 'Błąd serwera, przepraszamy za niedogodności!';
		header('Location: login.php');
	}
	else
	{
		$login = $_POST['inputUserEmailLogIn'];
		$password = $_POST['inputUserPasswordLogIn'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		if ($result = @$connection->query(sprintf("SELECT * FROM users WHERE email='%s'", 
		mysqli_real_escape_string($connection, $login))))
		{
			$usersAmount = $result->num_rows;
			if($usersAmount > 0)
			{
				$row = $result->fetch_assoc();
				
				if(password_verify($password, $row['password']))
				{
					$_SESSION['zalogowany'] = true; 
					$_SESSION['id'] = $row['id'];
					$_SESSION['name'] = $row['username'];
					
					unset($_SESSION['blad']);
					$result->close();
					
					header('Location: main_menu.php');
				}
				else
				{
					$_SESSION['loginError'] = '<div class="mb-3 text-danger">Wprowadzono niepoprawny login lub hasło. Spróbuj ponownie.</div>';
					header('Location: login.php');
				}
			}
			else
			{
				$_SESSION['loginError'] = '<div class="mb-3 text-danger">Wprowadzono niepoprawny login lub hasło. Spróbuj ponownie.</div>';
				header('Location: login.php');
			}
		}
		$connection->close();
	}
?>