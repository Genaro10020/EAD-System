<?php
include("conexionGhoner.php");

    function consultarDatosGrafica($grafica,$id_equipo,$anio,$mes){
        global $conexion;
        $resultado = [];
        $correcto = false;
        $seleccion = "SELECT * FROM graficas WHERE id_equipo= ? AND grafica = ? AND anio = ? AND mes = ?";
        $stmt = $conexion->prepare($seleccion);
        $stmt->bind_param("isii",$id_equipo,$grafica,$anio,$mes);
        if($stmt){
                if($stmt->execute()){
                    $correcto = true;
                    $recuperando = $stmt->get_result();
                    while ($datos = $recuperando->fetch_assoc()) {
                        $resultado[] = $datos;   
                    }
                }else{
                    $correcto = $stmt->error;
                }      
        }else{
            $correcto = $conexion->error;
        }
        return array($correcto,$resultado);
    }

    function guardarDatosGrafica($planta,$area,$id_equipo,$nombre_ead,$grafica,$anio,$mes,$dia,$valor){
        global $conexion;
        $answer = "";
        $seleccion = "SELECT * FROM graficas WHERE id_equipo= ? AND grafica = ? AND anio = ? AND mes = ? AND dia = ?";//verifico que no exista el registro
        $stmt = $conexion->prepare($seleccion);
        $stmt->bind_param("isiii",$id_equipo,$grafica,$anio,$mes,$dia);
            if($stmt){
                if($stmt->execute()){
                    $recuperando = $stmt->get_result();
                    if($recuperando->num_rows>0){//si existe el registro Update
                        $guardar = "UPDATE graficas SET valor=? WHERE id_equipo= ? AND grafica = ? AND anio = ? AND mes = ? AND dia = ?";
                        $stmt = $conexion->prepare($guardar);
                        if(!$stmt){return $conexion->error;}
                        $stmt->bind_param("iisiii",$valor,$id_equipo,$grafica,$anio,$mes,$dia);
                        if(!$stmt->execute()){return $stmt->error;}
                        $answer = true;
                    }else{                      //si no existe el registro Inserta
                        $guardar = "INSERT INTO graficas (planta, area, id_equipo, nombre_ead, grafica, anio, mes, dia, valor) VALUES (?,?,?,?,?,?,?,?,?)";
                        $stmt = $conexion->prepare($guardar);
                        if(!$stmt){return $conexion->error;}
                        $stmt->bind_param("ssissiiii",$planta,$area,$id_equipo,$nombre_ead,$grafica,$anio,$mes,$dia,$valor);
                        if(!$stmt->execute()){return $stmt->error;}
                        $answer = true;
                    }
                }else{
                    $answer = $stmt->error;
                }      
            }else{
                $answer = $conexion->error;
            }
        return $answer;
    }

    function actualizarEstatus(){

    }

    function eliminar(){
       
    }
?>