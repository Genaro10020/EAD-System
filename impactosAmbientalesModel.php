<?php
    include("conexionGhoner.php");

    function guardarImpacto($datos) {
        global $conexion;
        $answer = false;

        $diagrama   = $datos['diagrama'];
        $tipo       = $datos['tipo'];
        $concepto   = $datos['concepto'];
        $alcance    = $datos['alcance'] !== '' ? (int)$datos['alcance'] : null;
        $cantidad   = $datos['cantidad'] !== '' ? (int)$datos['cantidad'] : null;
        $um         = $datos['um'];
        $co2        = $datos['co2'] !== '' ? (int)$datos['co2'] : null;
        $referencia = $datos['referencia'];

        $guardar = "INSERT INTO impactos_ambientales (diagrama, tipo, concepto, alcance, cantidad, um, co2, referencia) VALUES (?,?,?,?,?,?,?,?)";
        
        $stmt = $conexion->prepare($guardar);
        
        if(!$stmt){ return $conexion->error; }
        
        $stmt->bind_param("sssiisis", $diagrama, $tipo, $concepto, $alcance, $cantidad, $um, $co2, $referencia);
        
        if(!$stmt->execute()){ return $stmt->error; }
        
        $answer = true;
        return $answer;
    }
?>