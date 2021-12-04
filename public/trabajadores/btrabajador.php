<?php 
session_start();
require dirname(__DIR__,2)."/vendor/autoload.php";
use Empresa\Trabajadores;

if(!isset($_POST['id'])){
    header("Location:index.php");
    die();
}

(new Trabajadores)->delete($_POST['id']);
$_SESSION['mensaje']="Trabajador despedido con exito!";
header("Location:index.php");