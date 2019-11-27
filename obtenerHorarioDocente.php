<head>
  <title>GUARDIAS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
    
<style>
   
   </style>    
    
</head>
<?php

  require_once 'cabecera.php';
  require_once 'fechas.php';
?>
<script>
        
var horario, x;
horario = {
  "LUNES":[ 0,0,0,0,0,0 ],
   "MARTES":[ 0,0,0,0,0,0 ],
    "MIERCOLES":[ 0,0,0,0,0,0 ],
     "JUEVES":[ 0,0,0,0,0,0 ],
      "VIERNES":[ 0,0,0,0,0,0 ]
};

tareas = {
  "LUNES":[ 0,0,0,0,0,0 ],
   "MARTES":[ 0,0,0,0,0,0 ],
    "MIERCOLES":[ 0,0,0,0,0,0 ],
     "JUEVES":[ 0,0,0,0,0,0 ],
      "VIERNES":[ 0,0,0,0,0,0 ]
};
    
observaciones = {
  "LUNES":[ 0,0,0,0,0,0 ],
   "MARTES":[ 0,0,0,0,0,0 ],
    "MIERCOLES":[ 0,0,0,0,0,0 ],
     "JUEVES":[ 0,0,0,0,0,0 ],
      "VIERNES":[ 0,0,0,0,0,0 ]
};
//x = horario.LUNES[2];        
var dias = ["LUNES","MARTES","MIERCOLES","JUEVES","VIERNES"];       
        
$(document).ready(function(){
    
    $('.opciones').hide();
    
/*Función que se ejecuta al hacer click sobre una celda
Debe de aparecer los iconos de tarea y observaciones.
Además cambia el color del fondo de la celda para indicar que hay ausencia en esa hora.
Las horas que están libres no se hace nada aunque se haga click sobre ellas.
*/
    $("div[id^='hora']").on("click",function(){
                var dia = $(this).data('dia');
                var hora = $(this).data('hora');
             
                icono_tarea="#icono_tarea_"+dia+"_"+hora;
                opciones_hora="#opciones_"+dia+"_"+hora;
                
                 if (!$(this).parent().hasClass('horaLibre')){ 
                     
                     if (!$(this).parent().hasClass('ausencia')){ 
                         $(this).parent().addClass('ausencia'); // set a ausencia
                         $(opciones_hora).show();  //mostramos opciones de ausencia:tarea y observaciones
                         registrarAusencia(dia,hora-1,1);
                    }else{
                        $(this).parent().removeClass('ausencia'); // quitamos ausencia
                        $(opciones_hora).hide();  // oculatamos opciones de ausencia
                        registrarAusencia(dia,hora-1,0);
                        eliminarDatosDeAusencia(dia,hora);
                    }
                
                 } // fin if comprobar hora libre
                 
                console.log(horario);
        
    }); // fin click en div hora_d_h donde d es el dia y h la hora
    
    $('.boton_seleccion_todo').on("click",function(){
                var dia = $(this).data('dia');
                
                if (!$(this).hasClass('todoSeleccion')){ 
                     registrarTodoDiaAusencia(dia);
                     $(this).addClass('todoSeleccion'); 
                }
                else{
                     anularTodoDiaAusencia(dia);
                     $(this).removeClass('todoSeleccion'); 
                }
               
                console.log(horario);
                
            });
    
  /* Función que al hacer click sobre el icono de tarea 
  comprueba si hay o no tarea y en función de ello cambia el icono 
  para indicar lo deseado.
  */  
    $('.icono_tarea').on("click",function(event){
                
                var dia = $(this).parent().parent().data('dia');
                var hora = $(this).parent().parent().data('hora');
        
                id_imagen='#imagen_tarea_'+dia+'_'+hora;
                icono='#icono_tarea_'+dia+'_'+hora;
                
                if ($(this).hasClass('sin_tarea')){ 
                    cambiarIconoHayTarea(icono,id_imagen);
                }
                else{
                    cambiarIconoNoHayTarea(icono,id_imagen);
                }
                //OBLIGATORIO:Esto se debe de hacer para que el div que está debajo, no capture el evento click que se hace sobre el icono de tarea
                event.stopPropagation();
                console.log(horario);
                
    }); // fin click en icono tarea
       

  $(".icono_obsevaciones").click(function(event) {
             
             var dia = $(this).data('dia');
             var hora = $(this).data('hora');
             
            id_celda="#celda_"+dia+"_"+hora;
            id_observacion="#observaciones_"+dia+"_"+hora;
         
            $("#formObservaciones #dia").val(dia);
            $("#formObservaciones #hora").val(hora);
    
            contenido = $(id_observacion).html();
            $("#formObservaciones #campo_observaciones").val(contenido);
    
            
            //Se convierte el div en editable para que se pueda introducir texto
            // y recoger las observaciones para esa guardia.
            //$(id_observacion).attr('contenteditable','true');
            

  }); // fin click sobre icono observaciones
    
    
}); // fin de ready del documento

    
function cambiarIconoHayTarea(icono,imagen){      
         $(imagen).attr('src', 'imagenes/icono_tarea2.png');
         $(icono).removeClass('sin_tarea'); 
}
    
