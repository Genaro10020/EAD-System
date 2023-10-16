<?php
session_start();
if(isset($_SESSION['nombre'])){
        $arreglo = json_decode(file_get_contents('php://input'), true);
        include("conexionGhoner.php");
        header('Content-Type: application/json');
        
        $resultado = array();
        $accion = $arreglo['accion'];
       
        if($accion == "Consultar"){
                $consulta = "SELECT * FROM scorecard";//NO CAMBIAR ORDEN SI NO LOS TITULOS ENCABEZADOS NO SALDRAN
                $query = $conexion->query($consulta);
                    while ($datos = mysqli_fetch_array($query))
                    {       
                            $orden = $datos['orden'];
                            // Verificar si el código ya existe en el resultado.
                            if (array_key_exists($orden, $resultado)) {
                            // Si el código ya existe, agregar la fila al array correspondiente.
                            $resultado[$orden][] = $datos;
                    
                            } else {
                            // Si el código no existe, crear un nuevo array para ese código y agregar la fila.
                            $resultado[$orden] = array($datos);
                            }
                    }
        }else if($accion=="Insertar"){
                    $plantilla = $arreglo['plantilla'];
                    switch ($plantilla) {
                        case 'Placas':
                                $table = "scorecard_placas";
                            break;
                        case 'Formación':
                                $table = "scorecard_formacion";
                            break;
                        case 'Etiquetado':
                                $table = "scorecard_etiquetado";
                            break;
                        case 'Ensamble':
                                $table = "scorecard_ensamble";
                            break;
                        default:
                            # code...
                            break;
                    }

                    $select = "SELECT * FROM $table";
                    $consulta = $conexion->query($select);
                    // Verifica si la consulta fue exitosa antes de intentar recuperar datos
                    if ($consulta) {
                            $datos = [];
                            while ($row = $consulta->fetch_assoc()) {
                                $datos[] = $row;
                            }
                            
                                $titulo = $arreglo['ugb'];
                                $mes = $arreglo['mes'];
                                $anio = $arreglo['anio'];
                                $codigo = random_int(10000000, 99999999); // Genera un número aleatorio de 8 digitos
                                $mes_anio =$mes." ".$anio; 
                                $fecha_actual=date("Y-m-d H:i:s");

                                $ordenar = 5000000000;
                                $consulta = "SELECT * FROM scorecard ORDER BY orden ASC LIMIT 1";//NO CAMBIAR ORDEN SI NO LOS TITULOS ENCABEZADOS NO SALDRAN
                                $query = $conexion->query($consulta);
                                if($query->num_rows>0){
                                    $fila=mysqli_fetch_assoc($query);
                                    $ordenar= $fila['orden']-1;
                                }else{
                                    $ordenar =5000000000;
                                }
                        
                                $conexion->begin_transaction();           
                                foreach ($datos as $dato) {
                                    $valor_real = $dato['valor_real'];
                                    $pregunta = $dato['pregunta'];
                                    $objetivo1 = $dato['objetivo1'];
                                    $objetivo2 = $dato['objetivo2'];
                                    $objetivo3 = $dato['objetivo3'];
                                    $objetivo4 = $dato['objetivo4'];
                                    $objetivo5 = $dato['objetivo5'];
                                    $objetivo6 = $dato['objetivo6'];
                                    $objetivo7 = $dato['objetivo7'];
                                    $objetivo8 = $dato['objetivo8'];
                                    $objetivo9 = $dato['objetivo9'];
                                    $objetivo10 = $dato['objetivo10'];
                            
                                    $insertar = "INSERT INTO scorecard 
                                        (codigo, valor_real, titulo, pregunta, objetivo1, objetivo2, objetivo3, objetivo4, objetivo5, objetivo6, objetivo7, objetivo8, objetivo9, objetivo10, mes_anio, fecha_creacion, orden) 
                                        VALUES ('$codigo', '$valor_real', '$titulo', '$pregunta', '$objetivo1', '$objetivo2', '$objetivo3', '$objetivo4', '$objetivo5', '$objetivo6', '$objetivo7', '$objetivo8', '$objetivo9', '$objetivo10', '$mes_anio', '$fecha_actual', '$ordenar')";
                                        
                                        $conexion->query($insertar);
                                }

                            if($conexion->commit()){
                                $resultado = ["bien" => true];
                            }else{
                                $conexion->rollback();
                                $resultado = ["bien" => false];
                            }

                          
                    } else {
                        $resultado = ["bien" => false, "error" => $conexion->error];
                    }

           

            
            /*  $titulo = $arreglo['ugb'];
            $mes = $arreglo['mes'];
            $anio = $arreglo['anio'];
            //$plantilla = $arreglo['plantilla'];
            $codigo = random_int(10000000, 99999999); // Genera un número aleatorio de 8 digitos
            $valorReal = [];
            $valorReal = ['Objetivos','10','9','8','7','6','5','4','3','2','1','0','CAL.','POND.','EVAL.','VALOR'];   
            $cantidad = 0;
            $cantidad =count($valorReal);
            $mes_anio =$mes." ".$anio; 
            $fecha_actual=date("Y-m-d H:i:s");
            
            $ordenar = 5000000000;
            $consulta = "SELECT * FROM scorecard ORDER BY orden ASC LIMIT 1";//NO CAMBIAR ORDEN SI NO LOS TITULOS ENCABEZADOS NO SALDRAN
            $query = $conexion->query($consulta);
            if($query->num_rows>0){
                $fila=mysqli_fetch_assoc($query);
                $ordenar= $fila['orden']-1;
            }else{
                $ordenar =5000000000;
            }


             $conexion->begin_transaction();
             $exito = true; // Variable para rastrear el éxito de las inserciones
                    for ($i=0; $i < $cantidad; $i++) { 
                        //Verificar SI existe usuario
                            $concepto=$valorReal[$i];
                            if($i==0){//insertando ids de tabla objetivos
                                $insertar = "INSERT INTO scorecard  (id,codigo,valor_real,titulo,objetivo1,objetivo2,objetivo3,objetivo4,objetivo5,objetivo6,objetivo7,objetivo8,objetivo9,objetivo10,mes_anio,fecha_creacion,orden) VALUES ('','$codigo','Objetivos','$titulo',1,2,3,4,5,6,7,8,9,10,'$mes_anio','$fecha_actual','$ordenar')";
                                $query = $conexion->query($insertar);
                            }else{
                                $insertar = "INSERT INTO scorecard  (id,codigo,valor_real,titulo,mes_anio,fecha_creacion,orden) VALUES ('','$codigo','$concepto','$titulo','$mes_anio','$fecha_actual','$ordenar')";
                                $query = $conexion->query($insertar);
                            }
                            // Verificar si la inserción fue exitosa
                            if (!$query) {
                                $exito = false;
                                break; // Salir del bucle si hay un error en la inserción
                            }
                    }
            if ($exito && $conexion->commit()) {
                $resultado[] = true;
            } else {
                $conexion->rollback(); // Revertir la transacción en caso de error
                $resultado[] = false;
            }*/
            
        }else{
             $resultado[] = false;
        }
                    
        echo json_encode($resultado);
}else{
         header("Location:index.php");
}
?>