<?php
	//file: view/layouts/default.php
	require_once(__DIR__."/../../core/ViewManager.php");
	$view = ViewManager::getInstance();
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
		<script src="http://maps.googleapis.com/maps/api/js"></script>
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
			<div id="title">
				<div class="col-sm-1 hidden-xs" id="logo"></div>
				Chopin
			</div>
		</div>

		<div class="container">

			<div class="row">
				<div class="col-xs-12" id="content">
					<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
				</div>
			</div>

		</div>

		<div class="row" id="footer-in">
				<div class="container text-center">
					<p class="text-muted">Chopin: <a href="#" data-toggle="tooltip" data-placement="top" title="Hooray!">ABP Project.</a></p>
				</div>
		</div>

	</body>


	<script>

		$(document).ready(function () {

			if($(window).height() < $("#container").height() + 155) {
				//$("#footer").addClass("fixed-bottom");
				$("#footer").css("position", "relative");
				$("#footer").css("padding-bottom", "10px");
			}

			$("#msg-container").delay(3000).fadeOut('slow');
		});


		<?= $view->getFragment("script") ?>

	</script>
</html>