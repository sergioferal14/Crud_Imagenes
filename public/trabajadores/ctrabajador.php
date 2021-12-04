<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Empresa\{Empresas, Trabajadores};

$empresas = (new Empresas)->misEmpresas();
$departamentos=['Informatica','Diseño','Marketing','Recursos Humanos'];
function hayError($n,$a,$t){
    $error=false;
    if(strlen($n)==0){
        $error=true;
        $_SESSION['error_nombre']="Rellene el campo nombre !!!";
    }
    if(strlen($a)==0){
        $error=true;
        $_SESSION['error_apellidos']="Rellene el campo apellidos!!!";
    }
    if(strlen($t)==0){
        $error=true;
        $_SESSION['error_telefono']="Rellene el campo Telefono!!!";
    }
    if($t>699000000 || $t<624000000){
        $error=true;
        $_SESSION['error_telefono']="El nº telefono introducido no es valido!!!";
    }
    return $error;
    

}

if(isset($_POST['btnCrear'])){
    $nombre=trim(ucwords($_POST['nombre']));
    $apellidos=trim(ucwords($_POST['apellidos']));
    $telefono=trim($_POST['telefono']);
    $departamento=trim($_POST['departamento']);
    $empresa_id=$_POST['empresa_id'];
    if(!hayError($nombre, $apellidos, $telefono)){
        (new Trabajadores)->setNombre($nombre)
        ->setApellidos($apellidos)
        ->setTelefono($telefono)
        ->setDepartamento($departamento)
        ->setEmpresa_id($empresa_id)
        ->create();
        $_SESSION['mensaje']="Trabajador añadido a la plantilla!";
        header("Location:index.php");
        

    }
    else{
        header("Location:{$_SERVER['PHP_SELF']}");
    }

}

else{
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

    <title>Añadir Trabajador</title>





</head>

<body style="background-color:#1ABC9C">
    <h5 class="text-center mt-2">Nuevo Trabajador</h5>
    <div class="container mt-2">
        <div class="my-2 p-4 mx-auto bg-secondary text-white" style=" width:40rem">
            <form name="ctrabajador" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <div class="mb-3">
                    <label for="n" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="t" placeholder="Nombre" name="nombre" >
                    <?php
                        if(isset($_SESSION['error_nombre'])){
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_nombre']}
                            </div>
                            TXT;
                            unset($_SESSION['error_nombre']);
                        }
                    ?>       
                </div>
                <div class="form-group">
                    <label for="a">Apellidos:</label>
                    <input type="text" class="form-control" id="a" placeholder="Apellidos" name="apellidos" >
                    <?php
                    if(isset($_SESSION['error_apellidos'])){
                        echo <<<TEXTO
                        <div class="mt-2 text-danger fw-bold" style="font-size:small">
                        {$_SESSION['error_apellidos']}</div>
                        TEXTO;
                        unset($_SESSION['error_apellidos']);
                    }
                    ?>
                </div>
                <div class="mb-3 mt-3">
                    <label for="s" class="form-label">Nº Telefono:</label>
                    <input type="text" class="form-control" id="s" placeholder="+34 000000000" name="telefono"></input>
                    <?php
                        if(isset($_SESSION['error_telefono'])){
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_telefono']}
                            </div>
                            TXT;
                            unset($_SESSION['error_telefono']);
                        }
                    ?>       
                </div>
                <div class="mb-3">
                        <label for="t">Departamento:</label>
                        <select class="form-select" id="t" name="departamento">
                            <?php
                            foreach ($departamentos as $item) {
                                echo "<option>$item</option>";
                            }
                            ?>
                        </select>
                    </div>
                <div class="mb-3">
                    <label for="a" class="form-label">Empresa:</label>
                    <select class="form-select" name="empresa_id" id="a">
                        <?php
                        foreach ($empresas as $item) {
                            echo "\n<option value='{$item->id}'>{$item->nombre}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <button type='submit' name="btnCrear" class="btn btn-info"><i class="fas fa-save"></i> Crear</button>
                    <button type="reset" class="btn btn-warning"><i class="fas fa-broom"></i> Limpiar</button>
                    <a href="index.php" class="btn btn-primary"><i class="fas fa-home"></i> Inicio</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>
<?php } ?>