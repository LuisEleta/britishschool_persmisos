<?php
include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");
$permiso=$_GET['permiso'];
$motivo=$_GET['motivo'];
$fi=$_GET['fi'];
$ff=$_GET['ff'];
$hi=$_GET['hi'];
$hf=$_GET['hf'];
$ht=$_GET['ht'];
$descuento=$_GET['descuento'];

$observacion=$_GET['observacion'];
$rut=$_GET['rut'];
$fecha= date("d-m-Y").' - '. date("H:i:s");
$fh=$fi[0].$fi[1].$fi[2].$fi[3].$fi[5].$fi[6].$fi[8].$fi[9];
$id_permiso='';
$anno=date("Y");
$n=0;
 

 $query3 = "SELECT *  FROM  permisos";
 $result3 = mysqli_query($link, $query3); 
 while($row3 = mysqli_fetch_array($result3))
 { $n=$row3["n"];}
 $n++;
  if ($n<10) {$n='000'.$n;  }
   if ($n<100 && $n>9) {$n='00'.$n;  }
    if ($n>99 && $n<1000 ) {$n='0'.$n;  }
    $creado='USER';
 $sql = "INSERT INTO permisos(rut, tipo_permiso,motivo,descripcion, fi, ff, hi, hf,ht, fecha, fh, status, vista, descuento, anno, n,creado)
         VALUES ('$rut','$permiso','$motivo','$observacion','$fi','$ff','$hi','$hf','$ht','$fecha','$fh', 'Por revisar', 'Por revisar','$descuento','$anno', '$n','$creado');";
         echo 'Su permiso se ha creado correctamente';
       if (mysqli_query($link, $sql)) {
        $query = "SELECT *  FROM  permisos where rut='$rut'";
         $result = mysqli_query($link, $query); 
         while($row = mysqli_fetch_array($result))
         {
          $id_permiso=$row["id"] ;

         }
$name_supervisor='';
$name_funcionario='';
//---------------------------------------------------------------------------------------------------------------------------------------------
 $query4 = "SELECT *  FROM  vinculaciones where id_funcionario='$rut'";
       $result4 = mysqli_query($link, $query4); 
       while($row4 = mysqli_fetch_array($result4))
       {  $id_supervisor=$row4["id_supervisor"];
         
          $query2 = "SELECT *  FROM  supervisores where id='$id_supervisor'";
           $result2 = mysqli_query($link, $query2); 
           while($row2 = mysqli_fetch_array($result2))
           { $rut_supervisor=$row2["rut"];
              $name_supervisor=$row2["nombre"];

            
               $query3 = "SELECT *  FROM  funcionarios where rut='$rut_supervisor'";
               $result3 = mysqli_query($link, $query3); 
               while($row3 = mysqli_fetch_array($result3))
               { $correo=$row3["correo"];
               }
            }
 $query44 = "SELECT *  FROM  funcionarios where rut='$rut'";
       $result44 = mysqli_query($link, $query44); 
       while($row44 = mysqli_fetch_array($result44))
       {
          $name_funcionario=$row44["nombre"].' '.$row3["apellido_p"];
        }

       

  ini_set( 'display_errors', 1 );
  error_reporting( E_ALL );

  // de quien es el mensaje
  $from = 'noreply@britishschool.cl';
  // para quien es el mensaje
  $to = $correo;
  // asunto del mensaje
  $subject = "Se ha solicitado un nuevo permiso - (".$name_funcionario.")- Folio: ".$n;
  // cual es el mensaje
  $mensaje = "

<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Mensaje</title>
  <script src='js/JsBarcode.all.min.js'></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .container {
      max-width: 1000px;
      width: 90%;
      margin: 0 auto;
    }
    .bg-dark {
      background: white;
      margin-top: 40px;
      padding: 20px 0;
    }
    .alert {
      font-size: 1.5em;
      position: relative;
      padding: .75rem 1.25rem;

      border: 1px solid transparent;
      border-radius: .25rem;
    }
    .alert-primary {
      color: white;
      background-color: #1c4365;
      border-color: #b8daff;
      text-align: center;
    }

    .img-fluid {
      max-width: 100%;
      height: auto;
    }

    .mensaje {
      width: 100%;
      font-size: 20px;
      align-content: center;
      text-align: center;
     margin-bottom: 30px;
      color: #eee;
    }

    .texto {
      margin-top: 20px;
    }

    .footer {
      width: 100%;
      background: #1c4365;
      text-align: center;
      color: #ddd;
      padding: 10px;
      font-size: 14px;
    }
    .parrafo{
      width: 80%;
      margin-left: 10%;
      color: #1c4365;
      margin-bottom: 20px;
      font-size: 25px;
      font-weight: initial;

    }

    .footer span {
      text-decoration: underline;
      text-align: center;
      margin-top: 25px;
    }
    .caja-link{
      text-align: center;
      margin-bottom: 20px;
      color: #c74b53;
    }
    a{
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
      color: #c74b53;
      text-decoration: none;
    }
  </style>
 
</head>
<body>
  <div class='container'>
    <div class='bg-dark'>
      <div class='alert alert-primary'>
          Se ha hecho una nueva solicitud de permisos en el sistema <br>
          Funcionario: $name_funcionario <br>
          Supervisor: $name_supervisor
      </div>
      <img src='https://britishschool.cl/comedor_casino/img/logo.png' width='100px'>
      <div class='mensaje'>

        <p class='parrafo'>Entra al sistema y reponde a este permiso con el siguiente link.</p>
        <p class='parrafo'>La fecha límite para responder a este permiso es el $fi - $hi.</p>
        <a href='https://britishschool.cl/permisos/'>Responder permiso</a>
        <br><br>
        <p class='parrafo'>Si quieres descargar el PDF de este permiso, haz click en el siguiente link.</p>
        <a href='https://britishschool.cl/permisos/pdf.php?id=$id_permiso'>Descargar PDF</a>
        <br>
      </div>
      
      
      <div class='footer'>
        Saludos - British School
      </div>
    </div>
  </div>

</body>
</html>
  ";

  //para el envío en formato HTML 
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  // More headers
  $headers .= "From: <noreply@britishschool.cl>" . "\r\n";
  $headers .= "Cc: $to" . "\r\n";

  // esta funcion ejecuta el correo PHP
  $sendMail = mail($to, $subject, $mensaje, $headers);

/*
  if( $sendMail ) {
   // echo "Se envio un correo a ".$correo.;
  } else {
   echo "hubo un error";
  } */

  }
  $to='inscripciones@britishschool.cl';
   $sendMail = mail($to, $subject, $mensaje, $headers);

  if( $sendMail ) {
  
  }
//---------------------------------------------------------------------------------------------------------------------------------------------
 $query4 = "SELECT *  FROM  funcionarios where rut='$rut'";
       $result4 = mysqli_query($link, $query4); 
       while($row4 = mysqli_fetch_array($result4))
       {  $correo=$row4["correo"];
         
  
  ini_set( 'display_errors', 1 );
  error_reporting( E_ALL );

  // de quien es el mensaje
  $from = 'noreply@britishschool.cl';
  // para quien es el mensaje
  $to = $correo;
  // asunto del mensaje
  $subject = "Haz solicitado un nuevo permiso (".$name_funcionario.")";
  // cual es el mensaje
  $mensaje = "

<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Mensaje</title>
  <script src='js/JsBarcode.all.min.js'></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .container {
      max-width: 1000px;
      width: 90%;
      margin: 0 auto;
    }
    .bg-dark {
      background: white;
      margin-top: 40px;
      padding: 20px 0;
    }
    .alert {
      font-size: 1.5em;
      position: relative;
      padding: .75rem 1.25rem;

      border: 1px solid transparent;
      border-radius: .25rem;
    }
    .alert-primary {
      color: white;
      background-color: #1c4365;
      border-color: #b8daff;
      text-align: center;
    }

    .img-fluid {
      max-width: 100%;
      height: auto;
    }

    .mensaje {
      width: 100%;
      font-size: 20px;
      align-content: center;
      text-align: center;
     margin-bottom: 30px;
      color: #eee;
    }

    .texto {
      margin-top: 20px;
    }

    .footer {
      width: 100%;
      background: #1c4365;
      text-align: center;
      color: #ddd;
      padding: 10px;
      font-size: 14px;
    }
    .parrafo{
      width: 80%;
      margin-left: 10%;
      color: #1c4365;
      margin-bottom: 20px;
      font-size: 25px;
      font-weight: initial;

    }

    .footer span {
      text-decoration: underline;
      text-align: center;
      margin-top: 25px;
    }
    .caja-link{
      text-align: center;
      margin-bottom: 20px;
      color: #c74b53;
    }
    a{
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
      color: #c74b53;
      text-decoration: none;
    }
  </style>
 
</head>
<body>
  <div class='container'>
    <div class='bg-dark'>
      <div class='alert alert-primary'>
          Haz hecho una nueva solicitud de permisos en el sistema<br>
          Funcionario: $name_funcionario <br>
          Supervisor: $name_supervisor
      </div>
      <img src='https://britishschool.cl/comedor_casino/img/logo.png' width='100px'>
      <div class='mensaje'>
        <p class='parrafo'>Si quieres descargar el PDF de este permiso, haz click en el siguiente link.</p>
        <a href='https://britishschool.cl/permisos/pdf.php?id=$id_permiso'>Descargar PDF</a>
        <br><br>
         <p class='parrafo'>Cuando el supervisor responda a tu permiso te estaremos avisando por este medio.</p>
        <br>
      </div>
      
      
      <div class='footer'>
        Saludos - British School
      </div>
    </div>
  </div>

</body>
</html>
  ";

  //para el envío en formato HTML 
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  // More headers
  $headers .= "From: <noreply@britishschool.cl>" . "\r\n";
  $headers .= "Cc: $to" . "\r\n";

  // esta funcion ejecuta el correo PHP
  $sendMail = mail($to, $subject, $mensaje, $headers);

  if( $sendMail ) {
   // echo "Se envio un correo a ".$correo.'<br>';
  } else {
   echo "hubo un error";
  } 

  }
//-------------------------------------------------------------------------------------------------------------------------------------------------

         
        }




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_name = $_FILES['acta']['name'];
    $new_name_file = null;
   if ($file_name != '' || $file_name != null) {
        $file_type = $_FILES['acta']['type'];
        list($type, $extension) = explode('/', $file_type);
            $dir = '../../adjuntos/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_tmp_name = $_FILES['acta']['tmp_name'];
             $new_name_file = $dir .time().$_FILES['acta']['name'];
             $new_name_file2 = 'adjuntos/'.time().$_FILES['acta']['name'];
            if(move_uploaded_file($_FILES['acta']['tmp_name'] ,  $new_name_file)){

            }

         $sql = "Update permisos Set adjunto='$new_name_file2' Where id='$id_permiso';";
             if (mysqli_query($link, $sql)) { }

 
        
    }
   
} else {
    echo 'fail';
}

  ?>