<?php 
header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename=funcionarios_por_horas.xls');
include ("../php/cone.php");
$link = Conectarse(); 
$data='';
// mysqli_set_charset($link, "utf8");
       $query = "SELECT *, id as foto, id as supe, id as apro , id as noapro  FROM  funcionarios where status='1'";
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
         }
         if ($row["tipo_f"]=='A') {
            $row["tipo_f"]='Auxiliar';
         }
         if ($row["tipo_f"]=='D') {
            $row["tipo_f"]='Docente';
         }
        $data.= "<tr >
                  <td >".$row["rut"]." </td>
                  <td >".$row["nombre"]." ".$row["apellido_p"]."</td>
                  <td >".$row["hr_leg"]."</td>
                  <td >".$row["hr_lab"]."</td>
                  <td >".$row["hr_contrato"]."</td>
                  <td >".$row["hr_utilizadas"]."</td>
                  <td >".$row["hr_disp"]." Hrs</td>
                  <td >".$row["apro"]."</td>
                  <td >".$row["noapro"]."</td>
                 
                </tr>";

       }

 
 ?>



 <table>
               <thead>
                <tr  >
                  <th>RUT</th>
                 <th>NOMBRE</th>    
                 <th >LEG</th>
                 <th >HRS LAB</th>             
                 <th>HRS PERMISO</th>
                 <th >HRS UTILIZADAS</th>
                 <th>HR DISP.</th>
                 <th >APROBADOS</th>
                 <th >RECHAZADOS</th>
                </tr>
              </thead>
              <tbody >
                <?php  echo $data; ?>
              </tbody>
           </table>
