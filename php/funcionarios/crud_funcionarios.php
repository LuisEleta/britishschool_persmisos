 <?php
 //session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");

$opc=$_GET['opc'];
 

 if ($opc=='un_funcionario') {
    $rut=$_GET['rut'];
      $query = "SELECT *, id as pr, id as r, id as a  FROM  funcionarios where rut='$rut'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {$pr=0;
        $r=0;
        $a=0;
        $row["pr"]=0;
        $row["r"]=0;
        $row["a"]=0;
           $query2 = "SELECT *  FROM  permisos where rut='$rut' order  by id desc";
           $result2 = mysqli_query($link, $query2); 
           while($row2 = mysqli_fetch_array($result2))
           { 
             if ($row2["status"]=='Por revisar') {
                $pr=$pr+1;
             }
             if ($row2["status"]=='Aprobado') {
                $a=$a+1;
              }
             if ($row2["status"]=='Rechazado') {
                $r=$r+1;
              }
           }
           $row["pr"]=$pr;
           $row["r"]=$r;
           $row["a"]=$a;
         $datos[]=$row ;}
         echo json_encode($datos);
}

 if ($opc=='todos_funcionarios') {
       $query = "SELECT *, id as foto , id as prev, id as supe  FROM  funcionarios where status='1'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $rut=$row["rut"];
        $row["supe"]='';
        $query2 = "SELECT *  FROM  vinculaciones, supervisores where vinculaciones.id_funcionario='$rut' and vinculaciones.id_supervisor=supervisores.id";
           $result2 = mysqli_query($link, $query2); 
           while($row2 = mysqli_fetch_array($result2))
           { 
             $row["supe"]= $row["supe"].' '.$row2["nombre"].' - ';
           }
         if ($row["tipo_f"]=='N') {
            $row["tipo_f"]='No docente';
            $row["prev"]='ND';
         }
         if ($row["tipo_f"]=='A') {
            $row["tipo_f"]='Auxiliar';
            $row["prev"]='A';
         }
         if ($row["tipo_f"]=='D') {
            $row["tipo_f"]='Docente';
            $row["prev"]='D';
         }
        $datos[]=$row ;

       }
           echo json_encode($datos);
}

 if ($opc=='todos_funcionarios_hr') {
       $query = "SELECT *, id as foto, id as supe, id as apro , id as noapro, id as prev  FROM  funcionarios where status='1'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $apro=0;
        $no_apro=0;
        $rut=$row["rut"];
        $row["supe"]='';
          $query11 = "SELECT *  FROM  permisos where rut='$rut'";
           $result11 = mysqli_query($link, $query11); 
           while($row11 = mysqli_fetch_array($result11))
           {
              if ($row11["status"]=='Aprobado') {
                  $apro++;
              }else{
                $no_apro++;
              }
           }
         $row["apro"]=$apro;
         $row["noapro"]=$no_apro;

        $query2 = "SELECT *  FROM  vinculaciones, supervisores where vinculaciones.id_funcionario='$rut' and vinculaciones.id_supervisor=supervisores.id";
           $result2 = mysqli_query($link, $query2); 
           while($row2 = mysqli_fetch_array($result2))
           { 
             $row["supe"]= $row["supe"].' '.$row2["nombre"].' - ';
           }
          if ($row["tipo_f"]=='N') {
            $row["tipo_f"]='No docente';
            $row["prev"]='ND';
         }
         if ($row["tipo_f"]=='A') {
            $row["tipo_f"]='Auxiliar';
            $row["prev"]='A';
         }
         if ($row["tipo_f"]=='D') {
            $row["tipo_f"]='Docente';
            $row["prev"]='D';
         }
        $datos[]=$row ;

       }
           echo json_encode($datos);
}

 if ($opc=='todos_exfuncionarios') {
       $query = "SELECT *, id as foto, id as supe, id as prev  FROM  funcionarios where status='0'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $rut=$row["rut"];
        $row["supe"]='';
        $query2 = "SELECT *  FROM  vinculaciones, supervisores where vinculaciones.id_funcionario='$rut' and vinculaciones.id_supervisor=supervisores.id";
           $result2 = mysqli_query($link, $query2); 
           while($row2 = mysqli_fetch_array($result2))
           { 
             $row["supe"]= $row["supe"].' '.$row2["nombre"].' - ';
           }
          if ($row["tipo_f"]=='N') {
            $row["tipo_f"]='No docente';
            $row["prev"]='ND';
         }
         if ($row["tipo_f"]=='A') {
            $row["tipo_f"]='Auxiliar';
            $row["prev"]='A';
         }
         if ($row["tipo_f"]=='D') {
            $row["tipo_f"]='Docente';
            $row["prev"]='D';
         }
        $datos[]=$row ;

       }
           echo json_encode($datos);
}
  

