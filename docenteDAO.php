<?php

class docenteDAO {
 
 function __construct() {
   
 }


public function cargar_docentes() {

 require('./bd/conexion.php');
  
  $sql = "SELECT * FROM docente";

  $result = mysqli_query($connection,$sql) or die ("MENSAJE:No se ha ejecutado la senctencia sql:".$sql);

  //$result = $connection->query($sql);

  mysqli_close($connection);

  return $result;

}
    


}
?>