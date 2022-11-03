<?php
//Hace de router aunque es muy inseguro ya que escanea el directorio models
//En clases posteriores veremos como mejorar esto y hacer un router de verdad
$filename = isset($_GET['sec']) ? $_GET['sec'] : 'inicio';
if(substr($filename, 0, 1) == "_" || $filename == "index" || !file_exists(getControllerName($filename))){
    $filename = "inicio";
}
require_once getControllerName($filename);

/**
 * 
 * @param string $filename nombre del controlador
 * @return string Devuelve la ruta para cargar el controlador
 */
function getControllerName(string $filename): string{
    return CONTROLLERS_HOME."$filename.controller.php";
}
