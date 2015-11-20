<?php
	//file: view/layouts/default.php
	require_once(__DIR__."/../../core/ViewManager.php");
	require_once(__DIR__."/../../model/Concurso.php");
    require_once(__DIR__."/../../model/Usuario.php");
	require_once(__DIR__."/../../model/ConcursoMapper.php");
	$view = ViewManager::getInstance();
	$currentuser = $view->getVariable("currentusername");
	$concurso = (new ConcursoMapper())->getInfo();
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<title><?= $view->getVariable("title", "no title") ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/fileinput.min.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700" type="text/css">
		<link rel="stylesheet" href="Alex Brush.ttf">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="js/fileinput.min.js"></script>


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


		<div class="row" id="banner">
			<div id="title">Chopin</div>
		</div>

		<div class="container">

			<div class="row">
				<div class="col-xs-3">
					<div id="sidebar">
						<ul class="nav nav-pills nav-stacked" role="tablist">
							<li class="nav-pill"><a href="index.php?controller=concurso&amp;action=view">Concurso</a></li>
							<?php if($concurso->isStarted()): ?>
								<li class="nav-pill"><a href="index.php?controller=pinchos&amp;action=listar">Pinchos</a></li>
							<?php endif; ?> 
							<?php if (!isset($currentuser)): ?>
                                <?php if($concurso->isStarted()): ?>
                                    <li class="nav-pill"><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>
                                <?php endif; ?>

								<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=login">Identificarse</a></li>
								
								<?php if($concurso->isStarted()): ?>
									<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=register">Registrarse</a></li>
								<?php else: ?> 
									<li class="nav-pill"><a href="index.php?controller=usuarios&amp;action=register">Registrar establecimiento</a></li>
								<?php endif; ?> 
							<?php else: ?>
								<?php if($_SESSION["type"]==Usuario::ORGANIZADOR and !$concurso->isStarted()): ?>
						            <li><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>
                                <?php endif; ?>

                                <?php if($_SESSION["type"]==Usuario::JURADO_POPULAR): ?>
						            <li><a href="index.php?controller=pinchos&amp;action=listarPinchosUsuario">Mis pinchos</a></li>
                                <?php endif; ?>

                                <?php if($_SESSION["type"]==Usuario::ESTABLECIMIENTO): ?>
                                    <?php if(!$concurso->isStarted()): ?>
						                <li><a href="index.php?controller=pinchos&amp;action=presentar">Propuesta</a></li>
						            <?php endif; ?>
                                <?php endif; ?>

                                <?php if($concurso->isStarted()): ?>
                                    <li class="nav-pill"><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>
								<?php endif; ?>
							
								<li><a href="index.php?controller=usuarios&amp;action=logout">Desconectar <?= $currentuser ?></a></li>
							<?php endif ?>
							       
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
	</body>


    <script>
        $(document).ready(function() {
            $("#msg-container").delay(3000).fadeOut('slow');
        });

        <?= $view->getFragment("script") ?>
    </script>
</html>