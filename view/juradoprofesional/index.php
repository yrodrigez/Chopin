<?php 
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $jurado = $view->getVariable("jurado");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Jurado Profesional"); 
?>

<h2 class="text-center">Jurado Profesional</h2><br>
<?php foreach ($jurado as $miembro): ?>
	<?php if(isset($_SESSION["type"]) && $_SESSION["type"]==0): ?>
		<a href="index.php?controller=juradoprofesional&amp;action=edit&amp;id=<?=$miembro->getEmail()?>">
	<?php endif; ?>
	
	<div class="thumbnail">
		<div class="row row-height">
			<div class="col-xs-4 col-sm-3 col-height">
				<img src="img/usuarios/<?= (($miembro->getFotoUsuario() != NULL)?$miembro->getFotoUsuario():"default.png") ?>" alt="Avatar" class="user-img img-circle">
			</div>
			
			<div class="col-xs-8 col-sm-6 col-height col-middle">
				<div class="thumb-username"><?=$miembro->getEmail()?></div>
			</div>
		</div>
	</div>
	
	<?php if(isset($_SESSION["type"]) && $_SESSION["type"]==0): ?>
		</a>
	<?php endif; ?>
<?php endforeach; ?>

<?php if(isset($_SESSION["type"]) && $_SESSION["type"]==0): ?>
	<a href="index.php?controller=juradoprofesional&amp;action=add" class="btn btn-default">A&ntilde;adir</a><br><br>
<?php endif; ?>