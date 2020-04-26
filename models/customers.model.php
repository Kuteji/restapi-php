<?php

require_once 'connection.php';


class CustomersModel {

    /*=============================
        Mostrar todos los registros
    ================================*/ 

    static public function index($tabla){
        
        $stmt = Connection::connect()->prepare("SELECT * FROM $tabla");

        $stmt -> execute();

        return $stmt -> fetchAll();

        $stmt -> close();

        $stmt = null;
    }
}