function cambiarIconoNoHayTarea(icono,imagen){ 
          $(imagen).attr('src', 'imagenes/icono_sin_tarea.png');
          $(icono).addClass('sin_tarea');  
}
       
function cambiarIconoHayObservaciones(imagen){  
         $(imagen).attr('src', 'imagenes/icono_observaciones.png');
}

function cambiarIconoNoHayObservaciones(imagen){
         $(imagen).attr('src', 'imagenes/icono_sin_observaciones.png');  
}
    
function registrarTodoDiaAusencia(dia){
            
            for(hora=0;hora<6;hora++){ 
                 id_celda="#celda_"+dia+"_"+(hora+1);
                 if(!$(id_celda).hasClass('horaLibre')){
                     horario[dias[dia-1]][hora]=1;
                     $(id_celda).addClass('ausencia'); 
                     //id_icono="#icono_tarea_"+dia+"_"+(hora+1);
                     opciones_hora="#opciones_"+dia+"_"+(hora+1);
                     $(opciones_hora).show(); 
                 }
               
            }
        }
        
function anularTodoDiaAusencia(dia){
        
            for(hora=0;hora<6;hora++){   
                 id_celda="#celda_"+dia+"_"+(hora+1);
                 if($(id_celda).hasClass('ausencia')){
                     horario[dias[dia-1]][hora]=0;
                     $(id_celda).removeClass('ausencia'); 
                     //id_icono="#icono_tarea_"+dia+"_"+(hora+1);
                     opciones_hora="#opciones_"+dia+"_"+(hora+1);
                     $(opciones_hora).hide();  
                 }
               
            }
}    
    
    
function eliminarDatosDeAusencia(dia,hora){
    
    observaciones = '#observaciones_'+dia+'_'+hora;  
    imagen_tarea='#imagen_tarea_'+dia+'_'+hora;
    icono='#icono_tarea_'+dia+'_'+hora;
    imagen_observaciones='#imagen_observacion_'+dia+'_'+hora;
    $(observaciones).html('');
    cambiarIconoNoHayTarea(icono,id_imagen)
    cambiarIconoNoHayObservaciones(imagen_observaciones);
}

// Función que se ejecuta al cerrar la modal para introducir las observaciones le la hora de guardia. Se recupera las observaciones, el dia y la hora. Estos dos últimos son campos ocultos que se introducen cuando se abre la modal.  
// Se actualiza la capa observaciones_d_h (d=dia,h=hora) con el texto introducido en la modal.
//Si hay texto en las observaciones se debe cambiar el icono de observaciones para que refleje que hay observaciones.
function escribirObservacion() {

        var observacion = $('#campo_observaciones').val();
        var dia = $('#dia').val();
        var hora = $('#hora').val();

        //limpiamos campos y cerramos modal.
        $('#campo_observaciones').val('');
        $('#dia').val('');
        $('#hora').val('');
        $('#modal_observaciones').modal('hide');

        observaciones = '#observaciones_'+dia+'_'+hora;

        $(observaciones).html(observacion);

        imagen='#imagen_observacion_'+dia+'_'+hora;
        if(observacion!=''){
            cambiarIconoHayObservaciones(imagen);

        }else{
            cambiarIconoNoHayObservaciones(imagen);
        }

        $('.submitBtn').removeAttr("disabled");
        $('.modal-body').css('opacity', '');
            

}
    
    
function anularTodoDiaAusencia(dia){
        
            for(hora=0;hora<6;hora++){   
                 id_celda="#celda_"+dia+"_"+(hora+1);
                 if($(id_celda).hasClass('ausencia')){
                     horario[dias[dia-1]][hora]=0;
                     $(id_celda).removeClass('ausencia'); 
                     id_icono="#icono_tarea_"+dia+"_"+(hora+1);
                     $(id_icono).hide(); 
                 }
               
            }
        }
        
        
