<?php 
include ("../cone.php");
$link = Conectarse(); 
$id=$_GET['id'];
$rut='';
$id_permiso=$id;

$query4 = "SELECT *  FROM  permisos where id='$id'";
       $result4 = mysqli_query($link, $query4); 
       while($row4 = mysqli_fetch_array($result4))
       {  $rut=$row4["rut"];     }

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
  $subject = "Se ha aprobado nuevo permiso";
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
         Se ha aprobado un permiso en el sistema.
      </div>
      <img src='https://britishschool.cl/comedor_casino/img/logo.png' width='100px'>
      <div class='mensaje'>
        <p class='parrafo'>Si quieres descargar el PDF de este permiso, haz click en el siguiente link.</p>
        <a href='https://britishschool.cl/permisos/pdf.php?id=$id_permiso'>Descargar PDF</a>
        <br><br>
         
        
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
    echo "Se envio un correo a ".$correo.'<br>';
  } else {
   echo "hubo un error";
  } 

  }

 ?>