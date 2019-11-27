

<?php
require_once 'cabecera.php';
require_once 'docenteDAO.php';

$docente_dao = new docenteDAO();


$lista_docentes = $docente_dao->cargar_docentes();



echo '<div class="container bloque_contenido">
       
         <div class="row">
    
    <div class="col-sm-1 icono">
   
    </div>
    <div class="col-sm-2">
       <span class="texto_titulo">Docentes</span>
    </div>
    
    <div class="col-sm-7 menu_alumnos">
       
     
   <div class="buscador">
   <input class="form-control" id="bucador_docente" type="text" placeholder="Buscar..">  
    </div>
  </div>';  

   echo '
   
   <div class="col-sm-2">
          <div class="text-right">
            <a href="inicio.php" class="btn btn-warning boton_cabecera boton_volver" role="button">Volver</a>
          </div>
    </div>
    </div>
       
    
   
    
  <table class="table" id="tabla_docente">
    <thead>
      <tr>
        <th class="texto_cabecera_tabla">nombre</th>
        <th class="texto_cabecera_tabla">codigo</th>
        <th class="texto_cabecera_tabla">departamento</th>
         <th></th>
          <th></th>
            <th></th>
         <th></th>
      </tr>
    </thead><tbody>';
         
    
    while($docente = $lista_docentes->fetch_assoc()) {

    echo '<tr data-docente="'.$docente["id"].'">
          <td class="textoTabla">'.$docente["nombre"].'</td>
          <td class="textoTabla">'.$docente["codigoProfesor"].'</td>
          <td class="textoTabla">'.$docente["departamento"].'</td>
           
          <td> <a href="#" class="btn btn-info btn-sm" role="button">VER</a></td>
           <td><a href="obtenerHorarioDocente.php?docente='.$docente["id"].'" class="btn btn-info btn-sm" role="button">AUSENCIAS</a></td>
          <td><a href="formularioEditarAlumno.php?id='.$docente["id"].'" class="btn btn-info btn-sm" role="button">EDITAR</a></td>
          <td><a href="#" class="btn btn-info btn-sm" role="button">ELIMINAR</a></td>

        </tr>';
              
              
          

          }
    
    echo' </tbody>
  </table>
  <div class="text-right">
            <a href="alumnos.php" class="btn btn-warning boton_cabecera boton_volver" role="button">Volver</a>
  </div>
 
</div>'  ;   
    
    
      
?>
<script>

$(document).ready(function(){
  $("#bucador_docente").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tabla_docente tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

