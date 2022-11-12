<?php
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */
$data['titulo'] = "Inicio";
$data["div_titulo"] = "Página inicio";
$data['texto'] = "<p>Para crear un ejercicio, crea, dentro de models, un fichero php con un nombre tipo <strong>ejercicio.controller.php</strong>.</p><p>Automáticamente el ejercicio aparecerá en el submenú Ejercicios del panel lateral izquierdo y podrás testearlo.</p>";

/*
 * Llamamos a las vistas
 */
include 'views/templates/header.php';
include 'views/inicio.view.php';
include 'views/templates/footer.php';