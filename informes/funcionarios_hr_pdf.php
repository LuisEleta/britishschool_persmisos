<?php 
//header('Content-Type: application/xls');
//header('Content-Disposition: attachment; filename=funcionarios_por_horas.xls');
include ("../php/cone.php");
$link = Conectarse(); 
$data='';
 $hoy = date("d-m-y");
 mysqli_set_charset($link, "utf8");
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
         $datos[]=$row ;

       }

 
 ?>



<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='../css/normalize.css'>
      </head>

  <style>
    .table{
      text-align: center;
      align-items: center;
      width: 720px;
      border-collapse: collapse;
    }
  tr{
    text-align: center;
    margin-top: 15px;
    margin-bottom: 15px;

     }
     div{ text-align: center; }
     .band{
      border: 1px solid black;
       margin-left: 0px;
      margin-left: 0px;
      padding-right: 0px;
      padding-left: 0px;
     }
     .row{
      text-align: center;
     }
</style>

<body>
  <div class='container-fluid text-center'>
     <div class="row">
        <div class=""> <h3>Listado  de Funcionario y horas disponibles</h3>
    <p class="text-right">Reporte generado por el sistema de gestión de permisos del colegio Británico el <?php  echo $hoy;?> a las <?php echo date("H:i:s") ?> Horas</p></div>
    </div>
    </div>
    <table  class='table' style="width: 80vw; margin-left: 10vw;">
               <thead class='cabecera'>
                <tr class='text-center'>
                 <th scope="col" style="width: 120px;">RUT </th>
                 <th scope="col" style="width: 350px;">NOMBRE </th>   
                    <th scope="col">LEG</th>
                 <th scope="col">HRS LAB</th>              
                 <th scope="col">HRS PERMISO </th>
                 <th scope="col">HRS UTILIZADAS </th>
                 <th scope="col">HR DISP </th>
                 <th scope="col">APRO</th>
                 <th scope="col">RECHA </th>
                </tr>
              </thead>
              <tbody >
                <?php foreach ($datos as $almuerzo) {
                ?>
                <tr>            
                  <td class="band"><?php echo $almuerzo["rut"]; ?> </td>
                  <td class="band"><?php echo $almuerzo["nombre"].' '.$almuerzo["apellido_p"]; ?> </td>
                  <td class="band"><?php echo $almuerzo["hr_leg"]; ?> </td>
                  <td class="band"><?php echo $almuerzo["hr_lab"]; ?> </td>
                  <td class="band"><?php echo $almuerzo["hr_contrato"]; ?> </td>
                  <td class="band"><?php echo $almuerzo["hr_utilizadas"]; ?> </td>
                  <td class="band"><?php echo $almuerzo["hr_disp"]; ?> </td>
                   <td class="band"><?php echo $almuerzo["apro"]; ?> </td>
                   <td class="band"><?php echo $almuerzo["noapro"]; ?> </td>
                 </tr>
                
              <?php }?>
              
              </tbody>
           </table>
  </div>
 
</body>
  
<script>
    setTimeout(function(){
             window.print();
             },2000)

</script>
</html>
