<?php 

require_once("config.php");

$sql = new Sql;

$usuarios = $sql->selectData("SELECT * FROM usuarios");

echo json_encode($usuarios);
 ?>