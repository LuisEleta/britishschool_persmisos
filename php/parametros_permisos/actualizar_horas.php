 <?php
 session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");


      $query = "SELECT *  FROM  funcionarios";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
        $rut=$row["rut"];
        $hr=0;
        $min=0;
        $legal=0;
        $hr_no_lab=0;
        $min_no_lab=0;
         $hr_lab=0;
        $min_lab=0;
      //  echo $row["nombre"].' '.$rut.' -';
                 //$query2 = "SELECT *  FROM  permisos where rut='$rut' and status='Aprobado' and fi=ff and descuento='SI' and tipo_permiso>1";
                   $query2 = "SELECT *  FROM  permisos where rut='$rut' and status='Aprobado' and fi=ff and descuento='SI' and tipo_permiso<3";
                   $result2 = mysqli_query($link, $query2); 
                   while($row2 = mysqli_fetch_array($result2))
                   {
                    $horas=$row2["ht"];
                    if (strlen($horas)>1) {
                        $hrs=$horas[0].$horas[1];
                        $minutos=$horas[3].$horas[4];
                        $hr=$hr+$hrs;
                        $min=$min+$minutos;
                        if ($row2["tipo_permiso"]=='2') {
                            $hr_no_lab=$hr_no_lab+$hrs;
                            $min_no_lab=$min_no_lab+$minutos;
                        }
                         if ($row2["tipo_permiso"]=='3') {
                            $hr_lab=$hr_lab+$hrs;
                            $min_lab=$min_lab+$minutos;
                        }
                    }
                    if (strlen($horas)<3 && strlen($horas)>0 && $row2["tipo_permiso"]=='1') {
                           $legal=$legal+$horas;
                    }
                   
              //   echo $row2["id"].' - ';
                   }
//-------------------------------------------------------------------------------
         $resto_min= $min_no_lab % 60;
         $horas_mas= $min_no_lab /60;
         $horas_mas=number_format($horas_mas, 0, ',', ' ');
         $hr_no_lab=$hr_no_lab+$horas_mas;
         if ($hr_no_lab<10) {$hr_no_lab='0'.$hr_no_lab; }
          if ($resto_min<10) {$resto_min='0'.$resto_min; }
         $hr_t_no_lab=$hr_no_lab.':'.$resto_min;
//-------------------------------------------------------------------------------
         $resto_min= $min_lab % 60;
         $horas_mas= $min_lab /60;
         $horas_mas=number_format($horas_mas, 0, ',', ' ');
         $hr_lab=$hr_lab+$horas_mas;
         if ($hr_lab<10) {$hr_lab='0'.$hr_lab; }
          if ($resto_min<10) {$resto_min='0'.$resto_min; }
         $hr_t_lab=$hr_lab.':'.$resto_min;

//--------------------------------------------------------------------------------        
         $resto_min= $min % 60;
         $horas_mas= $min /60;

         $horas_mas=number_format($horas_mas, 0, ',', ' ');
         $hr=$hr+$horas_mas;

         if ($hr<10) {  $hr='0'.$hr;  }
         if ($resto_min<10) {  $resto_min='0'.$resto_min;  }
         $hr_semanales=$row["hr_semanal"];

          if ($hr_semanales>37) {
              $hr_anno=27;
             }else{
              $hr_anno=(($hr_semanales/38)*27);
             }
          
           $hr_anno=ceil($hr_anno);

           $hr_anno=$hr_anno.':00';
           $hr_utilizadas= $hr.':'.$resto_min;
           $hr_disponibles='00:00';
           if ($hr<$hr_anno) {
             $hrs_disp=$hr_anno-$hr;
             $min_disp=60-$resto_min;
             if ($min_disp<60) { 
                 // $min_disp=$min_disp+60; 
                  $hrs_disp--; 
               if ($min_disp<10) {  $min_disp='0'.$min_disp;  }  
             }else{
                $min_disp='00';
             }

               if ($hrs_disp<10) {  $hrs_disp='0'.$hrs_disp;  }
               $hr_disponibles=$hrs_disp.':'.$min_disp;
           }

         $sql = "Update funcionarios Set hr_contrato='$hr_anno', hr_utilizadas='$hr_utilizadas', hr_disp='$hr_disponibles', hr_leg='$legal', hr_no_lab='$hr_t_no_lab', hr_lab='$hr_t_lab' Where rut ='$rut';";
        if (mysqli_query($link, $sql)) {}

           // echo  'Horas contrato: '.$hr_anno.' - horas utilizadas: '.$hr_utilizadas.' - horas disponibles: '.$hr_disponibles. "<br>";

       }
        

?>