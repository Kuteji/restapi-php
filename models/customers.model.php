<?php

require_once 'connection.php';


class CustomersModel {

    /*=============================
        Mostrar todos los registros
    ================================*/ 

    static public function index($tabla)
    {
        
        $stmt = Connection::connect()->prepare("SELECT * FROM $tabla");

        $stmt -> execute();

        return $stmt -> fetchAll();

        $stmt -> close();

        $stmt = null;
    }

     /*=============================
            Crear Registro
    ================================*/ 

    static public function create($table, $data)
    {

        $stmt = Connection::connect()->prepare(
                "INSERT INTO $table(nombre, apellido, email, id_cliente, llave_secreta, created_at, updated_at)
                VALUES (:nombre, :apellido, :email, :id_cliente, :llave_secreta, :created_at, :updated_at)"
         );

         $stmt -> bindParam(":nombre", $data["nombre"], PDO::PARAM_STR);
         $stmt -> bindParam(":apellido", $data["apellido"], PDO::PARAM_STR);
         $stmt -> bindParam(":email", $data["email"], PDO::PARAM_STR);
         $stmt -> bindParam(":id_cliente", $data["id_cliente"], PDO::PARAM_STR);
         $stmt -> bindParam(":llave_secreta", $data["llave_secreta"], PDO::PARAM_STR);
         $stmt -> bindParam(":created_at", $data["created_at"], PDO::PARAM_STR);
         $stmt -> bindParam(":updated_at", $data["updated_at"], PDO::PARAM_STR);


         if ( $stmt -> execute() ) return "ok";
         else print_r(Connection::connect()->errorInfo());

         $stmt-> close();
         $stmt = null;
    }



}