<?php
	//file: view/layouts/default.php
	require_once(__DIR__."/../../core/ViewManager.php");
	require_once(__DIR__."/../../model/Concurso.php");
    require_once(__DIR__."/../../model/Usuario.php");
	require_once(__DIR__."/../../model/ConcursoMapper.php");
	require_once(__DIR__."/../../model/PinchoMapper.php");
	$view = ViewManager::getInstance();
	$currentuser = $view->getVariable("currentusername");

	function getNavItems($phone) {
		$concurso = (new ConcursoMapper())->getInfo();
		$started = $concurso->isStarted();

		$items = '<li class="nav-pill"><a href="index.php?controller=concurso&amp;action=view">Concurso</a></li>';
		if($started or isset($_SESSION["type"]) and $_SESSION["type"]==Usuario::ORGANIZADOR) {
			$items .= '<li class="nav-pill"><a href="index.php?controller=pinchos&amp;action=listar">Pinchos</a></li>';
		}
		if (!isset($_SESSION["user"])) {
			if($started) {
				$items .= '<li class="nav-pill"><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>';
			}

			$items .= '<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=login">'. (($phone)?'<span class="glyphicon glyphicon-log-in"></span> ':'') . 'Identificarse</a></li>';

			if($started) {
				$items .= '<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=register">'. (($phone)?'<span class="glyphicon glyphicon-user"></span> ':'') . 'Registrarse</a></li>';
			} else {
				$items .= '<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=register">'. (($phone)?'<span class="glyphicon glyphicon-user"></span> ':'') . 'Registrar establecimiento</a></li>';
			}

		} else {
			if($_SESSION["type"]==Usuario::ORGANIZADOR and !$started) {
				$items .= '<li><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>';
				$items.= '<li><a href="index.php?controller=usuarios&amp;action=index">Jurado Popular</a></li>';
				$items.= '<li><a href="index.php?controller=establecimiento&amp;action=index">Establecimientos</a></li>';
			} else if($_SESSION["type"]==Usuario::JURADO_POPULAR) {
				$items .= '<li><a href="index.php?controller=pinchos&amp;action=listarPinchosUsuario">Mis pinchos</a></li><li><a href="index.php?controller=codigos&amp;action=introducir">Introducir Código</a></li><li><a href="index.php?controller=pinchos&amp;action=misVotos">Mis Votaciones</a></li><li><a href="index.php?controller=usuarios&amp;action=view&amp;id='.$_SESSION["user"].'">Mi cuenta</a></li>';
			} else if($_SESSION["type"]==Usuario::ORGANIZADOR and $started) {
				$items.= '<li><a href="index.php?controller=usuarios&amp;action=index">Jurado Popular</a></li>';
			} else if($_SESSION["type"]==Usuario::ESTABLECIMIENTO) {

				if(!$started and !(new PinchoMapper())->existePincho($_SESSION["user"])) {
					$items .= '<li><a href="index.php?controller=pinchos&amp;action=presentar">Propuesta</a></li>';
				} else {
					$items .= '<li><a href="index.php?controller=pinchos&amp;action=view">Propuesta</a></li>';
				}

				if((new PinchoMapper())->getPinchoValidado($_SESSION["user"])<>-1) {
					$items .= '<li><a href="index.php?controller=codigos&amp;action=generar">Generar c&oacute;digos</a></li>';
				}

				$items .= '<li><a href="index.php?controller=establecimiento&amp;action=view&amp;id='.$_SESSION["user"].'">Mi cuenta</a></li>';
			}

			if($started) {
				$items .= '<li class="nav-pill"><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>';
				$items.= '<li><a href="index.php?controller=establecimiento&amp;action=index">Establecimientos</a></li>';
			}

			$items .= '<li><a href="index.php?controller=usuarios&amp;action=logout">Desconectar <?= $currentuser ?></a></li>';

		}
		return $items;
	}
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<title><?= $view->getVariable("title", "no title") ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/fileinput.min.css" type="text/css">
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<link rel="stylesheet" href="css/jquery.tagsinput.css" type="text/css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700" type="text/css">
		<link rel="stylesheet" href="Alex Brush.ttf">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/fileinput.min.js"></script>
		<script src="js/jquery.tagsinput.js"></script>
		<script src="js/validator.js"></script>

	</head>

	<body>

        <div id="msg-container">
            <?php
            $msg = $view->popFlash();
            if($msg):
                foreach($msg as $m):
                    if($m[0] == "success"):
                        echo '<div class="alert alert-success flash"><button type="button" class="close" data-dismiss="alert">&nbsp;×</button>' . $m[1] . '</div>';
                    endif;
                    if($m[0] == "error"):
                        echo '<div class="alert alert-danger flash"><button type="button" class="close" data-dismiss="alert">&nbsp;×</button>' . $m[1] . '</div>';
                    endif;
                endforeach;
            endif;
            ?>
        </div>

		<nav class="navbar navbar-inverse visible-xs">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav"> <?= getNavItems(true); ?> </ul>
				</div>
			</div>
		</nav>


		<div class="row" id="banner">
			<div id="title">Chopin</div>
		</div>

		<div class="container">

			<div class="row">
				<div class="col-sm-3 hidden-xs">
					<div id="sidebar">
						<ul class="nav nav-pills nav-stacked" role="tablist">
							<?= getNavItems(false); ?>
						</ul>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9" id="content">
					<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
				</div>
			</div>

			<div class="row" id="footer">
				<div class="container text-center">
					<p class="text-muted">Chopin: <a href="#">ABP Project.</a></p>
				</div>
			</div>


		</div>

	</body>


    <script>

        $(document).ready(function() {
			$("#msg-container").delay(3000).fadeOut('slow');
        });

        <?= $view->getFragment("script") ?>
    </script>
</html>