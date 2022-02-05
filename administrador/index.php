<?php
session_start();

if ($_POST) {
    if(($_POST['usuario']== "jesus")&&($_POST['pass']=="chuy123")) {
   
   $_SESSION['usuario']= "administrador";
   $_SESSION['nombreUsuario']="Jesús";

        header('Location:inicio.php'); 
}else{
    $mensaje = "ERROR: Usuario o Contraseña Incorrectos.";
}

}
?>
<!doctype html>
<html lang="es">

<head>
    <title>Aministrador</title>
    <link rel="shortcut icon" href="../img/admin.png">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <br><br><br>
        <div class="row">

            <div class="col-md-3">

            </div>

            <div class="col-md-6">
                <div class="card border-dark mb-3">
                    <div class="card-header">
                        Inicio de Sesión
                    </div>
                    <div class="card-body">

                    <?php if(isset($mensaje)){ ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                        <?php } ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Usuario:</label>
                                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Contraseña:</label>
                                <input type="password" class="form-control" name="pass" placeholder="Escribe tu contraseña">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-sing-in-alt"></i>   Entrar a Administrar</button>
                        </form>


                    </div>

                </div>
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
</body>

</html>