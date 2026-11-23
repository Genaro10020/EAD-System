<?php
session_start();

if (isset($_SESSION["nombre"])) {
  $arreglo = json_decode(file_get_contents("php://input"), true);
  header("Content-Type: application/json");

  include("preguntasGonherModel.php");
  $resultado = "";

  switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
      if (isset($_GET["accion"]) && $_GET["accion"] === "Consultar") {
        $tabla = $_GET["tabla"] ?? "preguntas";

        $resultado = consultarPreguntas($tabla);
      } else {
        $resultado = "No existe esta acción";
      }

      break;
    case "POST":
      if (isset($arreglo['accion']) && $arreglo['accion'] === "Insertar" && isset($arreglo['tabla'], $arreglo['etapa'], $arreglo['peso'], $arreglo['pregunta'])) {
        $tabla = $arreglo["tabla"];
        $etapa = trim($arreglo["etapa"]);
        $peso = (int)$arreglo["peso"];
        $pregunta = trim($arreglo["pregunta"]);

        $resultado = insertarPregunta($tabla, $etapa, $peso, $pregunta);
      } else {
        $resultado = "No existen todas las variables requeridas para insetar";
      }

      break;
    case "PUT":
      if (isset($arreglo['accion']) && $arreglo['accion'] === "Actualizar" && isset($arreglo['tabla'], $arreglo['id'], $arreglo['etapa'], $arreglo['peso'], $arreglo['pregunta'])) {
        $tabla = $arreglo["tabla"];
        $id = (int)$arreglo["id"];
        $etapa = trim($arreglo["etapa"]);
        $peso = (int)$arreglo["peso"];
        $pregunta = trim($arreglo["pregunta"]);

        $resultado = actualizarPregunta($tabla, $id, $etapa, $peso, $pregunta);
      } else {
        $resultado = "No existen todas las variables requeridas para actualizar";
      }

      break;
    case "DELETE": 
      if (isset($_GET["tabla"]) && isset($_GET["id"])) {
        $tabla = $_GET["tabla"];
        $id = (int)$_GET["id"];

        $resultado = eliminarPregunta($tabla, $id);
      } else {
        $resultado = "No llegaron los parámetros para eliminar";
      }

      break;
    default:
      $resultado = "Método HTTP no permitido";

      break;
  }

  echo json_encode($resultado);
} else {
  header("Location:index.php");
}
?>