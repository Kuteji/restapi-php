<?php

class CoursesController{

    // listar cursos
    public function index()
    {
        $json = array(
            "detalle" => "Mostrando todos los cursos"
        );

        echo json_encode($json, true);
        return;
    }

    // Crear un curso
    public function create()
    {
        $json = array(
            "detalle" => "Curso Almacenado con Exito"
        );

        echo json_encode($json, true);
        return;
    }

    // mostrar un curso
    public function show($id)
    {
        $json = array(
            "detalle" => "mostrando el curso con el id: ".$id
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