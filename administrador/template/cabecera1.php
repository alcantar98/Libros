<?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location:../../index.php");
    }else{
        if ($_SESSION['usuario']=="administrador" ){
            $nombreUsuario = $_SESSION['nombreUsuario'];
        }
    }
 ?>

<!doctype html>
<html lang="es">

<head>
    <title>Administrador</title>
    <link rel="shortcut icon" href="../../img/admin.png">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
   <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
--></head>

<body>

    <?php $url ="http://".$_SERVER['HTTP_HOST']."/libros"?>

    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="<?php echo $url;?>/administrador/inicio.php">
            <img src="../../img/admin.png" alt="admin" width="30px">Administrador del sitio </a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/libros_Add.php">Libros</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/cerrar.php">Cerrar sesión</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
        </div>
    </nav>
<br>
    <div class="container">
        <div class="row">
