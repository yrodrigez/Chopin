<?php
	//file: view/layouts/default.php
	require_once(__DIR__."/../../core/ViewManager.php");
	$view = ViewManager::getInstance();
	$currentuser = $view->getVariable("currentusername"); 
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<title><?= $view->getVariable("title", "no title") ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700" type="text/css">
		<link rel="stylesheet" href="Alex Brush.ttf">
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</head>

	<body>

		<div class="row" id="banner">
			<div id="title">Chopin</div>
		</div>

		<div class="container">

			<div class="row">
				<div class="col-xs-3">
					<div id="sidebar">
						<ul class="nav nav-pills nav-stacked" role="tablist">
							<li class="nav-pill" class="active"><a href="index.php?controller=concurso&amp;action=view">Concurso</a></li>
							<li class="nav-pill"><a href="#">Pinchos</a></li>
							<?php if (!isset($currentuser)): ?> 
								<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=login">Identificarse</a></li>
								<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=register">Registrarse</a></li>
							<?php else: ?>
								<li><a href="index.php?controller=usuarios&amp;action=logout">Desconectar <?= $currentuser ?></a></li>
							<?php endif ?>
							<li class="nav-pill"><a href="#">Contacto</a></li>        
						</ul>
					</div>
				</div>
				
				<div class="col-xs-9" id="content">
					<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
				</div>
			</div>
			
			
			<div class="row" id="footer">
				<div class="container text-center">
					<p class="text-muted">Chopin: <a href="#" data-toggle="tooltip" data-placement="top" title="Hooray!">ABP Project.</a></p>
				</div>
			</div>
		</div>
		
		
		
		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
			});
		</script>
	</body>
</html>