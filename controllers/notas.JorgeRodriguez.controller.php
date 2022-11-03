<?php
declare (strict_types = 1);
$data = array();

$errores = array();
if(isset($_POST['enviar'])){    
    $errores = checkForm($_POST);
    $data['errores'] = $errores;
    if(count($errores) === 0){
        $asignaturas = json_decode($_POST['json_notas'],true);
        $data['resultado'] = asignaturas(sanitizarInput($asignaturas));
    }
}

function sanitizarInput(array $datos): array{
    return filter_var_array($datos,FILTER_SANITIZE_SPECIAL_CHARS);
}

function asignaturas(array $asignaturas):array{
    $resultado = array();  
    $alumnos = array();
    foreach($asignaturas as $asign => $notas){     
        $mediaTotal = 0;
        $aprobados = 0;
        $suspensos = 0;        
        $alumnoNotaMasAlta = "";
        $alumnoNotaMinima = "";
        $notaMaxima = 0; 
        $notaMinima = 11;
       
        foreach($notas as $nombre => $arrayNotas){            
            $media = 0;    
            foreach($arrayNotas as $nota){
                $media += $nota; 
        
                if($nota > $notaMaxima){
                    $notaMaxima = $nota;
                    $alumnoNotaMasAlta = $nombre;
                }
                if($nota < $notaMinima){
                    $notaMinima = $nota;
                    $alumnoNotaMinima = $nombre;
                }                
            } 
            
            $mediaTotal += $media/count($arrayNotas);
            if(($media / count($arrayNotas)) < 5){
                $suspensos++;
                if(array_key_exists($nombre,$alumnos)){
                    $alumnos[$nombre]['suspensos']++;
                }
                else{
                    $alumnos[$nombre] = array('suspensos' => 1);
                }
            }
            else{  
                $aprobados++;
            }
            if(!array_key_exists($nombre,$alumnos)){
                $alumnos[$nombre] = array('suspensos' => 0);
            }
        }
                            
        $resultado[$asign] = array(
            'media' => number_format($mediaTotal/count($notas),2,',','.'),
            'aprobados' => $aprobados,
            'suspensos' => $suspensos,
            'max' => array(
                'alumno' => $alumnoNotaMasAlta,
                'nota' => $notaMaxima
            ),
            'min' => array(
                'alumno' => $alumnoNotaMinima,
                'nota' => $notaMinima
            )
        );
    }  
    return array($resultado, "alumnos" => $alumnos);
    
}

function checkForm(array $post) : array{
    $errores = [];
    if(empty($post['json_notas'])){
        $errores['json_notas'] = 'Este campo es obligatorio';
    }
    else{
        $modulos = json_decode($post['json_notas'], true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $errores['json_notas'] = 'El formato no es correcto';
        }
        else{
            $erroresJson = "";
            foreach($modulos as $modulo => $alumnos){
                if(empty($modulo)){
                    $erroresJson .= "El nombre del módulo no puede estar vacío<br>";
                }
                if(!is_array($alumnos)){
                    $erroresJson .= "El módulo '".htmlentities($modulo)."' no tiene un array de alumnos<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                else{
                    foreach($alumnos as $nombre => $arrayNotas){
                        foreach($arrayNotas as $n){
                            if(empty($nombre)){
                                $erroresJson .= "El módulo '".htmlentities($modulo)."' tiene un alumno sin nombre<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                            }
                            if(!is_float($n) && !is_int($n) ){
                                $erroresJson .= "El módulo '".htmlentities($modulo)."' tiene la nota '".htmlentities($n)."' que no es un int<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                            }
                            else{
                                if($n < 0 || $n > 10){
                                    $erroresJson .= "Módulo '".htmlentities($modulo)."' alumno '".htmlentities($nombre)."' tiene una nota de ".$n."<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                                }
                            }
                        }       
                    }
                }
            }
            if(!empty($erroresJson)){
                $errores['json_notas'] = $erroresJson;
            }
        }
    }
    return $errores;
}

include 'views/templates/header.php';
include 'views/notas.JorgeRodriguez.view.php';
include 'views/templates/footer.php';