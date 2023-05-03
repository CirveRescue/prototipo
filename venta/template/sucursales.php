<?php include ("template/cabecera.php"); ?>
<?php 
include ("admin/cofig/bd.php");
         $sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
         $sentenciaSQL->execute();
         $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
         ?>
         <?php foreach($listaLibros as $libro) { ?>
            <body background="https://fondosmil.com/fondo/1137.jpg">
            <div class="col-md-3">
<div class="card">
<img class="card-img-top" src="./img/<?php echo $libro ['imagen'];?>" width="200" height="200" alt="">
<div class="card-body">
    <h4 class="card-title"> <?php echo $libro ['nombre']; ?></h4>
    <a name="" id="" class="btn btn-primary" href="#" role="button">Ver mas</a>
</div>
</div>
</div>

<?php } ?>
