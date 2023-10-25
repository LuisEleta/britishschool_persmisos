 <?php
 session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");

$opc=$_GET['opc'];
 


 if ($opc=='trear_permisos_de_funcionarios') {
     $rut=$_GET['rut'];
      $query = "SELECT *, id as tipo_tiempo, id as ban_adjunto  FROM  permisos where rut='$rut' order  by id desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { 
        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  
           if ($row2["adjunto"]=='Si') {
               $row["ban_adjunto"]='si';
           }else{
             $row["ban_adjunto"]='oculto';
           }
            $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
        $datos[]=$row ;
   }
           echo json_encode($datos);
}


 if ($opc=='traer_todos_los_permisos') {
       $query = "SELECT *, id as tipo_tiempo, id as name, id as foto  FROM  permisos order  by id desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $ad=$row["adjunto"];
         if ($ad=='') {
           $row["adjunto"]='oculto';
         }
         $rut=$row["rut"]; 
         $name='';
       $query6 = "SELECT * FROM funcionarios where rut='$rut'";
        $result6 = mysqli_query($link, $query6); 
        while($row6 = mysqli_fetch_array($result6))
        {  
           $name=$row6['nombre']." ".$row6['apellido_p']." ".$row6['apellido_m']; 
        } 
         $rut=$row["name"]=$name; 
        

        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
        $datos[]=$row ;
   }
           echo json_encode($datos);
}


 if ($opc=='trear_permisos_para_responder') {
     $id=$_GET['id'];
     $rut='';
      $query5 = "SELECT *  FROM  vinculaciones where id_supervisor='$id'";
       $result5 = mysqli_query($link, $query5); 
       while($row5 = mysqli_fetch_array($result5))
       { $rut=$row5["id_funcionario"]; 
         $name='';
         $hr_disp='';
       $query6 = "SELECT * FROM funcionarios where rut='$rut'";
        $result6 = mysqli_query($link, $query6); 
        while($row6 = mysqli_fetch_array($result6))
        {  
           $name=$row6['nombre']." ".$row6['apellido_p']." ".$row6['apellido_m']; 
           $hr_disp=$row6["hr_disp"];
        } 

      $query = "SELECT *, id as tipo_tiempo, id as name, id as hr_disp  FROM  permisos where rut='$rut' and status='Por revisar' order  by id desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { 
        $row["name"]=$name;
        $row["hr_disp"]=$hr_disp;
        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
         $datos[]=$row ;
        }

        }
           echo json_encode($datos);
}


 if ($opc=='rechazar_permiso') {
  $id=$_GET['id'];
  $id_sup=$_GET['id_sup'];
  $fecha= date("d-m-Y").' - '. date("H:i:s");

 $sql = "Update permisos Set status='Rechazado', fecha_resp='$fecha' Where id ='$id';";
 if (mysqli_query($link, $sql)) {
    $rut='';
      $query5 = "SELECT *  FROM  vinculaciones where id_supervisor='$id_sup'";
       $result5 = mysqli_query($link, $query5); 
       while($row5 = mysqli_fetch_array($result5))
       { $rut=$row5["id_funcionario"]; 
         $name='';
       $query6 = "SELECT * FROM funcionarios where rut='$rut'";
        $result6 = mysqli_query($link, $query6); 
        while($row6 = mysqli_fetch_array($result6))
        {  
           $name=$row6['nombre']." ".$row6['apellido_p']." ".$row6['apellido_m']; 
        } 

      $query = "SELECT *, id as tipo_tiempo, id as name  FROM  permisos where rut='$rut' and status='Por revisar' order  by id desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { 
        $row["name"]=$name;
        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
         $datos[]=$row ;
        }

        }
           echo json_encode($datos);

  }


 }

  if ($opc=='aprobar_permiso') {
  $id=$_GET['id'];
  $id_sup=$_GET['id_sup'];
  $fecha= date("d-m-Y").' - '. date("H:i:s");
 $sql = "Update permisos Set status='Aprobado', fecha_resp='$fecha' Where id ='$id';";
 if (mysqli_query($link, $sql)) {
//-----------------------------------------------------------------------------------------------------------------------------
    $c='';
    $tiempo_permiso='';
    $motivo='';
    $tipo_tiempo='';
    $descuento='';
    $tipo_permiso='';
        $query2 = "SELECT *  FROM  permisos where id='$id'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        { 
           $rut_funcionario=$row2["rut"];
           $tiempo_permiso=$row2["ht"];
           $motivo=$row2["motivo"];
            $descuento=$row2["descuento"];
            $tipo_permiso=$row2["tipo_permiso"];
         }
         if ($tipo_permiso=='3') {
              $tiempo_permiso='00:00';
         }


         $query2 = "SELECT *  FROM  parametros_motivos where id='$motivo'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        { 
           $tipo_tiempo=$row2["tipo_tiempo"];
         }

         if ($tipo_tiempo=='HR' && $descuento=='SI') {
            $hr_disp='';
            $query2 = "SELECT *  FROM  funcionarios where rut='$rut_funcionario'";
            $result2 = mysqli_query($link, $query2); 
            while($row2 = mysqli_fetch_array($result2))
            { 
               $hr_disp=$row2["hr_disp"];
             }
         $hr_permiso=$tiempo_permiso[0].$tiempo_permiso[1];
         $min_permiso=$tiempo_permiso[3].$tiempo_permiso[4];
         $hr_disponibles=$hr_disp[0].$hr_disp[1];
         $min_disponibles=$hr_disp[3].$hr_disp[4];
         
         $min_disponibles=$min_disponibles-$min_permiso;

         if ($min_disponibles<0) {
           $min_disponibles=$min_disponibles+60;
           $hr_disponibles=$hr_disponibles-1;
         }
         if ($min_disponibles<10) {
           $min_disponibles='0'.$min_disponibles;
         }
         
         $hr_disponibles=$hr_disponibles-$hr_permiso;
        
         if ($hr_disponibles<10) {
           $hr_disponibles='0'.$hr_disponibles;
         }
         $nuevo_tiempo_disp=$hr_disponibles.':'.$min_disponibles;
         
         $sql2 = "Update funcionarios Set hr_disp='$nuevo_tiempo_disp' Where rut ='$rut_funcionario';";
           if (mysqli_query($link, $sql2)) {}

         }

