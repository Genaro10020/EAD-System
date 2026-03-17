<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');

$usuario = $arreglo['usuario'];
$contrasena = $arreglo['contrasena'];
 
$resultado = "";
        //Acceso a Coordinadores y Admin del sistema
        $consulta = "SELECT * FROM usuarios WHERE nomina = '$usuario' AND contrasena = '$contrasena' AND (tipo_usuario = 'Coordinador' || tipo_usuario = 'Admin')";
        $query=$conexion->query($consulta);
                if(mysqli_num_rows($query)>0){
                        while ($dato=mysqli_fetch_array($query)) {
                                $_SESSION['nombre']=$dato['nombre'];
                                $_SESSION['nomina']=$dato['nomina'];
                                $_SESSION['planta']=$dato['planta'];
                                $_SESSION['area']=$dato['area'];
                                $_SESSION['tipo_usuario']=$dato['tipo_usuario'];
                                $_SESSION['tipo_acceso']=$dato['tipo_acceso'];//acceso admin default
                                $resultado = "Autorizado";
                            }
                }else{//Acceso evaluadores.
                    $consultarEvaluador = "SELECT * FROM evaluadores WHERE nomina='$usuario' AND contrasena='$contrasena'";
                    $query2=$conexion->query($consultarEvaluador);
                    if($query2){
                            if (mysqli_num_rows($query2) > 0) {
                                while($row = mysqli_fetch_array($query2)){
                                    $_SESSION['id']=$row['id'];
                                    $_SESSION['nombre']=$row['nombre'];
                                    $_SESSION['nomina']=$row['nomina'];
                                    $_SESSION['tipo_acceso']="Evaluador";
                                    $resultado = "Autorizado";
                                }
                            }else{//Entrar como consultor.

                                $final = [];
                                $selectIntegrante = "";
                                $consultares = "Consultor";
                                $consultaConsultores = "SELECT * FROM equipos_ead WHERE tipo_ead IN ('EAD Consultor')";//Busco equipos consultores
                                $queryConsultores = $conexion->query($consultaConsultores);
                                if($consultares == "Consultor"){
                                    include("conexionBDSugerencias.php");
                                    while($datoConsultores = mysqli_fetch_array($queryConsultores)){
                                          $resultado=$final = json_decode($datoConsultores['integrantes'], true);//encuentro el equipo al que pertenece al equipo consultor 
                                          foreach($final as $idIntegrante){//busco a cada integrante del equipo consultor para verificar su acceso al sistema
                                              $selectIntegrante = "SELECT * FROM usuarios_colocaboradores_sugerencias WHERE id='$idIntegrante' AND numero_nomina='$usuario' AND password='$contrasena' AND status != 'Baja'";
                                              $queryIntegrante = $conexion->query($selectIntegrante);
                                                if($queryIntegrante){
                                                    if (mysqli_num_rows($queryIntegrante) > 0) {
                                                        $row = mysqli_fetch_assoc($queryIntegrante);
                                                            if($row){
                                                                $_SESSION['id'] = $row['id'];
                                                                $_SESSION['nombre'] = $row['colaborador'];
                                                                $_SESSION['nomina'] = $row['numero_nomina'];
                                                                $_SESSION['tipo_acceso'] = "Consultor";
                                                                $_SESSION['id_equipo'] = $row['equipo_ead_grafica'];
                                                                $resultado = "Autorizado";
                                                               break 2; // rompe foreach y while de consultores
                                                            }
                                                    }else{
                                                        $resultado = "Verifique CONSULTOR";
                                                    }
                                                }else{
                                                    $resultado = "Error ".$conexion->error;
                                                }
                                          }
                                    }
                                }else{//Acceso colaboradores ScoreCard

                                        $consultarEvaluador = "SELECT * FROM usuarios_colocaboradores_sugerencias WHERE numero_nomina='$usuario' AND password='$contrasena' AND id_grafica_acceso!='' AND status != 'Baja'";
                                        $query3=$conexion->query($consultarEvaluador);
                                        if($query3){
                                                if (mysqli_num_rows($query3) > 0) {
                                                    while($row = mysqli_fetch_array($query3)){
                                                        $_SESSION['id']=$row['id'];
                                                        $_SESSION['nombre']=$row['colaborador'];
                                                        $_SESSION['nomina']=$row['numero_nomina'];
                                                        $_SESSION['tipo_acceso']="Colaborador";
                                                        $_SESSION['id_equipo']=$row['equipo_ead_grafica'];
                                                        $_SESSION['id_tabla']=$row['id_grafica_acceso'];
                                                        $resultado = "Autorizado";
                                                    }
                                                }else{
                                                    $resultado = "Verifique";
                                                }   
                                        }else{
                                            $resultado = "Error ".$conexion->error;
                                        }
                                }
                             
                            }   
                    }else{
                        $resultado = "Error ".$conexion->error;
                    }
                }
echo json_encode($resultado);
?>