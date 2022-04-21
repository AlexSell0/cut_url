<?php
    include_once 'functions.php';

    if(empty($_SESSION['user']['id']) || empty($_GET['id']) || empty($_GET['url'])){
        header("Location: /profile.php");
    }

    $url = get_link_user_info($_GET['url']);

    if($url['user_id'] != $_SESSION['user']['id']){

        message("Вы не можете отредактировать эту ссылку");
        header("Location: /profile.php");

    }else if(!empty($_POST['link'])){

        edit_links($url['id'], $_POST['link']);
        header("Location: /profile.php");
        message("Ссылка успешно отредактирована", true);

    }

    include_once 'header.php'; 
?>
<main class="container">
		
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Вход в личный кабинет</h2>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-4 offset-4">
				<form action="" method="POST">
					<div class="mb-3">
						<label for="login-input" class="form-label">Ссылка</label>
						<input name="link" type="text" class="form-control is-valid" value="<?php echo $_GET['url']; ?>" id="login-input" required="">
					</div>
					<button type="submit" class="btn btn-primary">Редактировать</button>
                    <a href="<?php echo get_url('profile.php'); ?>" class="btn btn-primary">Отмена</a>
				</form>
			</div>
		</div>
	</main>