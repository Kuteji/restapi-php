<?php

class CoursesController{

    /*=========================
         listar cursos
    ========================*/
    public function index()
    {

         /*=============================
            Validar Datos del Cliente
         ==============================*/

         $customers = CustomersModel::index("clientes");

         if ( isset($_SERVER['PHP_AUTH_USER']) &&  isset($_SERVER['PHP_AUTH_PW']) )
          {

           foreach($customers as $customer )
           {
              
                if (
                    "Basic ".base64_encode($_SERVER['PHP_AUTH_USER']).":".$_SERVER['PHP_AUTH_PW'] == 
                    "Basic ".base64_encode($customer['id_cliente']).":".$customer['llave_secreta']) 
                {

                    /*=============================
                         Mostrar todos los cursos
                     ==============================*/
                    $courses = CoursesModel::index("cursos");

                    if (!empty($courses))
                    {
                        $json = array(
                            "status" => 200,
                            "total_register" => count($courses),
                            "data" => $courses
                        );   
                    } else {

                        $json = array(
                            "status" => 200,
                            "total_register" => 0,
                            "message" => "No hay registros"
                        );   
                        
                    }
            
                    
                } else {
                    $json = array(
                        "status" => 404,
                        "message" => "El token es invalido"
                    );
            
                }

           }
            

         } else {
             
            $json = array(
                "status" => 404,
                "message" => "no autorizado",
            );
    
         }

         echo json_encode($json, true);
         return;

    }




    /* ==========================
        Crear un curso
    ============================*/
    public function create($datos)
    {
        
         /*==================================
            Validar Credenciales del Cliente
         ====================================*/

         $customers = CustomersModel::index("clientes");

         if ( isset($_SERVER['PHP_AUTH_USER']) &&  isset($_SERVER['PHP_AUTH_PW']) )
        {

           foreach($customers as $customer )
           {
              
                if (
                    "Basic ".base64_encode($_SERVER['PHP_AUTH_USER']).":".$_SERVER['PHP_AUTH_PW'] == 
                    "Basic ".base64_encode($customer['id_cliente']).":".$customer['llave_secreta']) 
                {

                        /**=================================
                         *      Validar Datos
                         ==================================*/
                            $errorDato = "";
                            foreach($datos as $dato => $valueDato)
                            {

                                /*==================================================
                                 pendiente validar campos de los datos por separado
                                ====================================================*/ 
                                if (isset($valueDato) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $valueDato)) {

                                    $errorDato .= $dato.' ';
                                    $json = array(
                                        "status"=> 404,
                                        "message"=> "Campos obligatorios : ".$errorDato
                                    );
                            
                                    
                                }
                            }

                            if ($errorDato != "")
                            {
                                echo json_encode($json, true);
                                return;
                            }



                           /**=================================
                         *     Validar que el titulo o la 
                         * descripcion no esten repetidos
                         ==================================*/

                         $courses = CoursesModel::index('cursos');

                         foreach ($courses as $course ){
                             /* cuando el formato de los datos es stdClass
                             en vez de ['llave'] usamos: ->llave */
                            // echo '<pre>';print_r($course->titulo);echo'</pre>';

                            if ($course->titulo == $datos['titulo'])
                            {
                                    $json = array(
                                        "status" => 404,
                                        "message" => "El titulo ya existe en la base de datos"
                                    );

                                    echo json_encode($json, true);
                                    return;
                            }

                            if ($course->descripcion == $datos['descripcion'])
                            {
                                    $json = array(
                                        "status" => 404,
                                        "message" => "La descripcion ya existe en la base de datos"
                                    );

                                    echo json_encode($json, true);
                                    return;
                            }

                         }


                           /**=================================
                         *      Llevar  Datos al modelo
                         ==================================*/



                            
                        $data = array(
                            "titulo"=>$datos["titulo"],
                            "descripcion"=>$datos["descripcion"],
                            "instructor"=>$datos["instructor"],
                            "imagen"=>$datos["imagen"],
                            "precio"=>$datos["precio"],
                            "id_creador"=>$customer["id"],
                            "created_at"=>date('Y-m-d h:i:s'),
                            "updated_at"=>date('Y-m-d h:i:s')
                                    );

                        $create = CoursesModel::create("cursos", $data);   
                        
                        
                            /*=====================================
                                 Respuesta de el modelo
                            =====================================*/

                        if ($create == "ok") {

                            $json = array(
                                "status"=> 200,
                                "message"=> "El curso se creo correctamente",
                            );
                    
                            echo json_encode($json, true);
                            return;

                        }


                } else {
                    $json = array(
                        "status" => 404,
                        "message" => "El token es invalido"
                    );

                    echo json_encode($json, true);
                    return;
            
                }
            } 

        } else {
             
            $json = array(
                "status" => 404,
                "message" => "no autorizado",
            );

            echo json_encode($json, true);
            return;
        }

       

    }
    
    


    /*====================== 
        mostrar un curso
    ========================*/
    public function show($id)
    {
        $json = array(
            "message" => "mostrando el curso con el id: ".$id
        );

        echo json_encode($json, true);
        return;
    }




    /*=======================
         editar un curso
    ==========================*/
    public function update($id)
    {
        $json = array(
            "detalle" => "El curso con el id: ".$id." ha sido actualizado"
        );

        echo json_encode($json, true);
        return;
    }





     /*==========================
         borrar un curso
     ===========================*/
     public function delete($id)
     {
         $json = array(
             "detalle" => "El curso con el id: ".$id." ha sido borrado exitosamente"
         );
 
         echo json_encode($json, true);
         return;
     }
 

}