if ($opc=='agg_supervisor') {
   $nombre=$_GET['nombre'];
   $rut=$_GET['rut'];
    $sql = "INSERT INTO supervisores(nombre, rut)
         VALUES ('$nombre','$rut');";
       if (mysqli_query($link, $sql)) {
        $query = "SELECT *  FROM  supervisores ";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
       }       
}

 if ($opc=='traer_supervisores') {
         $query = "SELECT *, id as foto  FROM  supervisores ";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $id_supe=$row["id"];
          $row["n"]=0;
             $query1 = "SELECT *  FROM  vinculaciones where id_supervisor='$id_supe' ";
               $result1 = mysqli_query($link, $query1); 
               while($row1 = mysqli_fetch_array($result1))
               { $row["n"]++;}
          $datos[]=$row ;}
           echo json_encode($datos);
}

  if($opc=='eliminar_supervisor'){
   $id=$_GET['id']; 
    $sql = "DELETE FROM supervisores WHERE id ='$id'";
    if (mysqli_query($link, $sql)) {
          $query = "SELECT *  FROM  supervisores ";
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

if ($opc=='editar_funcionario') {
  $id=$_GET['id'];
  $correo=$_GET['correo'];
  $lunes=$_GET['lunes'];
  $martes=$_GET['martes'];
  $miercoles=$_GET['miercoles'];
  $jueves=$_GET['jueves'];
  $viernes=$_GET['viernes'];
   $sabado=$_GET['sabado'];
   $tipo_funcionario=$_GET['tipo_funcionario'];
    $tipo_horario=$_GET['tipo_horario'];
     $hr_anno=$_GET['hr_anno'];
      $hr_semanal=$_GET['hr_semanal'];
          $correo2=$_GET['correo2'];
            $hr_cobradas=$_GET['hr_cobradas'];
       $sql = "Update funcionarios Set correo='$correo', lun_hr='$lunes', mar_hr='$martes', mie_hr='$miercoles', jue_hr='$jueves', vie_hr='$viernes', sab_hr='$sabado', tipo_f='$tipo_funcionario', horario='$tipo_horario', hr_disp='$hr_anno', hr_semanal='$hr_semanal', correo_p='$correo2', hrs_cobradas='$hr_cobradas' Where id ='$id';";
              if (mysqli_query($link, $sql)) {
               $query = "SELECT *  FROM  funcionarios ";
               $result = mysqli_query($link, $query); 
               while($row = mysqli_fetch_array($result))
               { $datos[]=$row ;}
                   echo json_encode($datos);
         }      
}

 if ($opc=='crear_funcionario') {
  $nombre=$_GET['nombre'];
  $rut=$_GET['rut'];
  $correo=$_GET['correo'];
  $tipo_funcionario=$_GET['tipo_funcionario'];
  $tipo_horario=$_GET['tipo_horario'];
  $hr_anno=$_GET['hr_anno'];
  $hr_semanal=$_GET['hr_semanal'];
  $lunes=$_GET['lunes'];
   $martes=$_GET['martes'];
   $miercoles=$_GET['miercoles'];
    $jueves=$_GET['jueves'];
     $viernes=$_GET['viernes'];
      $sabado=$_GET['sabado'];
        $correo2=$_GET['correo2'];
     $sql = "INSERT INTO funcionarios( nombre, rut, correo, tipo_f, horario, hr_disp, hr_semanal, lun_hr, mar_hr, mie_hr, jue_hr, vie_hr, sab_hr, correo_p)
         VALUES ('$nombre','$rut','$correo','$tipo_funcionario','$tipo_horario','$hr_anno','$hr_semanal','$lunes','$martes','$miercoles','$jueves','$viernes','$sabado','$correo2');";
       if (mysqli_query($link, $sql)) {
               $query = "SELECT *  FROM  funcionarios ";
               $result = mysqli_query($link, $query); 
               while($row = mysqli_fetch_array($result))
               { $datos[]=$row ;}
                   echo json_encode($datos);
       }       
}


  if($opc=='eliminar_funcionario'){
   $id=$_GET['id'];
    $status=$_GET['status'];
     $rut=$_GET['rut'];
    if ($status=='1') {
       $status='0';
    }else{
        $status='1';
      }
         $sql = "Update funcionarios Set status='$status' Where id ='$id';";
              if (mysqli_query($link, $sql)) {
                $sql = "Update vinculaciones Set status='$status' Where id_funcionario ='$rut';";
              if (mysqli_query($link, $sql)) {}
       $query = "SELECT *, id as foto, id as supe, id as prev  FROM  funcionarios ";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $rut=$row["rut"];
        $row["supe"]='';
        $query2 = "SELECT *  FROM  vinculaciones, supervisores where vinculaciones.id_funcionario='$rut' and vinculaciones.id_supervisor=supervisores.id";
           $result2 = mysqli_query($link, $query2); 
           while($row2 = mysqli_fetch_array($result2))
           { 
             $row["supe"]= $row["supe"].' '.$row2["nombre"].' - ';
           }
          if ($row["tipo_f"]=='N') {
            $row["tipo_f"]='No docente';
            $row["prev"]='ND';
         }
         if ($row["tipo_f"]=='A') {
            $row["tipo_f"]='Auxiliar';
            $row["prev"]='A';
         }
         if ($row["tipo_f"]=='D') {
            $row["tipo_f"]='Docente';
            $row["prev"]='D';
         }
        $datos[]=$row ;

       }
           echo json_encode($datos);

              }
     
}


?>