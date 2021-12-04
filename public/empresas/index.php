<?php
     session_start();
     require dirname(__DIR__, 2)."/vendor/autoload.php";
     use Empresa\Empresas;

    (new Empresas)->generarEmpresas(100);
    $stmt=(new Empresas)->readAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <title>Inicio Empresas</title>





</head>

<body style="background-color:#1ABC9C">
    <h4 class="text-center mt-2">Gestion Empresas</h4>
   
    <div class="container mt-2 mb-3">
    <?php
                    if(isset($_SESSION['mensaje'])){
                        echo <<<TEXTO
                        <div class="alert alert-primary" role="alert">
                        {$_SESSION['mensaje']}</div>
                        TEXTO;
                        unset($_SESSION['mensaje']);
                    }
                    ?>
        <a href="cempresa.php" class="btn btn-light my-2"><i class="fas fa-plus"></i> Nueva Empresa</a>
        <a href="../trabajadores/" class="btn btn-light"><i class="fas fa-user-tie"></i>Gestionar Trabajadores</a>
    <table class="table table-dark table-striped" id="tabla">
  <thead>
    <tr>
      <th scope="col">Código</th>
      <th scope="col">Nombre</th>
      <th scope="col">Logo</th>
      <th scope="col">Facturacion/dia</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
      <?php
      while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
        
        echo <<<TXT
        <tr>
        <th scope="row">{$fila->id}</th>
        <td>{$fila->nombre}</td>
        <td><img src='{$fila->logo}' width='40rem' height='40rem' class='img-thumbnail'></td>
        <td>{$fila->facturacion}</td>
        <td>
          <form name='a' method='POST' action='bempresa.php'>
          <input type='hidden' name='id' value="{$fila->id}">
          <a href='eempresa.php?id={$fila->id}' class='btn btn-warning'><i class='fas fa-edit'></i></a>
          <button type='submit' class='btn btn-danger'><i class='fas fa-trash'></i></button>
          </form>
        </td>
        </tr>
        TXT;
      }
    ?>
   
  </tbody>
</table>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
      <script>
          $(document).ready(function() {
    $('#tabla').DataTable();
} );
      </script>
      
    </div>
</body>

</html>