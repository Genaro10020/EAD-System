<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
include("conexionGhoner.php");
header('Content-Type: application/json');

$usuario = $arreglo['usuario'];
$contrasena = $arreglo['contrasena'];
 
  
    //Verificar SI existe usuario
   
        $consulta = "SELECT * FROM usuarios WHERE nomina = '$usuario' AND contrasena = '$contrasena'";
        $query=$conexion->query($consulta);
                if(mysqli_num_rows($query)>0){
                        while ($dato=mysqli_fetch_array($query)) {
                                $_SESSION['nombre']=$dato['nombre'];
                                $_SESSION['nomina']=$dato['nomina'];
                                $_SESSION['planta']=$dato['planta'];
                                $_SESSION['area']=$dato['area'];
                                $_SESSION['tipo_usuario']=$dato['tipo_usuario'];
                                $_SESSION['tipo_acceso']=$dato['tipo_acceso'];//acceso admin defaul
                                $resultado = "Autorizado";
                            }
                }else{
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
                            }else{
                                $resultado = "Verifique";
                            }   
                    }else{
                        $resultado = "Error ".$conexion->error;
                    }
                           
                }
echo json_encode($resultado);
?>