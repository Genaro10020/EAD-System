<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("colaboradorModel.php");
        $resultado = "";  
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
             
                break;
            case 'POST':
                   if(isset($arreglo['nombre']) && isset($arreglo['nomina']) && isset($arreglo['planta'])){
                    $nombre = $arreglo['nombre'];
                    $nomina = $arreglo['nomina'];
                    $password = '123456';
                    $planta = $arreglo['planta'];
                    $resultado = insertarColaborador($nombre,$nomina,$password,$planta);
                   }else{
                    $resultado = "Faltan datos";
                   }
                break;
            case 'PUT':
                    if(isset($arreglo['accion']) && $arreglo['accion']=="Asignar Acceso"){
                        if(isset($arreglo['id_criterio']) && isset($arreglo['id_integrante']) && isset($arreglo['id_ead'])){
                            $id_ead = $arreglo['id_ead'];
                            $id_criterio = $arreglo['id_criterio'];
                            $id_integrante = $arreglo['id_integrante'];
                            $resultado = asignarAccesoTabla($id_ead,$id_criterio,$id_integrante);
                        }else{
                            $resultado = "No llegaron las variables en Asignar Acceso";
                        }
                    }else if(isset($arreglo['accion'])&&  $arreglo['accion']=="Desmarcar Acceso"){
                        if(isset($arreglo['id_integrante']) && isset($arreglo['id_ead'])){
                            $id_integrante = $arreglo['id_integrante'];
                            $id_ead = $arreglo['id_ead'];
                            $resultado = desmarcarAccesoTabla($id_integrante, $id_ead);
                        }else{
                            $resultado = "No llegaron las variables para descarmar acceso".$arreglo['id_integrante'].$arreglo['id_ead'];
                        }
                    }else{
                        $resultado = "Acción no renocida";
                    }
                break;
            case 'DELETE':

                break;
        default:
        $resultado = "Método HTTP no permitido";
        //http_response_code(405); // Método no permitido
        break;
        }
        echo json_encode($resultado);
}else{
    header("Location:index.php");
}
?>