<?php

echo "HOLA";

include_once("../model/Include.php");
echo "fin includes";
$organizador = new Usuario("org@chopin.ou", "123456", "Organizador", 0, 988354856, "/img/foto.png");
echo "creado organizador";

$populares= array(
	$juradoPopular1= new Usuario("JP1@chopin.ou", "123456", "Alberto Meneses1", 1, 988354856, "/img/foto.png"),
	$juradoPopular2= new Usuario("JP2@chopin.ou", "123456", "Alberto Meneses2", 1, 988354856, "/img/foto.png"),
	$juradoPopular3= new Usuario("JP3@chopin.ou", "123456", "Alberto Meneses3", 1, 988354856, "/img/foto.png"),
	$juradoPopular4= new Usuario("JP4@chopin.ou", "123456", "Alberto Meneses4", 1, 988354856, "/img/foto.png"),
	$juradoPopular5= new Usuario("JP5@chopin.ou", "123456", "Alberto Meneses5", 1, 988354856, "/img/foto.png")
);

echo"<br>CreadosPopulares";

$establcimientos= array(
	$establecimiento1= new Establecimiento(
			"est1@chopin.ou","123456","Bar Orellas", 2, 34986255275, "/img/foto.png", "51.9161291,-8.5420309,12", "calle de los vinos"),
	$establecimiento2= new Establecimiento(
			"est2@chopin.ou","123456","Bar Orellas", 2, 34986255275, "/img/foto.png", "51.9161291,-8.5420309,12", "calle de los vinos"),
	$establecimiento3= new Establecimiento(
			"est3@chopin.ou","123456","Bar Orellas", 2, 34986255275, "/img/foto.png", "51.9161291,-8.5420309,12", "calle de los vinos"),
	$establecimiento4= new Establecimiento(
			"est4@chopin.ou","123456","Bar Orellas", 2, 34986255275, "/img/foto.png", "51.9161291,-8.5420309,12", "calle de los vinos"),
	$establecimiento5= new Establecimiento(
			"est5@chopin.ou","123456","Bar Orellas", 2, 34986255275, "/img/foto.png", "51.9161291,-8.5420309,12", "calle de los vinos")
);

echo"<br>CreadosEstablecimientos";
$profesionales= array(
	$juradoProfesional1 = new JuradoProfesional("jpf1@chopin.ou", "123456","juradoProfesional1",3,582763489922,"/img/foto.png","muchisima"),
	$juradoProfesional2 = new JuradoProfesional("jpf2@chopin.ou", "123456","juradoProfesional2",3,582763489922,"/img/foto.png","muchisima"),
	$juradoProfesional3 = new JuradoProfesional("jpf3@chopin.ou", "123456","juradoProfesional3",3,582763489922,"/img/foto.png","muchisima"),
	$juradoProfesional4 = new JuradoProfesional("jpf4@chopin.ou", "123456","juradoProfesional4",3,582763489922,"/img/foto.png","muchisima"),
	$juradoProfesional5 = new JuradoProfesional("jpf5@chopin.ou", "123456","juradoProfesional5",3,582763489922,"/img/foto.png","muchisima")
);

echo"<br>CreadosProfesionales";
$usuarioMapper= new UsuarioMapper();
$juradoProfMapper= new JuradoProfesionalMaper();
$establecimientoMapper= new EstablecimientoMapper();
echo"<br>Creados Mapper";

//BORRADO
if($usuarioMapper->borrarUsuario($organizador)){
	echo "<br><span style='color: green'>Usuario ".$organizador->getNombre()." borrado</span><br>";
}else{
	echo "<br><span style='color: red'>Usuario ".$organizador->getNombre()." no encontrado</span><br>";
}

foreach($populares as $popular){
	if($usuarioMapper->borrarUsuario($popular)){
		echo "<br><span style='color: green'>Usuario ".$popular->getNombre()." borrado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$popular->getNombre()." no encontrado</span><br>";
	}
}

