<?php

namespace Empresa;
use Faker;
use PDO;
use PDOException;

class Trabajadores extends Conexion{
    private $nombre,$apellidos,$telefono,$departamento,$empresa_id;
    public function __construct()
    {
        parent::__construct();
    }

    //-----------------CRUD-----------------
    public function create(){
        $q="insert into trabajadores(nombre,apellidos,telefono,departamento,empresa_id) values (:n,:a,:t,:d,:ei)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':t'=>$this->telefono,
                ':d'=>$this->departamento,
                ':ei'=>$this->empresa_id
            ]);
        }catch(PDOException $ex){
            die("Error al crear el trabajador.".$ex->getMessage());
        }
        parent::$conexion=null;
    }

    public function read($id){
        $q="select * from trabajadores where id=:id";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("error al editar el trabajador: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function update($id){
        $q="update trabajadores set nombre=:n,apellidos=:a,telefono=:t,departamento=:d,empresa_id=:ei where id=:id";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':t'=>$this->telefono,
                ':d'=>$this->departamento,
                ':ei'=>$this->empresa_id,
                ':id'=>$id
            ]);

        }catch(PDOException $ex){
            die("Error al actualizar el trabajador.".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    
    public function delete($id){
        $q="delete from trabajadores where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al borrar el trabajador: ".$ex->getMessage());
        }
        parent::$conexion=null;
    }

    //---------------------------OTROS METODOS-----------------------
    public function generarTrabajadores($cant){
        if(!$this->hayTrabajadores()){
            $faker=Faker\Factory::create('es_ES');
            $idEmpresas=(new Empresas)->getEmpresasId();
            for($i=0;$i<$cant; $i++){
                $nombre=ucfirst($faker->name());
                $apellidos = $faker->lastName() . " " . $faker->lastName();
                $telefono=$faker->numberBetween(624000000,699000000);
                $departamento=$faker->randomElement(['Informatica','Diseño','Marketing','Recursos Humanos']);
                $empresa_id=$faker->randomElement($idEmpresas);
                (new Trabajadores)->setNombre($nombre)
                ->setApellidos($apellidos)
                ->setTelefono($telefono)
                ->setDepartamento($departamento)
                ->setEmpresa_id($empresa_id)
                ->create();
            }
        }
    }

    public function hayTrabajadores(){
        $q="select * from trabajadores";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al comprobar si hay trabajadores: ".$ex->getMessage());
        }
        $totalTrabajadores = $stmt->rowCount();
        parent::$conexion = null;
        return ($totalTrabajadores > 0);
    }

    public function readAll(){
        $q="select * from trabajadores";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar todas los trabajadores: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt;
    }

    public function filtroTrabajadores($c, $v)
    {
        $q = "select * from trabajadores where $c=:valor order by nombre";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':valor' => $v
            ]);
        } catch (PDOException $ex) {
            die("Error al filtrar trabajadores: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }
    
    public function detalleTrabajador($id)
    {
        $q = "select trabajadores.*, logo, empresas.nombre as nombreEmpresa from trabajadores, empresas where empresas.id=trabajadores.empresa_id AND trabajadores.id=:id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':id' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al recuperar los detalles del trabajador: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
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
     * Get the value of apellidos
     */ 
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */ 
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of telefono
     */ 
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */ 
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of departamento
     */ 
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set the value of departamento
     *
     * @return  self
     */ 
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get the value of empresa_id
     */ 
    public function getEmpresa_id()
    {
        return $this->empresa_id;
    }

    /**
     * Set the value of empresa_id
     *
     * @return  self
     */ 
    public function setEmpresa_id($empresa_id)
    {
        $this->empresa_id = $empresa_id;

        return $this;
    }
}