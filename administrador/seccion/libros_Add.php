<?php include("../template/cabecera1.php"); ?>
<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$ImgLibro = (isset($_FILES['ImgLibro']['name'])) ? $_FILES['ImgLibro']['name'] : "";
$DocLibro = (isset($_FILES['DocLibro']['name'])) ? $_FILES['DocLibro']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO `libros` (nombre,imagen,doc_pdf) VALUES ( :nombre, :imagen, :doc);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($ImgLibro != "") ? $fecha->getTimestamp() . "_" . $_FILES["ImgLibro"]["name"] : "imagen.jpg";
        $tmpImagen = $_FILES["ImgLibro"]["tmp_name"];
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }
        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);

        $nombreDocu = ($DocLibro != "") ? $fecha->getTimestamp() . "_" . $_FILES["DocLibro"]["name"] : "documento.pdf";
        $tmpDoc = $_FILES["DocLibro"]["tmp_name"];
        if ($tmpDoc != "") {
            move_uploaded_file($tmpDoc, "../../documentos/" . $nombreDocu);
        }
        $sentenciaSQL->bindParam(':doc', $nombreDocu);
        $sentenciaSQL->execute();
        header("Location:libros_Add.php");
        break;
    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE LIBROS SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $fecha = new DateTime();
        if ($ImgLibro != "") {

            $nombreArchivo = ($ImgLibro != "") ? $fecha->getTimestamp() . "_" . $_FILES["ImgLibro"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["ImgLibro"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM LIBROS WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img/" . $libro["imagen"])) {
                    unlink("../../img/" . $libro["imagen"]);
                }
            }


            $sentenciaSQL = $conexion->prepare("UPDATE LIBROS SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }
        if ($DocLibro != "") {

            $nombreDocu = ($DocLibro != "") ? $fecha->getTimestamp() . "_" . $_FILES["DocLibro"]["name"] : "documento.pdf";
            $tmpDoc = $_FILES["DocLibro"]["tmp_name"];
            move_uploaded_file($tmpDoc, "../../documentos/" . $nombreDocu);

            $sentenciaSQL = $conexion->prepare("SELECT doc_pdf FROM LIBROS WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["doc_pdf"]) && ($libro["doc_pdf"] != "documento.pdf")) {
                if (file_exists("../../documentos/" . $libro["doc_pdf"])) {
                    unlink("../../documentos/" . $libro["doc_pdf"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("UPDATE LIBROS SET doc_pdf=:doc WHERE id=:id");
            $sentenciaSQL->bindParam(':doc', $nombreDocu);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }
        header("Location:libros_Add.php");
        break;
    case "Cancelar":
            header("Location:libros_Add.php");
        break;
    case "Seleccionar":
        // echo "Presionado botón Seleccionar";
        $sentenciaSQL = $conexion->prepare("SELECT * FROM LIBROS WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $libro['nombre'];
        $ImgLibro = $libro['imagen'];
        $DocLibro = $libro['doc_pdf'];

        break;
    case "Borrar":
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM LIBROS WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $libro["imagen"])) {
                unlink("../../img/" . $libro["imagen"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("SELECT doc_pdf FROM LIBROS WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["doc_pdf"]) && ($libro["doc_pdf"] != "documento.pdf")) {
            if (file_exists("../../documentos/" . $libro["doc_pdf"])) {
                unlink("../../documentos/" . $libro["doc_pdf"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM LIBROS WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        // echo "Presionado botón Borrar";
        header("Location:libros_Add.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM LIBROS");
$sentenciaSQL->execute();
$listaLibro = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-4">

    <div class="card border-dark mb-3">
        <div class="card-header">
            Datos del Libro
        </div>
        <div class="card-body ">
            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" require readonly value="<?php echo $txtID ?>" class="form-control" id="txtID" name="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre del Libro:</label>
                    <input type="text" require value="<?php echo $txtNombre ?>" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre del libro">
                </div>

                <div class="form-group">

                    <label for="ImgLibro">Imagen del libro:</label>
                    
                    <?php if($ImgLibro!=""){
                     ?>
                       <br>
                       <img class="img-thumbnail rounded" src="../../img/<?php echo $ImgLibro; ?>" width="50px" alt="">
                    <?php } ?>

                    <input type="file" require class="form-control" id="ImgLibro" name="ImgLibro" accept="image/*">
                </div>

                <div class="form-group">

                    <label for="DocLibro">Documento de libro:</label>
                    

                    <?php if($DocLibro!=""){ ?>
                       <br>
                        <a target="_blank" class="page-link" href="../../documentos/<?php echo $DocLibro ?>"><img src="../../img/pdf_icono.png" width="20px" alt=""><?php echo $DocLibro ?></a>
                    <?php } ?>


                    <input type="file" require class="form-control" id="DocLibro" name="DocLibro" accept="application/pdf">
                </div>

                <br>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo($accion=="Seleccionar")?"disabled":""; ?>  value="Agregar" class="btn btn-success">Agregar</button>&nbsp;
                    <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>&nbsp;
                    <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>

        </div>

    </div>


</div>

<div class="col-md-8">
    <table class="table table-striped">
        <thead class="table-dark ">
            <tr class="text-center">
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Pdf</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLibro as $libro) { ?>
                <tr class="text-center">
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['nombre']; ?></td>
                    <td> <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" width="110px" alt=""> </td>
                    <td> <a target="_blank" class="page-link" href="../../documentos/<?php echo $libro['doc_pdf']; ?>"><img src="../../img/pdf_icono.png" width="20px" alt=""><?php echo $libro['doc_pdf']; ?></a></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </form>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?>