foreach($establcimientos as $establcimiento){
	if($establecimientoMapper->borrarEstablecimiento($establcimiento)){
			echo "<br><span style='color: green'>Establecimiento ".$establcimiento->getNombre()." borrado</span><br>";
	}else{
			echo "<br><span style='color: red'>Establcimiento ".$establcimiento->getNombre()." no encontrado</span><br>";
	}
}

foreach($profesionales as $profesional)
{
	if($juradoProfMapper->borrarJuradoProfesional($profesional)){
		echo "<br><span style='color: green'>Usuario ".$profesional->getNombre()." borrado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$profesional->getNombre()." no encontrado</span><br>";
	}
}

//INSERTADO
if($usuarioMapper->registrarUsuario($organizador)){
	echo "<br><span style='color: green'>Organizador insertado</span><br>";
}else{
	echo "<br><span style='color: red'>Organizador no encontrado</span><br>";
}

foreach($populares as $popular){
	if($usuarioMapper->registrarUsuario($popular)){
		echo "<br><span style='color: green'>Usuario ".$popular->getNombre()." insertado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$popular->getNombre()." No insertado</span><br>";
	}
}
foreach($profesionales as $profesional){
	if($juradoProfMapper->resgitrarJuradoProfesional($profesional)){
		echo "<br><span style='color: green'>Profesional ".$profesional->getNombre()." insertado</span><br>";
	}else{
		echo "<br><span style='color: #ff001a'>Profesional " .$profesional->getNombre()." No insertado</span><br>";
	}
}
foreach($establcimientos as $establcimiento){
	if($establecimientoMapper->registrarEstablecimiento($establcimiento)){
		echo "<br><span style='color: green'>Establecimiento ".$establcimiento->getNombre()." insertado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$establcimiento->getNombre()." insertado</span><br>";
	}
}
//Re-BORRADO
if($usuarioMapper->borrarUsuario($organizador)){
	echo "<br><span style='color: green'>Usuario ".$organizador->getNombre()." borrado</span><br>";
}else{
	echo "<br><span style='color: red'>Usuario ".$organizador->getNombre()." no encontrado</span><br>";
}

foreach($populares as $popular){
	if($usuarioMapper->borrarUsuario($popular)){
		echo "<br><span style='color: green'>Usuario ".$popular->getNombre()." borrado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$popular->getNombre()." no encontrado</span><br>";
	}
}

foreach($establcimientos as $establcimiento){
	if($establecimientoMapper->borrarEstablecimiento($establcimiento)){
		echo "<br><span style='color: green'>Establecimiento ".$establcimiento->getNombre()." borrado</span><br>";
	}else{
		echo "<br><span style='color: red'>Establcimiento ".$establcimiento->getNombre()." no encontrado</span><br>";
	}
}

foreach($profesionales as $profesional)
{
	if($juradoProfMapper->borrarJuradoProfesional($profesional)){
		echo "<br><span style='color: green'>Usuario ".$profesional->getNombre()." borrado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$profesional->getNombre()." no encontrado</span><br>";
	}
}

//REINSERTADO
$usuarioMapper->registrarUsuario($organizador);

foreach($populares as $popular){
	if($usuarioMapper->registrarUsuario($popular)){
		echo "<br><span style='color: green'>Usuario ".$popular->getNombre()." insertado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$popular->getNombre()." No insertado</span><br>";
	}
}
foreach($profesionales as $profesional){
	if($juradoProfMapper->resgitrarJuradoProfesional($profesional)){
		echo "<br><span style='color: green'>Profesional ".$profesional->getNombre()." insertado</span><br>";
	}else{
		echo "<br><span style='color: #ff001a'>Profesional " .$profesional->getNombre()." No insertado</span><br>";
	}
}
foreach($establcimientos as $establcimiento){
	if($establecimientoMapper->registrarEstablecimiento($establcimiento)){
		echo "<br><span style='color: green'>Establecimiento ".$establcimiento->getNombre()." insertado</span><br>";
	}else{
		echo "<br><span style='color: red'>Usuario ".$establcimiento->getNombre()." insertado</span><br>";
	}
}

echo "<br><h1 style='color: blue'>TODO OK</h1>";



?>
