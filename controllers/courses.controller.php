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
                    $course = CoursesModel::index("cursos");

                    if (!empty($course))
                    {
                        $json = array(
                            "status" => 200,
                            "total_register" => count($course),
                            "data" => $course
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

                         $course = CoursesModel::index('cursos');

                         foreach ($course as $course ){
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
                         Mostrar  curso
                     ==============================*/
                    $course = CoursesModel::show("cursos", $id);

                    if (!empty($course))
                    {
                        $json = array(
                            "status" => 200,
                            "data" => $course
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




    /*=======================
         editar un curso
    ==========================*/
    public function update($id, $datos)
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
                                if (isset($valueDato) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $valueDato) ) {

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
                            *       Validar ID Creador
                            ==================================*/
                            $course = CoursesModel::show("cursos", $id);

                            foreach ($course as $key => $valueCourse)
                             {

                                if ($valueCourse->id_creador == $customer['id'])
                                {

                                            /**=================================
                                             *      Llevar  Datos al modelo
                                             ==================================*/
                                
                                            $data = array(
                                                "id"=>$id,
                                                "titulo"=>$datos["titulo"],
                                                "descripcion"=>$datos["descripcion"],
                                                "instructor"=>$datos["instructor"],
                                                "imagen"=>$datos["imagen"],
                                                "precio"=>$datos["precio"],
                                                "updated_at"=>date('Y-m-d h:i:s')
                                                        );

                                            $create = CoursesModel::update("cursos", $data);   
                                            
                                            
                                                /*=====================================
                                                    Respuesta de el modelo
                                                =====================================*/

                                            if ($create == "ok") {

                                                $json = array(
                                                    "status"=> 200,
                                                    "message"=> "El curso se actualizo correctamente",
                                                );
                                        
                                                echo json_encode($json, true);
                                                return;

                                            }
                                    
                                }
                                else
                                {
                                    $json = array(
                                        "status"=> 404,
                                        "message"=> "no autorizado : ".$errorDato
                                    );
                                    echo json_encode($json, true);
                                    return;
                                }

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