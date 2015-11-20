<?php
	//file: view/layouts/default.php
	require_once(__DIR__."/../../core/ViewManager.php");
	require_once(__DIR__."/../../model/Concurso.php");
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
            $errors = $view->getVariable('msgErrors');
            $success = $view->getVariable('msgSuccess');
            if($errors):
                foreach($errors as $m):
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&nbsp;×</button>' . $m . '</div>';
                endforeach;
            elseif ($success):
                foreach($success as $m):
                    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&nbsp;×</button>' . $m . '</div>';
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
							<li class="nav-pill active"><a href="index.php?controller=concurso&amp;action=view">Concurso</a></li>
							<?php if($concurso->isStarted()): ?>
								<li class="nav-pill"><a href="#">Pinchos</a></li>

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
								<?php switch($_SESSION["type"]): ?>
                                    <?php case Usuario::ORGANIZADOR: ?>
									    <li><a href="index.php?controller=juradoprofesional&amp;action=index">Jurado Profesional</a></li>
                                    <?php case Usuario::JURADO_POPULAR: ?>
                                        <li><a href="index.php?controller=pinchos&amp;action=listarpinchosusuarios">Mis pinchos</a></li>
                                    <?php case Usuario::ESTABLECIMIENTO: ?>
									    <li><a href="index.php?controller=pinchos&amp;action=presentar">Propuesta</a></li>
                                <?php endswitch; ?>

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
        <?= $view->getFragment("script") ?>
    </script>
</html>