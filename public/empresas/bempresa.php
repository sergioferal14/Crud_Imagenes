<?php 
session_start();
require dirname(__DIR__,2)."/vendor/autoload.php";
use Empresa\Empresas;

if(!isset($_POST['id'])){
    header("Location:index.php");
    die();
}

(new Empresas)->delete($_POST['id']);
$_SESSION['mensaje']="Empresa Borrada";
header("Location:index.php");
