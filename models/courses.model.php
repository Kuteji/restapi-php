<?php

require_once "connection.php";

class CoursesModel{

    /* =============================
         mostrar todos los cursos
    ================================*/     
    static public function index($table)
    {

        $stmt = Connection::connect()->prepare("SELECT * FROM $table");

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS);

        $stmt -> close();

        $stmt = null;

    }

    
    /* =============================
         Creacion de un curso
    ================================*/ 
    static public function create($table, $data)
    {

        $stmt = Connection::connect()->prepare(
            "INSERT INTO $table(titulo, descripcion, instructor, imagen, precio, created_at, updated_at)
            VALUES (:titulo, :descripcion, :instructor, :imagen, :precio, :created_at, :updated_at)"
            );

        
        $stmt -> bindParam(":titulo", $data['titulo'], PDO::PARAM_STR);
        $stmt -> bindParam(":descripcion", $data['descripcion'], PDO::PARAM_STR);
        $stmt -> bindParam(":instructor", $data['instructor'], PDO::PARAM_STR);
        $stmt -> bindParam(":imagen", $data['imagen'], PDO::PARAM_STR);
        $stmt -> bindParam(":precio", $data['precio'], PDO::PARAM_STR);
        $stmt -> bindParam(":id_creador", $data['id_creador'], PDO::PARAM_STR);
        $stmt -> bindParam(":created_at", $data['created_at'], PDO::PARAM_STR);
        $stmt -> bindParam(":updated_at", $data['updated_at'], PDO::PARAM_STR);

      
        if ($stmt -> execute() ) {
            return "ok";
        } else {
            print_r(Connection::connect()->errorInfo());
        }

        $stmt-> close();

        $stmt = null;
        
    }    


     /* =============================
         mostrar un curso
    ================================*/     
    static public function show($table, $id)
    {

        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE id=:id");

        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_CLASS);

        $stmt -> close();

        $stmt = null;
    }    


    
    /* =============================
         Actualizar un curso
    ================================*/ 
    static public function update($table, $data)
    {

        $stmt = Connection::connect()->prepare(
            "UPDATE cursos SET titulo=:titulo,descripcion=:descripcion,instructor=:instructor,
            imagen=:imagen,precio=:precio,updated_at=:updated_at WHERE id = :id"
        );


        $stmt -> bindParam(":id", $data['id'], PDO::PARAM_INT);
        $stmt -> bindParam(":titulo", $data['titulo'], PDO::PARAM_STR);
        $stmt -> bindParam(":descripcion", $data['descripcion'], PDO::PARAM_STR);
        $stmt -> bindParam(":instructor", $data['instructor'], PDO::PARAM_STR);
        $stmt -> bindParam(":imagen", $data['imagen'], PDO::PARAM_STR);
        $stmt -> bindParam(":precio", $data['precio'], PDO::PARAM_STR);
        $stmt -> bindParam(":updated_at", $data['updated_at'], PDO::PARAM_STR);

      
        if ($stmt -> execute() )
        {
            return "ok";

        } else {
            print_r(Connection::connect()->errorInfo());
        }

        $stmt -> close();

        $stmt = null;
        
    }    

}