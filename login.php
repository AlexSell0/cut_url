<?php 
	include_once "includs/functions.php";

	if(isset($_SESSION['user']['id'])){
        header("Location: profile.php");
		die;
	}

	$message = "";

	if(isset($_SESSION["message"]) && !empty($_SESSION["message"])){
		$message = $_SESSION["message"];
		$_SESSION["message"] = "";
	};

	if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pass']) && !empty($_POST['pass'])){
		login_user($_POST);
	};

	include 'includs/header.php'; 
	
?>
	<main class="container">
		<?php 
			if(!empty($message)){
				echo $message;
			};
		?>

		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Вход в личный кабинет</h2>
				<p class="text-center">Если вы еще не зарегистрированы, то самое время <a href="<?php echo get_url("register.php") ?>">зарегистрироваться</a></p>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="" method="POST">
					<div class="mb-3">
						<label for="login-input" class="form-label">Логин</label>
						<input name="login" type="text" class="form-control is-valid" id="login-input" required>
					</div>
					<div class="mb-3">
						<label for="password-input" class="form-label">Пароль</label>
						<input name="pass" type="password" class="form-control is-invalid" id="password-input" required>
					</div>
					<button type="submit" class="btn btn-primary">Войти</button>
				</form>
			</div>
		</div>
	</main>

	<?php include 'includs/footer.php'; ?>
