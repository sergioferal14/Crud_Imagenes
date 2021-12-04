<?php

namespace Empresa;
use PDOException;
use PDO;
use Faker;
class Empresas extends Conexion{
    private $id,$nombre,$facturacion,$logo;

    public function __construct()
    {
        parent::__construct();
    }

    //-----------------------CRUD------------------
    public function create(){
        $q="insert into empresas(nombre,facturacion,logo) values (:n,:f,:l)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':f'=>$this->facturacion,
                ':l'=>$this->logo
            ]);
        }catch(PDOException $ex){
            die("Error al crear la empresa.".$ex->getMessage());
        }
        parent::$conexion=null;
    }

    public function read($id){
        $q="select * from empresas where id=:id";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("error al editar marca: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function update($id){
        $q="update empresas set nombre=:n,facturacion=:f,logo=:l where id=:id";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':f'=>$this->facturacion,
                ':l'=>$this->logo,
                ':id'=>$id
            ]);

        }catch(PDOException $ex){
            die("Error al actualizar la empresa.");
        }
        parent::$conexion=null;
    }
    
    public function delete($id){
        $q="delete from empresas where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al borrar la empresa: ".$ex->getMessage());
        }
        parent::$conexion=null;
    }

    //---------------------------OTROS METODOS-----------------------
    public function generarEmpresas($cant){
        if(!$this->hayEmpresas()){
            $faker=Faker\Factory::create('es_ES');
            $URL_APP="http://localhost/php2/PDO/practica2/public/";
            for($i=0;$i<$cant; $i++){
                $nombre=ucfirst($faker->word());
                $facturacion=$faker->numberBetween(1000,9999); 
                (new Empresas)->setNombre($nombre)
                ->setFacturacion($facturacion)
                ->setLogo($URL_APP."img/empresas/default.png")
                ->create();
            }
        }
    }

    public function hayEmpresas(){
        $q="select * from empresas";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al comprobar si hay empresas: ".$ex->getMessage());
        }
        $totalEmpresas = $stmt->rowCount();
        parent::$conexion = null;
        return ($totalEmpresas > 0);
    }

    public function readAll(){
        $q="select * from empresas";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar todas las empresas: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt;
    }
    
    public function getEmpresasId(){
        $q="select id from empresas";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error al devolver ids empresas: ".$ex->getMessage());
        }
        parent::$conexion=null;
        $ids=[];
        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
            $ids[]=$fila->id;
        }
        return $ids;

    }

    public function misEmpresas(){
        $q="select id, nombre from empresas order by nombre";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error al devolver nombres e ids de las empresas: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of facturacion
     */ 
    public function getFacturacion()
    {
        return $this->facturacion;
    }

    /**
     * Set the value of facturacion
     *
     * @return  self
     */ 
    public function setFacturacion($facturacion)
    {
        $this->facturacion = $facturacion;

        return $this;
    }

    /**
     * Get the value of logo
     */ 
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set the value of logo
     *
     * @return  self
     */ 
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }
}