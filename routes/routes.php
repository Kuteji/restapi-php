<?php

/* cuando ponemos el .htaccess podemos usarlo URI => ruta dominio
el $_SERVER['REQUEST_URI'] equivale a la ruta que ponemos por get*/

$arrayRoutes = explode("/", $_SERVER['REQUEST_URI']);
// array filter quita los indices si estan vacios
if (count(array_filter($arrayRoutes)) == 0) {

    // cuando no se hace ninguna peticion a la api
    $json = array(
        "message" => "no encontrado"
    );
    //convertimos el array en json
    echo json_encode($json, true);
    return;

} else {

    // echo '<pre>';print_r($arrayRoutes);echo'</pre>';

   if (count(array_filter($arrayRoutes)) == 1) {
      // cuando se hacen peticiones a regitro
        if (array_filter($arrayRoutes)[1] == "registro") {

            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
               
                // capturar datos

                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "apellido" => $_POST["apellido"],
                    "email" => $_POST["email"]
                );


                $register = new CustomerController();
                $register -> create($datos);
            } else {

                // no exste el metodo en la ruta
                $json = array(
                    "message" => "no encontrado"
                );
                //convertimos el array en json
                echo json_encode($json, true);
                return;
            }

            //cuando se hacen peticiones a cursos
        } else if (array_filter($arrayRoutes)[1] == "cursos") {
            
            if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                
                $courses = new CoursesController();
                $courses -> index();

            } else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {


                /**===============================
                 *      Obtener los datos
                 ================================*/

                 $datos = array(
                    "titulo" => $_POST["titulo"],
                    "descripcion" => $_POST["descripcion"],
                    "instructor" => $_POST["instructor"],
                    "imagen" => $_POST["imagen"],
                    "precio" => $_POST["precio"]
                );

                // echo '<pre>';  print_r($datos);  '</pre>';
                
                $createCourse = new CoursesController();
                $createCourse -> create($datos);
            } else {

                  // no exste el metodo en la ruta
                  $json = array(
                    "message" => "no encontrado"
                    );
                    //convertimos el array en json
                    echo json_encode($json, true);
                    return;

            }
           
        } else {

            // cuando la ruta no existe
            $json = array(
                "message" => "no encontrado"
            );
            //convertimos el array en json
            echo json_encode($json, true);
            return;
        }

    } else {
        
        // cuando se hacen peticiones a un solo curso
        if (array_filter($arrayRoutes)[1] == "cursos" && is_numeric(array_filter($arrayRoutes)[2])) {

             // peticiones GET
             if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
                
                $showCourse = new CoursesController();
                $showCourse -> show(array_filter($arrayRoutes)[2]);
            }
           
            // peticiones PUT
           else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {
                
                $updateCourse = new CoursesController();
                $updateCourse -> update(array_filter($arrayRoutes)[2]);
            }

            // peticiones DELETE
            else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
                
                $deleteCourse = new CoursesController();
                $deleteCourse -> delete(array_filter($arrayRoutes)[2]);
            } else {

                  // no exste el metodo en la ruta
                  $json = array(
                        "message" => "no encontrado"
                    );
                    //convertimos el array en json
                    echo json_encode($json, true);
                    return;
            }

        } else {

              // no exste el metodo en la ruta
              $json = array(
                "message" => "no encontrado"
                );
                //convertimos el array en json
                echo json_encode($json, true);
                return;

        }

   }

}

