<?php
include("conexionGhoner.php");

    function consultarForos(){
        global $conexion;
        $resultado = [];
        $estado = false;
        $consulta = "SELECT * FROM foros";
        $query = $conexion->query($consulta);
        if ($query->num_rows > 0) {
            while ($fila = $query->fetch_assoc()) {
                 $resultado [] = $fila;
            }
            $estado=true;
        }

        return array($estado,$resultado);
    }

    function consultarDetallesForo($id){
        global $conexion;
        $resultado = array();
        $estado = false;
       // Consulta preparada para evitar inyección SQL
$consulta = "SELECT foros.*, equipos_ead.*, ead_foro.*, calificacion.*, evaluadores.*
FROM foros
INNER JOIN equipos_ead ON foros.id = equipos_ead.id_foro
LEFT JOIN ead_foro ON foros.id = ead_foro.id_foro
LEFT JOIN calificacion ON ead_foro.id = calificacion.id_ead_foro
LEFT JOIN evaluadores ON calificacion.id_evaluador = evaluadores.id
WHERE foros.id = ?";

// Preparar la consulta
if ($stmt = $conexion->prepare($consulta)) {
// Vincular parámetro
$stmt->bind_param("s", $id);

// Ejecutar la consulta
if ($stmt->execute()) {
// Obtener resultados
$resultado = array();
$result = $stmt->get_result();
while ($fila = $result->fetch_assoc()) {
    $resultado[] = $fila;
}
$estado = true;
} else {
// Manejar error de ejecución de la consulta
 
$estado = $conexion->error;
// Log o manejo del error
}

// Cerrar declaración
$stmt->close();
} else {
// Manejar error de preparación de la consulta
;
$estado = $conexion->error;
// Log o manejo del error
}

        return array($estado,$resultado);
    }

    function consultarEADxPlantaxArea($planta,$area){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM equipos_ead WHERE planta LIKE '%$planta%' AND area LIKE '%$area%' ORDER BY id DESC";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado,$estado);
    }

    function guardarForo($nombre_foro,$planta,$area,$fecha,$ids_ead,$ids_evaluadores){
        global $conexion;
        $estado = [];
        $query = "INSERT INTO foros (nombre_foro,planta,area,foro,fecha) VALUES (?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $foro = "Áreas";
        $stmt->bind_param("sssss", $nombre_foro,$planta,$area,$foro,$fecha);
        if($stmt->execute()){//guardo el foro
            $estado[0] = true;
            $ultimo_id = $conexion->insert_id;// tomo el id nuevo creado del foro.
            //COMBINANDO LOS FOROS Y EQUIPOS
            foreach ($ids_ead as $id_ead) {
                $query2="INSERT INTO ead_foro (id_foro, id_equipos_ead) VALUES (?,?)";
                $stmt = $conexion->prepare($query2);
                $stmt -> bind_param('ii',$ultimo_id,$id_ead); //insertando el id del foro en cada equipo
                if($stmt->execute()){
                    $estado[1] = true;
                    $ultimo_id_ead_foros=$conexion->insert_id; //tomo el id de ead_foro
                        //INSERTANDO EVALUADORES EN CALIFICACIONES
                        foreach ($ids_evaluadores as $id_eval) {
                            $query3="INSERT  INTO calificacion (id_ead_foro, id_evaluador) VALUES (?,?)";
                            $stmt = $conexion->prepare($query3);
                            $stmt -> bind_param('ii',$ultimo_id_ead_foros,$id_eval); //insertando el id del foro en cada equipo
                            if($stmt ->execute()){
                                $estado[2] = true;
                                $conexion->insert_id; //tomo el id de ead_foro
                            }else{
                                $estado[2] = $conexion->error;
                            }
                        }
                }else{
                    $estado[1] = $conexion->error;
                }
            }
        }else{
            $estado[0] =$conexion->error;
        }
        $stmt->close();
        return array($estado,$ids_ead,$ids_evaluadores);
    }

    function actualizarMision($id,$nuevoNombre){
        global $conexion;
        $estado = false;
        $update = "UPDATE misiones SET nombre=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoNombre, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }



    function eliminarMision($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM misiones WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>