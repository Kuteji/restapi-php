<?php

class CustomerController{

    // Crear un registro
    public function create()
    {
        $json = array(
            "detalle" => "Registro Almacenado con Exito"
        );

        echo json_encode($json, true);
        return;
    }

}