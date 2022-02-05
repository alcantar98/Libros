<?php include("php/cabecera.php") ?>

<?php include("administrador/config/bd.php"); 
$sentenciaSQL = $conexion->prepare("SELECT * FROM LIBROS");
$sentenciaSQL->execute();
$listaLibro = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaLibro as $libro){ ?>

<div class="col-md-3">
 
<div class="card">
    <img class="card-img-top" height="270px" width="50px" src="./img/<?php echo $libro['imagen']; ?>" alt="">
    <div class="card-body">
        <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
        <a name="" id="" target="_blank" class="btn btn-primary" href="./documentos/<?php echo $libro['doc_pdf']; ?>" role="button">Ver Libro</a>
    </div>
</div>
<br>
</div>
<?php }?>
<?php include("php/pie.php") ?>