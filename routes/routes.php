<?php

/* cuando ponemos el .htaccess podemos usarlo URI => ruta dominio
el $_SERVER['REQUEST_URI'] equivale a la ruta que ponemos por get*/

$arrayRoutes = explode("/", $_SERVER['REQUEST_URI']);
// array filter quita los indices si estan vacios
if (count(array_filter($arrayRoutes)) == 0) {

    // cuando no se hace ninguna peticion a la api
    $json = array(
        "detalle" => "no encontrado"
    );
    //convertimos el array en json
    echo json_encode($json, true);
    return;

} else {

   if (count(array_filter($arrayRoutes)) == 1) {
      // cuando se hacen peticiones a regitro
        if (array_filter($arrayRoutes)[1] == "registro") {
            $json = array(
                "detalle" => "Estoy en registro"
            );

            echo json_encode($json, true);
            return;
        }

            //cuando se hacen peticiones a cursos
        if (array_filter($arrayRoutes)[1] == "cursos") {
            
            $json = array(
                "detalle" => "Estoy en cursos"
            );

            echo json_encode($json, true);
            return;
        }

   } else {
        
        // cuando se hacen peticiones a un solo curso
        if (array_filter($arrayRoutes)[1] == "cursos" && is_numeric(array_filter($arrayRoutes)[2])) {
            $json = array(
                "detalle" => "Estoy en un curso"
            );

            echo json_encode($json, true);
            return;
        }

   }

}

