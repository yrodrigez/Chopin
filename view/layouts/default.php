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
		$rowClass = ($phone)?"nav-pill-collapse":'class="nav-pill"';

		$items = '<li ' .$rowClass .'><a href="index.php?controller=concurso&amp;action=view">Concurso</a></li>';
		$items .= '<li ' .$rowClass .'><a href="index.php?controller=concurso&amp;action=gastromapa">Gastromapa</a></li>';
		if($started or isset($_SESSION["type"]) and $_SESSION["type"]==Usuario::ORGANIZADOR) {
			$items .= '<li ' .$rowClass .'><a href="index.php?controller=pinchos&amp;action=listar">Pinchos</a></li>';
		}
		if (!isset($_SESSION["user"])) {
			if($started) {
				$items.= '<li ' .$rowClass .'><a href="index.php?controller=establecimiento&amp;action=index">Establecimientos</a></li>';
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>';
				$items.= '<li ' .$rowClass .'><a href="index.php?controller=pinchos&amp;action=buscar">Búsqueda</a></li>';
			}

			$items .= '<li ' .$rowClass .'><a href="index.php?controller=usuarios&amp;action=login">'. (($phone)?'<span class="glyphicon glyphicon-log-in"></span> ':'') . 'Identificarse</a></li>';

			if($started) {
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=usuarios&amp;action=register">'. (($phone)?'<span class="glyphicon glyphicon-user"></span> ':'') . 'Registrarse</a></li>';
			} else {
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=usuarios&amp;action=register">'. (($phone)?'<span class="glyphicon glyphicon-user"></span> ':'') . 'Registrar establecimiento</a></li>';
			}

		} else {
			if($_SESSION["type"]==Usuario::ORGANIZADOR and !$started) {
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>';
				$items.= '<li ' .$rowClass .'><a href="index.php?controller=usuarios&amp;action=index">Jurado Popular</a></li>';
				$items.= '<li ' .$rowClass .'><a href="index.php?controller=establecimiento&amp;action=index">Establecimientos</a></li>';
			} else if($_SESSION["type"]==Usuario::JURADO_POPULAR) {
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=pinchos&amp;action=listarPinchosUsuario">Mis pinchos</a></li><li><a href="index.php?controller=codigos&amp;action=introducir">Introducir Código</a></li><li><a href="index.php?controller=pinchos&amp;action=misVotos">Mis Votaciones</a></li><li><a href="index.php?controller=usuarios&amp;action=view&amp;id='.$_SESSION["user"].'">Mi cuenta</a></li>';
			} else if($_SESSION["type"]==Usuario::ORGANIZADOR and $started) {
				$items.= '<li ' .$rowClass .'><a href="index.php?controller=usuarios&amp;action=index">Jurado Popular</a></li>';
			} else if($_SESSION["type"]==Usuario::ESTABLECIMIENTO) {

				if(!$started and !(new PinchoMapper())->existePincho($_SESSION["user"])) {
					$items .= '<li ' .$rowClass .'><a href="index.php?controller=pinchos&amp;action=presentar">Propuesta</a></li>';
				} else {
					$items .= '<li ' .$rowClass .'><a href="index.php?controller=pinchos&amp;action=view">Propuesta</a></li>';
				}

				if((new PinchoMapper())->getPinchoValidado($_SESSION["user"])<>-1) {
					$items .= '<li ' .$rowClass .'><a href="index.php?controller=codigos&amp;action=generar">Generar c&oacute;digos</a></li>';
				}

				$items .= '<li ' .$rowClass .'><a href="index.php?controller=establecimiento&amp;action=view&amp;id='.$_SESSION["user"].'">Mi cuenta</a></li>';
			} else if($_SESSION["type"]==Usuario::JURADO_PROFESIONAL) {
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=juradoprofesional&amp;action=view&amp;id='.$_SESSION["user"].'">Mi cuenta</a></li>';
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=pinchos&amp;action=listarPinchosJuradoProfesional">Mis pinchos</a></li>';
			}



			if($started) {
				$items .= '<li ' .$rowClass .'><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>';
				$items.= '<li ' .$rowClass .'><a href="index.php?controller=establecimiento&amp;action=index">Establecimientos</a></li>';
				$items.= '<li ' .$rowClass .'><a href="index.php?controller=pinchos&amp;action=buscar">Búsqueda</a></li>';
			}

			$items .= '<li ' .$rowClass .'><a href="index.php?controller=usuarios&amp;action=logout">Desconectar <?= $currentuser ?></a></li>';

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
		<link rel="stylesheet" href="css/avgrund.css" type="text/css">
		<link rel="stylesheet" href="css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700" type="text/css">
		<link rel="stylesheet" href="Alex Brush.ttf">

		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/fileinput.min.js"></script>
		<script src="js/jquery.tagsinput.js"></script>
		<script src="js/validator.js"></script>
		<script src="js/avgrund.js"></script>
		<script src="http://maps.googleapis.com/maps/api/js"></script>
		<script src="js/star-rating.js" type="text/javascript"></script>

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
					<a class="navbar-brand" href="#"><img id="logonav" src="css/hamburger.png"></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav nav-container-collapse"> <?= getNavItems(true); ?> </ul>
				</div>
			</div>
		</nav>


		<div class="row" id="banner">
			<div id="title">
				<img id="logo" src="css/hamburger.png" class="hidden-xs"><span>Chopin</span>
			</div>
		</div>

		<div class="container" id="container">

			<div class="row">
				<div class="col-sm-1 hidden-xs"></div>
				<div class="col-sm-2 hidden-xs">
					<div id="sidebar">
						<ul class="nav nav-pills nav-stacked" role="tablist">
							<?= getNavItems(false); ?>
						</ul>
					</div>
				</div>

				<div class="col-xs-12 col-sm-8" id="content">
					<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
				</div>
			<div class="col-sm-1 hidden-xs"></div>
			</div>
		</div>
	</body>

	<div class="row" id="footer">
				<div class="container text-center">
					<p class="text-muted">Chopin: <a href="#" data-toggle="tooltip" data-placement="top" title="Hooray!">ABP Project.</a></p>
				</div>
	</div>

    <script>

        $(document).ready(function() {
			$("#msg-container").delay(3000).fadeOut('slow');
        });

        <?= $view->getFragment("script") ?>
    </script>
</html>