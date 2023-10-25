 <?php
 session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");

$opc=$_GET['opc'];
 
if ($opc=='agg_new') {
   $adjunto=$_GET['adjunto'];
    $nombre=$_GET['nombre'];
    $ob= new stdClass;
          $ob->title='!';
          $ob->desc='Ocurrio un error inesperado';
          $ob->ico='error';
     $sql = "INSERT INTO parametros_permiso( nombre, adjunto)
         VALUES ('$nombre','$adjunto');";
       if (mysqli_query($link, $sql)) {
         $ob->title='Listo';
          $ob->desc='El nuevo tipo de permiso ha sido creado con exito';
          $ob->ico='success';
         echo "[".json_encode($ob)."]";
       }       
}

 if ($opc=='trear_permisos') {
      $query = "SELECT *  FROM  parametros_permiso order  by nombre";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
}

 if ($opc=='parametros_motivos_user') {
    $id=$_GET['id'];
      $query = "SELECT *  FROM  parametros_motivos where permiso='$id' and status='A'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
}


 if ($opc=='parametros_motivos') {
    $id=$_GET['id'];
      $query = "SELECT *  FROM  parametros_motivos where permiso='$id'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
}


if ($opc=='agg_motivo') {
   $permiso=$_GET['permiso'];
   $tipo_tiempo=$_GET['tipo_tiempo'];
   $tiempo=$_GET['tiempo'];
   $descripcion=$_GET['descripcion'];
   $leyenda=$_GET['leyenda'];
   $adjunto=$_GET['adjunto'];
   $dias_adjunto=$_GET['dias_adjunto'];
    $sql = "INSERT INTO parametros_motivos(permiso, descripcion,tipo_tiempo,tiempo, leyenda, adjunto, dias_adjunto)
         VALUES ('$permiso','$descripcion','$tipo_tiempo','$tiempo','$leyenda','$adjunto','$dias_adjunto');";
       if (mysqli_query($link, $sql)) {
        $query = "SELECT *  FROM  parametros_motivos where permiso='$permiso'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
       }       
}

if ($opc=='editar_motivo') {
   $id=$_GET['id_motivo'];
   $tipo_tiempo=$_GET['tipo_tiempo'];
   $tiempo=$_GET['tiempo'];
   $descripcion=$_GET['descripcion'];
   $leyenda=$_GET['leyenda'];
   $adjunto=$_GET['adjunto'];
   $dias_adjunto=$_GET['dias_adjunto'];
   $status=$_GET["status"];
   $permiso='';
     $query = "SELECT *  FROM  parametros_motivos where id='$id'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $permiso=$row["permiso"] ;}

       $sql = "Update parametros_motivos Set descripcion='$descripcion', tipo_tiempo='$tipo_tiempo', tiempo='$tiempo', leyenda='$leyenda', adjunto='$adjunto', dias_adjunto='$dias_adjunto', status='$status' Where id ='$id';";
        if (mysqli_query($link, $sql)) {
        $query = "SELECT *  FROM  parametros_motivos where permiso='$permiso'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
       }       
}

  if($opc=='eliminar_motivo'){
   $id=$_GET['id'];
   $permiso=$_GET['permiso'];
    
    $sql = "DELETE FROM parametros_motivos WHERE id ='$id'";
    if (mysqli_query($link, $sql)) {
            $query = "SELECT *  FROM  parametros_motivos where permiso='$permiso'";
               $result = mysqli_query($link, $query); 
               while($row = mysqli_fetch_array($result))
               { $datos[]=$row ;}
                   echo json_encode($datos);
     }
}

  if($opc=='eliminar_permiso'){
   $id=$_GET['id'];
     $sql = "DELETE FROM parametros_permiso WHERE id ='$id'";
    if (mysqli_query($link, $sql)) {
                $query = "SELECT *  FROM  parametros_permiso order  by nombre";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
     }
}



 if ($opc=='trear_permisos_dias_funcionario') {
    $rut=$_GET['rut'];
    $fecha=$_GET['fecha'];
      $query = "SELECT *  FROM  permisos where rut='$rut' and fi='$fecha'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $hora_i='';
         $hora_f='';
         if ($row["hi"]!='') {
            $hora_i=$row["hi"];
            $hora_i=$hora_i[0].$hora_i[1].$hora_i[3].$hora_i[4];
            $row["hi"]=$hora_i;
          }

         if ($row["hf"]!='') {
            $hora_f=$row["hf"];
            $hora_f=$hora_f[0].$hora_f[1].$hora_f[3].$hora_f[4];
            $row["hf"]=$hora_f;
           }
       if ($row["hi"]!='' && $row["hf"]!='') {
          $datos[]=$row ;
       }
        }
           echo json_encode($datos);
}

?>