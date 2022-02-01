<?php session_start();

$getPost=array_merge($_POST,$_GET,$_FILES);

$controlador=$_POST['controlador'];
$metodo=$_POST['metodo'];

$nombreControlador='C_'.$controlador;

require_once 'controladores/'.$nombreControlador.'.php';
$objControlador=new $nombreControlador();

$objControlador->$metodo($getPost);


?>