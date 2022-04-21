<?php 
	include 'includs/header-profile.php'; 
	
	$message = "";

	if(isset($_SESSION["message"]) && !empty($_SESSION["message"])){
		$message = $_SESSION["message"];
		$_SESSION["message"] = "";
	};

	$links = ger_user_links($_SESSION['user']['id']);
?>

	<main class="container">
		<?php 
			if(!empty($message)){
				echo $message;
			};
		?>
		<div class="row mt-5">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Ссылка</th>
						<th scope="col">Сокращение</th>
						<th scope="col">Переходы</th>
						<th scope="col">Действия</th>
					</tr>
				</thead>
				<tbody>
				<?php
					set_table($links);
				?>
				</tbody>
			</table>
		</div>
	</main>
	<div aria-live="polite" aria-atomic="true" class="position-relative">
		<div class="toast-container position-absolute top-0 start-50 translate-middle-x">
			<div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						Ссылка скопирована в буфер
					</div>
					<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
	</div>


	<?php include 'includs/footer-profile.php'; ?>