function registrarAusencia(dia,hora,ausencia,tarea,observaciones){
            
            id_celda="#celda_"+dia+"_"+(hora+1);
            if(!$(id_celda).hasClass('horaLibre')){
                switch(dia){
                    case 1:
                           horario.LUNES[hora]=ausencia;
                         tareas.LUNES[hora]=tarea;
                         observaciones.LUNES[hora]=observaciones;
                        break;
                    case 2:
                           horario.MARTES[hora]=ausencia;
                        break;
                    case 3:
                           horario.MIERCOLES[hora]=ausencia;
                        break;
                    case 4:
                           horario.JUEVES[hora]=ausencia;
                        break;
                    case 5:
                           horario.VIERNES[hora]=ausencia;
                        break;
                }
            }
            
}
        
    </script>

<!-- Modal -->
  <div class="modal fade" id="modal_observaciones" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Observaciones</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <form role="form" id="formObservaciones">
          <div class="form-group">
            
              <input type="text" class="form-control" name="campo_observaciones" id="campo_observaciones">
            </div>
            <input type="hidden" name="dia" id="dia" value="" />
            <input type="hidden" name="hora" id="hora" value="" />
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal" onclick="escribirObservacion()" data-backdrop="false">Aceptar</button>
        </div>
      </div>
      
    </div>
  </div>
    <!-- FIN Modal -->
<?php

  require('./bd/conexion.php');

  if(isset($_GET["docente"]))
      $id_docente = $_GET["docente"]; 

  
  
  $sql_recuperar_horario="SELECT dia,hora,materia,grupo,aula,nombre FROM horario h INNER JOIN docente d ON h.idProfesor=d.id WHERE d.id=".$id_docente; 

  $sql_docente="SELECT * FROM docente WHERE id=".$id_docente; 
    
    
  $horas_docente = mysqli_query($connection,$sql_recuperar_horario) or die ("MENSAJE:No se ha ejecutado la senctencia sql:".$sql_recuperar_horario);
  $resultado_consulta_docente = mysqli_query($connection,$sql_docente) or die ("MENSAJE:No se ha ejecutado la senctencia sql:".$sql_docente);
  $datos_docente = $resultado_consulta_docente->fetch_assoc();   
  $docente =  $datos_docente['nombre'];

$datos = array();

if ($horas_docente->num_rows > 0) {
    while($hora = $horas_docente->fetch_assoc()) {       
        $datos []= $hora;  
    }
    
} else {
    echo "0 results";
}
  
  $codigo_html = mostrarHorariosDocentes(obtenerHorario($datos),$docente);


  echo $codigo_html;
  echo ' <div id="edit-popup" style="display: none">
                <textarea id="text-edit" style="width:100%;height:100%"/>
            </div>';

  mysqli_close($connection);

function obtenerHorario($lista_horas){
    
    
     $horas = array();
   
     $horas["LUNES"]=recuperaHoras($lista_horas,1);
     $horas["MARTES"]=recuperaHoras($lista_horas,2);
     $horas["MIERCOLES"]=recuperaHoras($lista_horas,3);
     $horas["JUEVES"]=recuperaHoras($lista_horas,4);
     $horas["VIERNES"]=recuperaHoras($lista_horas,5);
    
    return $horas;
    
}

function recuperaHoras($lista,$dia){
    
    $clases=array();
    $hora=1;
    $num_clases=sizeof($lista);
    $contador=0;
    for($num_clase=0;$num_clase<$num_clases;$num_clase++){
        if($lista[$num_clase]['dia']==$dia){
            $clases[$hora]=$lista[$num_clase]['materia'];
            $hora++;
        }
    }

    return $clases;
    
}


