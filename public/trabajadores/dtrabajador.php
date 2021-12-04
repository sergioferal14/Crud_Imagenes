<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}
$id = $_GET['id'];
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Empresa\Trabajadores;

$trabajador = (new Trabajadores)->detalleTrabajador($id);
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

    <title>Detalle Trabajador</title>





</head>

<body style="background-color:#1ABC9C">
    <h5 class="text-center mt-2">Detalle Trabajador (id='<?php echo $id ?>')</h5>
    <div class="container mt-2">
        <div class="my-2 p-4 mx-auto" style="background-color:#c0ca33; width:40rem">
            <div class="mt-2">
                <h4 class="text-center"><?php echo $trabajador->nombre; ?></h4>
            </div>
            <div class="d-flex flex-row mt-4 justify-content-between">
                <table>
                    <tr>
                        <td>
                            <div class="text-center"><b>Empresa:&nbsp;</b>
                        </td>
                        <td>
                            <a href="ftrabajadores.php?campo=empresa_id&valor=<?php echo $trabajador->empresa_id; ?>" style="text-decoration:none">

                                <img src="<?php echo $trabajador->logo; ?>" width='50rem' height='50rem' class='img-thumbnail d-block' />
                            </a>
                        </td>
                        <td>
                        <a  class=" p-1 rounded-pill bg-black text-light" href="ftrabajadores.php?campo=empresa_id&valor=<?php echo $trabajador->empresa_id; ?>" style="text-decoration:none">
                            <?php echo $trabajador->nombreEmpresa; ?></a>
                        </td>
                        </tr>
                </table>    
                </div>
                
            
            <div class="mt-2">
                <b>Nº Telefono:&nbsp;</b>
                <?php echo $trabajador->telefono; ?>
            </div>
            <div class="mt-2">
                <b>Nombre Completo:&nbsp;</b>
                <?php echo $trabajador->nombre; ?>,<?php echo $trabajador->apellidos; ?>
            </div>
            <div class="mt-2"><b>Departamento:&nbsp;</b>

                <a href="ftrabajadores.php?campo=departamento&valor=<?php echo $trabajador->departamento; ?>" class="p-1 rounded-pill bg-black text-light" style="text-decoration:none">
                    <?php echo $trabajador->departamento; ?></a>
            </div>
            <div class='mt-4'>
                <a href="index.php" class='btn btn-primary'><i class='fas fa-backward'></i> Volver</a>
            </div>
        </div>

    </div>
</body>

</html>