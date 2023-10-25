<!DOCTYPE html>
<html lang="es" ng-app="angular">
<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
	    <title>Solicitud de permiso</title>
	    <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap4.min.css">
        <link rel="stylesheet" href="css/estilos.css">
         <script src="js/jquery.js"></script>

</head>
<style>
  body{
    height: 500px;
  }
 p{
  font-size: 18px;
 }
 label{
   font-size: 17px;
 }
 td, th{
  border: 1px solid black;
 }
</style>
<body ng-controller="comedorcontroller">
  <div class="container text-center mt-5">
  <?php 
  include ("php/cone.php");
  $link = Conectarse(); 
  mysqli_set_charset($link, "utf8");
  $id=$_GET['id'];
  $name_funcionario='';
  $rut_funcionario='';
  $tipo_permiso='';
  $motivo='';
  $fecha_i='';
  $hora_i='';
  $fecha_f='';
  $hora_f='';
  $tiempo_permiso='';
  $observacion='';
  $tipo_f='';
  $tipo_tiempo='';
  $hr_disp='';
  $status_permiso='';
  $goze='';
  $n='';
  $fecha_solicitud='';
  $fecha_resp='';
   $query = "SELECT * FROM permisos WHERE id='$id'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
        {
          $rut_funcionario=$row["rut"];
          $tipo_permiso=$row["tipo_permiso"];
          $motivo=$row["motivo"];
          $fecha_i=$row["fi"];
          $hora_i=$row["hi"];
          $fecha_f=$row["ff"];
          $hora_f=$row["hf"];
          $tiempo_permiso=$row["ht"];
          $observacion=$row["descripcion"];
           $status_permiso=$row["status"];
           $goze=$row["descuento"];
           $n=$row["anno"].$row["n"];
           $fecha_solicitud=$row["fecha"];
           $fecha_resp=$row["fecha_resp"];
           if ($fecha_resp!='') {
               $fecha_resp= $fecha_resp.' ('.$status_permiso.')';
           }
           }
 
   $query = "SELECT * FROM funcionarios WHERE rut='$rut_funcionario'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
        {
         $name_funcionario=$row["nombre"].' '.$row["apellido_p"].' '.$row["apellido_m"];
         $tipo_f=$row["tipo_f"];
         $hr_disp=$row["hr_disp"];
          }
 
    $query2 = "SELECT *  FROM  parametros_permiso where id='$tipo_permiso'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $tipo_permiso=$row2["nombre"] ;  }
    
     $query2 = "SELECT *  FROM  parametros_motivos where id='$motivo'";
        $result2 = mysqli_query($link, $query2); 
        while($row2 = mysqli_fetch_array($result2))
        {  $motivo=$row2["descripcion"] ;
           $tipo_tiempo=$row2["tipo_tiempo"] ;
           if ($tipo_tiempo=='DI') {
              $tipo_tiempo='Dias';
           }else{
              $tipo_tiempo='Horas';
           }
         }

      if ($tipo_f=='N') {
        $tipo_f='No docente';
      }
      if ($tipo_f=='A') {
        $tipo_f='Auxiliar';
      }
      if ($tipo_f=='D') {
        $tipo_f='Docente';
      }
      $name_supervisor='';

 $query4 = "SELECT *  FROM  vinculaciones where id_funcionario='$rut_funcionario'";
       $result4 = mysqli_query($link, $query4); 
       while($row4 = mysqli_fetch_array($result4))
       {  $id_supervisor=$row4["id_supervisor"];
         
          $query2 = "SELECT *  FROM  supervisores where id='$id_supervisor'";
           $result2 = mysqli_query($link, $query2); 
           while($row2 = mysqli_fetch_array($result2))
           { $rut_supervisor=$row2["rut"];
              $name_supervisor=$name_supervisor. " ".$row2["nombre"]." - ";

             
            }
        }
 ?>
<div class="col-12 row text-center">
  <br><br><br><br>
  <h1 class="ml-5">Solicitud de permiso:</h1>
  <div class="col-9" style="border-bottom: 1px solid black; padding-bottom: 0px; ">
    <p class="text-left"><b>Nombre Colaborador: </b> <?php echo $name_funcionario ?> <br>
        <b>Nombre Supervisor: </b> <?php echo $name_supervisor ?> <br>
       <b>Rut: </b> <?php echo $rut_funcionario ?><br>
       <b>Tipo de funcionario: </b><?php echo $tipo_f ?><br>
       <b>Horas disponibles: </b><?php echo $hr_disp ?> Horas
    </p>
  </div>
  <div class="col-3" style="border-bottom: 1px solid black; padding-bottom: 0px; ">
     <img src='https://britishschool.cl/comedor_casino/img/logo.png' width='70%'><br>
     <b style="font-size: 26px;"><?php echo 'FOLIO: '.$n; ?> </b>
  </div>
  


<div class="col-12 my-3" style="border-bottom: 1px solid black; padding-bottom: 0px;">
   <p class="text-left" style="font-size: 18px;">Solicito permiso para ausentarme en el siguiente periodo:</p>
   <p class="text-left"> <b>Desde: </b> <?php echo $fecha_i.' - '.$hora_i ?> 
                         <b class="ml-5">Hasta: </b> <?php echo $fecha_f.' - '.$hora_f ?> 
                          <b class="ml-5">Tiempo total del permiso: </b> <?php echo $tiempo_permiso.' '.$tipo_tiempo ?> 
    </p>
</div> 

<div class="col-12">
  <p class="text-left"><b>Tipo de permiso: </b> <?php echo $tipo_permiso ?> <br>
       <b>Motivo: </b> <?php echo $motivo ?><br>
       <b>Observación: </b><?php echo $observacion ?><br>
        <b>Con Goce de sueldo: </b> <?php echo $goze ?><br><br><br>
       <b>Historial del permiso: </b>     </p>
         <table  class="table mt-1 mb-5">
               <thead class="cabecera">
               
              </thead>
              <tbody >
                <tr class="text-center" ng-repeat="x in list_permisos">
                  <td ><b>Fecha y hora de solicitud del permiso</b></td>
                  <td ><?php echo $fecha_solicitud ?> </td>
                   
                </tr>
                 <tr class="text-center" ng-repeat="x in list_permisos">
                  <td ><b>Fecha y hora de respuesta del permiso</b></td>
                  <td ><?php echo $fecha_resp ?></td>
                   
                </tr>
              </tbody>
           </table>
      </div>
</div> 



</div>
 
  
</div>
  

   <script type="text/javascript">
        setTimeout(function(){
        // window.print();
             },3000)
   </script>
</body>
</html>