function mostrarHorariosDocentes($horario,$docente){
    
     $vectorDias =  obtenerVectorDiasSemana();  
    
    $html='
    <div class="container bloque_contenido">
      <div class="horario">
    <div class="row">
    <div class="col-sm-4 docente">
      '.$docente.'
    </div>
    <div class="col-sm-4">
    <a href="grabarAusencia()" class="btn btn-primary btn-volver" role="button">REGISTRAR AUSENCIAS</a>
    </div>
     <div class="col-sm-4">
      
     
    
       <a href="listarDocentes.php" class="btn btn-warning btn-volver" role="button">Volver </a>
</div>
    </div>
    <div class="row">
      <div class="col-sm-2 bg-celda-info celdaTituloH">H</div>
       <div class="col-sm-2 bg-celda-info">
                  '.$vectorDias[0].' LUNES 
                <img class="boton_seleccion_todo" data-dia="1" src="imagenes/icono_seleccionar_todo.png" width="30px" height="30px"/>
       </div> 
        <div class="col-sm-2 bg-celda-info"> '.$vectorDias[1].' MARTES
              <img class="boton_seleccion_todo" data-dia="2" src="imagenes/icono_seleccionar_todo.png" width="30px" height="30px"/>
        </div>
         <div class="col-sm-2 bg-celda-info"> '.$vectorDias[2].' MIERCOLES
              <img class="boton_seleccion_todo" data-dia="3" src="imagenes/icono_seleccionar_todo.png" width="30px" height="30px"/>
         
         </div>
          <div class="col-sm-2 bg-celda-info"> '.$vectorDias[3].' JUEVES
                  <img class="boton_seleccion_todo" data-dia="4" src="imagenes/icono_seleccionar_todo.png" width="30px" height="30px"/>
          </div>
           <div class="col-sm-2 bg-celda-info"> '.$vectorDias[4].' VIERNES
                  <img class="boton_seleccion_todo" data-dia="5" src="imagenes/icono_seleccionar_todo.png" width="30px" height="30px"/>
           </div>  
    </div>'; 

            $lunes=$horario['LUNES'];
            $martes=$horario['MARTES'];
            $miercoles=$horario['MIERCOLES'];
            $jueves=$horario['JUEVES'];
            $viernes=$horario['VIERNES'];
           
           for($i=1;$i<7;$i++){
               
               $html =$html.'<div class="row">';
               $html =$html.'<div class="col-sm-2 bg-celda-info celdaHora">'.$i.'</div>';
        
               $html =$html.''.construirHTML_hora(1,$i,$lunes[$i]);
                $html =$html.''.construirHTML_hora(2,$i,$martes[$i]);
                $html =$html.''.construirHTML_hora(3,$i,$miercoles[$i]);
                $html =$html.''.construirHTML_hora(4,$i,$jueves[$i]);
                $html =$html.''.construirHTML_hora(5,$i,$viernes[$i]);
               $html =$html.'</div>';
           }
        
  $html =$html.'  </div></div>';
    
    return $html;
}
function construirHTML_hora($dia,$hora,$contenido_hora){
    
    if($contenido_hora=='LIBRE'){
        $estiloHora='horaLibre';
        $contenido_hora='';
    }else if($contenido_hora=='GUARDIA'){
         $estiloHora='horaGuardia';
    }
    else{
        $estiloHora='horaDocencia';
    }
    
   /* $html='<div class="col-sm-2 celda '.$estiloHora.'" id="celda_'.$dia.'_'.$hora.'"  data-dia="'.$dia.'" data-hora="'.$hora.'">'.$contenido_hora.'
    <div class="icono_tarea" id="icono_tarea_'.$dia.'_'.$hora.'">
      <img id="imagen_'.$dia.'_'.$hora.'" class="sin_tarea" src="imagenes/icono_sin_tarea.png" width="40px" height="40px"/>
    </div>
    <div class="observacion" id="observaciones_'.$dia.'_'.$hora.'" data-dia="'.$dia.'" data-hora="'.$hora.'">
    </div>
    </div>';
    */
    
    $html='<div class="col-sm-2 celda '.$estiloHora.'" id="celda_'.$dia.'_'.$hora.'"  data-dia="'.$dia.'" data-hora="'.$hora.'">
                <div class="datos_hora">'.$contenido_hora.'</div>
                
                
                <div class="opciones" id="opciones_'.$dia.'_'.$hora.'">
                  <div class="icono_tarea sin_tarea" id="icono_tarea_'.$dia.'_'.$hora.'">
                   <img id="imagen_tarea_'.$dia.'_'.$hora.'" src="imagenes/icono_sin_tarea.png" width="40px" height="40px"/>
                 </div>
                    
                 <div class="icono_obsevaciones" id="icono_observaciones_'.$dia.'_'.$hora.'" data-dia="'.$dia.'" data-hora="'.$hora.'" data-target="#modal_observaciones" data-toggle="modal">
                   <img id="imagen_observacion_'.$dia.'_'.$hora.'" src="imagenes/icono_sin_observaciones.png" width="40px" height="40px"/>
                 </div>
                
                </div>
                <div class="contenido_hora" id="hora_'.$dia.'_'.$hora.'" data-dia="'.$dia.'" data-hora="'.$hora.'">
                     <div class="texto_observacion" id="texto_'.$dia.'_'.$hora.'">
                    
                         <div class="observacion" id="observaciones_'.$dia.'_'.$hora.'" data-dia="'.$dia.'" data-hora="'.$hora.'">
                             </div>
                    </div>   
                </div>
                 
                
            </div>';
    
    
    return $html;
    
}

?>
  