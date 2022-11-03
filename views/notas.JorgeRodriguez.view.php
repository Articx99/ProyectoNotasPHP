<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ejercicio Notas</h1>

</div>

<!-- Content Row -->

<div class="row">
      

    <div class="col-12 col-16">
        
        <div class="card shadow mb-4">
            <?php
           
            if(isset($data['resultado'])){
            ?>

            <div class="col-12">
                <table class="table table-staped">
                    <thead>
                        <tr>
                            <th>
                                Módulo
                            </th>
                            <th>
                                Media
                            </th>
                            <th>
                                Aprobados
                            </th>
                            <th>
                                Suspensos
                            </th>
                            <th>
                                Nota máxima
                            </th>
                            <th>
                                Nota mínima
                            </th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            
                foreach($data['resultado'][0] as $asign => $notas){
                    echo "<tr> <td>$asign</td>";
                    foreach($notas as $key => $value){ 
                        if($key  != 'max' && $key != 'min') {

                            echo "<td>$value</td>";                       
                        }
                        else{                                

                            echo "<td>". $value['alumno'] . ":" . $value['nota'] . "</td>" ;                                
                            }

                    }
                    echo "</tr>";

                }

            }
            ?>
            </tbody>
                    </table>

            </div>
            <?php    
                if(isset($data['resultado']['alumnos'])){
    ?>
    <!--Para parte 2 -->
    <div class="col-lg-4 col-12">
        <div class="alert alert-success">
            <ol>
            <?php 
            foreach($data['resultado']['alumnos'] as $nombre => $arrayNotas){
                foreach($arrayNotas as $notas => $n){
                    
                    if($n === 0){  
                        echo "<li>$nombre</li>";
                    }
                }
            }
            ?>
            </ol>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="alert alert-warning">
            <ol>
            <?php 
            foreach($data['resultado']['alumnos'] as $nombre => $arrayNotas){
                foreach($arrayNotas as $notas => $n){
                    if($n == 1){
                    echo "<li>$nombre</li>";
                }
                }
                
            }
            ?>
            </ol>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="alert alert-danger">
            <ol>
            <?php 
            foreach($data['resultado']['alumnos'] as $nombre => $arrayNotas){
                foreach($arrayNotas as $notas => $n){
                    if($n > 1){                       
                        echo "<li>$nombre</li>";
                    }
                }
            }
            ?>
            </ol>
        </div>
    </div>
    <?php
    }
    ?> 
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                                   
            </div>
            <h6 class="m-0 font-weight-bold text-primary">Proyecto Notas</h6>
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">-->
                <form action="./?sec=notas.JorgeRodriguez" method="post">
                    
                    <div class="mb-3">
                        <label for="ej1Numeros">Inserta js</label> 
                        <textarea class="form-control" id="datos" type="text" name="json_notas" rows="3"><?php echo isset($data['input']['datos']) ? $data['input']['datos'] : '';?></textarea>
                    </div>                   
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                    
                </form>
                <p class="text-danger small"> <?php echo isset($data['errores']['datos']) ? $data['errores']['datos']: '';?></p>          
            </div>
        </div>
    </div>
    
</div>