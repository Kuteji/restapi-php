<?php

class CoursesController{

    // listar cursos
    public function index()
    {
        $courses = CoursesModel::index("cursos");

        $json = array(
            "status" => 200,
            "total_register" => count($courses),
            "data" => $courses
        );

        echo json_encode($json, true);
        return;
    }

    // Crear un curso
    public function create()
    {
        $json = array(
            "message" => "Curso Almacenado con Exito"
        );

        echo json_encode($json, true);
        return;
    }

    // mostrar un curso
    public function show($id)
    {
        $json = array(
            "message" => "mostrando el curso con el id: ".$id
        );

        echo json_encode($json, true);
        return;
    }

    // editar un curso
    public function update($id)
    {
        $json = array(
            "detalle" => "El curso con el id: ".$id." ha sido actualizado"
        );

        echo json_encode($json, true);
        return;
    }

     // borrar un curso
     public function delete($id)
     {
         $json = array(
             "detalle" => "El curso con el id: ".$id." ha sido borrado exitosamente"
         );
 
         echo json_encode($json, true);
         return;
     }
 

}