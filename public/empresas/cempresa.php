<?php
    session_start();
    require dirname(__DIR__, 2)."/vendor/autoload.php";
    use Empresa\{Empresas,Imagen};
    
    $URL_APP="http://localhost/php2/PDO/practica2/public/";
    $error=false;

    function comprobarCampos($n, $f){
        global $error;
        if(strlen($f)==0){
            $_SESSION[$n]="Error, rellene el campo $n!";
            $error=true;
        }
        
    }
    if(isset($_POST['enviar'])){
        $n=ucfirst(trim($_POST['nombre']));
        $f=trim($_POST['facturacion']);

        comprobarCampos("nombre", $n);
        comprobarCampos("facturacion", $f);

        $empresa= new Empresas;

        if(is_uploaded_file($_FILES['logo']['tmp_name'])){
            if((new Imagen)->isImagen($_FILES['logo']['type'])){
                $imagen=new Imagen;
                $imagen->setAppUrl("http://localhost/php2/PDO/practica2/public/");
                $imagen->setDirStorage(dirname(__DIR__)."/img/empresas/");
                $imagen->setNombreF($_FILES['logo']['name']);
                if($imagen->guardarImagen($_FILES['logo']['tmp_name'])){
                    $empresa->setLogo($imagen->getUrlImagen('empresas'));
                }else{
                    $error=true;
                    $_SESSION['err_logo']="Error al guardar el logo!!";
                }

            }else{
                $error=true;
                $_SESSION['err_logo']="El formato del archivo seleccionado no es valido!";
            }

        }else{
            $imagen=new Imagen;
            $imagen->setAppUrl("http://localhost/php2/PDO/practica2/public/");
            $empresa->setLogo($imagen->guardarDefault('empresas'));
            
            
        }

        if(!$error){
            $empresa->setNombre($n)->setFacturacion($f)->create();
            $_SESSION['mensaje']="Empresa creada con exito!";
            header("Location:index.php"); 
        }else{
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

    <title>Crear Empresa</title>
</head>

<body style="background-color:#1ABC9C">
    <h4 class="text-center">Nueva Empresa</h4>
    <div class="container mt-2">
        <div class="my-2 p-4 mx-auto bg-secondary text-white" style=" width:40rem">
            <form name="s" action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST' enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="n" class="form-label">Nombre Empresa</label>
                    <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre">
                    <?php
                        if(isset($_SESSION['nombre'])){
                            echo "<p class='text-danger mt-1'>{$_SESSION['nombre']}</p>";
                            unset($_SESSION['nombre']);
                        }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="f" class="form-label">Facturacion/dia</label>
                    <input type="text" class="form-control" id="f" placeholder="0.00" name="facturacion">
                    <?php
                        if(isset($_SESSION['facturacion'])){
                            echo "<p class='text-danger mt-1'>{$_SESSION['facturacion']}</p>";
                            unset($_SESSION['facturacion']);
                        }
                    ?>    
                </div>

                <div class="mb-3">
                    <label for="i" class="form-label">Logo Empresa</label>
                    <input class="form-control" type="file" id="i" name="logo">  
                    <?php
                        if(isset($_SESSION['err_logo'])){
                            echo "<p class='text-danger mt-1'>{$_SESSION['err_logo']}</p>";
                            unset($_SESSION['err_logo']);
                        }
                    ?>
                </div>
                <div class="mb-3">
                    <button type="submit" name="enviar" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                    <button type="reset" class="btn btn-warning"><i class="fas fa-brush"></i> Limpiar</button>
                    <a href="index.php" class="btn btn-primary"><i class="fas fa-home"></i> Inicio</a>
                </div>
            </form>
        </div>

    </div>
</body>

</html>
<?php } ?>