//-----------------------------------------------------------------------------------------------------------------------------
    $rut='';
      $query5 = "SELECT *  FROM  vinculaciones where id_supervisor='$id_sup'";
       $result5 = mysqli_query($link, $query5); 
       while($row5 = mysqli_fetch_array($result5))
       { $rut=$row5["id_funcionario"]; 
         $name='';
       $query6 = "SELECT * FROM funcionarios where rut='$rut'";
        $result6 = mysqli_query($link, $query6); 
        while($row6 = mysqli_fetch_array($result6))
        {  
           $name=$row6['nombre']." ".$row6['apellido_p']." ".$row6['apellido_m']; 
        } 

      $query = "SELECT *, id as tipo_tiempo, id as name  FROM  permisos where rut='$rut' and status='Por revisar' order  by id desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { 
        $row["name"]=$name;
        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
         $datos[]=$row ;
        }

        }
           echo json_encode($datos);

  }


 }


 if ($opc=='trear_un_permiso') {
     $id=$_GET['id'];
      $query = "SELECT *, id as tipo_tiempo  FROM  permisos where id='$id' order  by id desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { 
        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
            $datos[]=$row ;
         }
           echo json_encode($datos);
}


  if($opc=='eliminar_permiso_funcionario'){
   $id=$_GET['id'];
   $rut=$_GET['rut'];
     $fecha= date("d-m-Y").' - '. date("H:i:s");
      $sql2 = "Update permisos Set status='Anulado', fecha_resp='$fecha'  Where id ='$id';";
     if (mysqli_query($link, $sql2)) {
      $query = "SELECT *, id as tipo_tiempo  FROM  permisos where rut='$rut' order  by id desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { 
        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
          $datos[]=$row ;
                   echo json_encode($datos);
     }
}}

  if($opc=='eliminar_permiso_funcionario_admin'){
   $id=$_GET['id'];
    $fecha= date("d-m-Y").' - '. date("H:i:s");
      $sql2 = "Update permisos Set status='Anulado', fecha_resp='$fecha'  Where id ='$id';";
     if (mysqli_query($link, $sql2)) {}
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
    $sql = "INSERT INTO parametros_motivos(permiso, descripcion,tipo_tiempo,tiempo)
         VALUES ('$permiso','$descripcion','$tipo_tiempo','$tiempo');";
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




 if ($opc=='permisos_calendario') {
     $fi=$_GET['fi'];
      $ff=$_GET['ff'];
       $tipo=$_GET['tipo'];
      
      $query = "SELECT *, id as tipo_tiempo, id as name_f, id as tipo_f  FROM  permisos where fh>='$fi' and fh<='$ff' and status='Aprobado' order  by fh";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $rut=$row["rut"];
        $query20 = "SELECT *  FROM  funcionarios where rut='$rut'";
        $result20 = mysqli_query($link, $query20); 
        while($row20 = mysqli_fetch_array($result20))
        {  $row["name_f"]=$row20["nombre"].' '.$row20["apellido_p"]; 
           $row["tipo_f"]=$row20["tipo_f"];
           if ($row["tipo_f"]=='D') {$row["tipo_f"]='Docente'; } 
            if ($row["tipo_f"]=='N') {$row["tipo_f"]='No Docente'; } 
             if ($row["tipo_f"]=='A') {$row["tipo_f"]='Auxiliar'; } 
         }


        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
          
                $datos[]=$row ;          
         }
           echo json_encode($datos);
}

 if ($opc=='permisos_calendario2') {
     $fi=$_GET['fi'];
      $query = "SELECT *, id as tipo_tiempo, id as name_f, id as tipo_f  FROM  permisos where fi='$fi' and status='Aprobado' order  by fh";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $rut=$row["rut"];
        $query20 = "SELECT *  FROM  funcionarios where rut='$rut'";
        $result20 = mysqli_query($link, $query20); 
        while($row20 = mysqli_fetch_array($result20))
        {  $row["name_f"]=$row20["nombre"].' '.$row20["apellido_p"]; 
           $row["tipo_f"]=$row20["tipo_f"];
           if ($row["tipo_f"]=='D') {$row["tipo_f"]='Docente'; } 
            if ($row["tipo_f"]=='N') {$row["tipo_f"]='No Docente'; } 
             if ($row["tipo_f"]=='A') {$row["tipo_f"]='Auxiliar'; } 
         }


        $permiso=$row["tipo_permiso"];
        $query2 = "SELECT *  FROM  parametros_permiso where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["tipo_permiso"]=$row2["nombre"] ;  }

        $permiso=$row["motivo"];
        $query2 = "SELECT *  FROM  parametros_motivos where id='$permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $row["motivo"]=$row2["descripcion"] ;
           $row["tipo_tiempo"]=$row2["tipo_tiempo"] ;
           if ($row["tipo_tiempo"]=='DI') {
              $row["tipo_tiempo"]='Dias';
           }else{
              $row["tipo_tiempo"]='Horas';
           }
          }
          
                $datos[]=$row ;          
         }
           echo json_encode($datos);
}


 if ($opc=='permisos_calendario_dia') {
     $fecha=$_GET['fecha'];
      $dia=$_GET['dia'];
       $ob= new stdClass;
          $ob->docentes=0;
           $ob->nodocentes=0;
            $ob->auxiliares=0;
             $ob->dia=$dia;
             $ob->fecha=$fecha;
      $query = "SELECT *  FROM  permisos where fi='$fecha' and status='Aprobado'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $rut=$row["rut"];

        $query20 = "SELECT *  FROM  funcionarios where rut='$rut' limit 1";
        $result20 = mysqli_query($link, $query20); 
        while($row20 = mysqli_fetch_array($result20))
        {   if ($row20["tipo_f"]=='D') { $ob->docentes++; } 
            if ($row20["tipo_f"]=='N') {$ob->nodocentes++; } 
             if ($row20["tipo_f"]=='A') {$ob->auxiliares++; } 
         }
            
           
         }
            echo "[".json_encode($ob)."]";
           
}

?>