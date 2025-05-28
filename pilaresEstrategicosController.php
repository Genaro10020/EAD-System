<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        include("pilaresEstrategicosModel.php");
       
        $accion = "";
        $resultado = "";  
        if(isset($arreglo['accion'])){
            $accion = $arreglo['accion'];
        }
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                    if(isset($_GET['accion']) &&  $_GET['accion']==='Consultar'){
                        //$resultado = "LLegue al controlador SERENA";
                        $resultado = consultandoPilares();
                    }else{
                        $resultado = "No me llegaron la variables:"; 
                    }   
                break;
            case 'POST':
                    if(isset($arreglo['pilarSeleccionado']) && isset($arreglo['objetivoSeleccionado']) && isset($arreglo['id_equipo']) && isset($arreglo['nombre'])){
                        //$resultado = "LLEGASTE AL CONTROADOR!!!";
                        $pilar=$arreglo['pilarSeleccionado'];
                        $objetivo=$arreglo['objetivoSeleccionado'];
                        $id_equipo=$arreglo['id_equipo'];
                        $nombre=$arreglo['nombre'];
                        $resultado = guardandoSeleccionados($pilar, $objetivo, $id_equipo, $nombre);
                    }else{
                        $resultado = "No llegaron las variables para insertar";
                    }
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