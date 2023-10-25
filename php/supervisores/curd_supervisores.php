 <?php
 session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");

$opc=$_GET['opc'];
 
  if ($opc=='verificar_supervisor') {
    $rut=$_GET['rut'];
      $query = "SELECT *  FROM  supervisores where rut='$rut'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
}

 if ($opc=='trear_vinculados') {
    $id=$_GET['id'];
      $query = "SELECT *  FROM  vinculaciones where id_supervisor='$id' and status='1' order  by nombre";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
}

if ($opc=='agg_vinculacion') {
   $nombre=$_GET['nombre'];
    $id_funcionario=$_GET['id_funcionario'];
     $id_supervisor=$_GET['id_supervisor'];
    $ob= new stdClass;
          $ob->title='!';
          $ob->desc='Ocurrio un error inesperado';
          $ob->ico='error';
           $sql = "DELETE FROM vinculaciones WHERE id_funcionario ='$id_funcionario'";
    if (mysqli_query($link, $sql)) {
     $sql = "INSERT INTO vinculaciones(id_supervisor, id_funcionario, nombre)
         VALUES ('$id_supervisor','$id_funcionario','$nombre');";
       if (mysqli_query($link, $sql)) {
            $sql = "Update supervisores Set n=(n+1) Where id ='$id_supervisor';";
              if (mysqli_query($link, $sql)) {}
         $query = "SELECT *  FROM  vinculaciones where id_supervisor='$id_supervisor' order  by nombre";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
       }       
       }
}

  if($opc=='eliminar_vinculo'){
   $id=$_GET['id'];
    $supervisor=$_GET['supervisor'];
     $sql = "DELETE FROM vinculaciones WHERE id ='$id'";
    if (mysqli_query($link, $sql)) {
        $query = "SELECT *  FROM  vinculaciones where id_supervisor='$supervisor' order  by nombre";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
     }
  }


?>

