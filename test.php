<?php
include("inc.includes.php");
$db = new MySQL($config["dbhost"],$config["dbuser"],$config["dbpass"],$config["db"]);

/*$tipo = new Tipo_Controller();
$result = $tipo->verTipo();
foreach ($result as $t){
    echo $t["name"];
    echo "<br>";
}*/
$estado = new Estado_Controller();
//MUESTRO TODO:
$res = $estado->verEstado();
foreach ($res as $p) {
    echo $p["name"];
    echo "<br>";
}
echo "<br>";
echo "<br>";
//NUEVO LO QUE SEA:
$estado->nuevoEstado("entregado");
//MUESTRO LO AGRAGADO
$res1 = $estado->verEstado();
foreach ($res1 as $p) {
    echo $p["name"];
    echo "<br>";
}
echo "<br>";
echo "<br>";
//MODIFICO LO QUE SEA
$estado->modificarEstado(9,"pagado");
//MUESTRO LO EDITADO
$res2 = $estado->verEstado();
foreach ($res2 as $p) {
    echo $p["name"];
    echo "<br>";
}
echo "<br>";
echo "<br>";
//ELIMINO EL ULTIMO
$estado->eliminarEstado(9);
//MUESTRO TODO POR ULTIMA VEZ
$res3 = $estado->verEstado();
foreach ($res3 as $p) {
    echo $p["name"];
    echo "<br>";
}
echo "<br>";
echo "<br>";



