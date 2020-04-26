<?php

class CustomerController{

    // Crear un registro
    public function create($datos)
    {
        
        /*===============
         Validar Nombre
         ===============*/

        if (isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos['nombre'])) {

            $json = array(
                "status"=> 404,
                "message"=> "Error en el campo nombre, no se permiten numeros o simbolos"
            );
    
            echo json_encode($json, true);
            return;
        }

        /*================
         Validar Apellido
         =================*/

         if (isset($datos['apellido']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos['apellido'])) {

            $json = array(
                "status"=> 404,
                "message"=> "Error en el campo apellido, no se permiten numeros o simbolos"
            );
    
            echo json_encode($json, true);
            return;
        }

         /*================
         Validar email
         =================*/

         if (isset($datos['email']) && !preg_match(
             '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',
              $datos['email']))
            {

                $json = array(
                    "status"=> 404,
                    "message"=> "Error en el campo email, Coloca un email valido"
                );
        
                echo json_encode($json, true);
                return;
            }

             /*=====================================
                Validar que el email no este repetido
                =====================================*/

                $customers = CustomersModel::index("clientes");
                // echo '<pre>';print_r($customers); echo '</pre>';

                        
                foreach( $customers as $customer ){

                    if ($customer["email"] == $datos['email']) {

                        $json = array(
                            "status"=> 404,
                            "message"=> "El email ya existe en la base de datos"
                        );
                
                        echo json_encode($json, true);
                        return;
                        
                    }
                }


            


            $json = array(
                "status"=> 200,
                "message"=> "Registro almacenado exitosamente"
            );
    
            echo json_encode($json, true);
            return;

        
    }
}
