<?php
 $user=$_GET['user'];
 $cod=$_GET['cod'];
 
 $rut='';
 $destino='';
 $i=0;
include ("php/cone.php");
$link = Conectarse(); 
 $query = "SELECT * FROM usuarios where user='$user'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       {
         $rut=$row["rut"];
             $query = "SELECT * FROM funcionarios where rut='$rut'";
              $result = mysqli_query($link, $query); 
              while($row = mysqli_fetch_array($result))
              {
                $destino=$row["correo"];
                $i++;
              }
       }

 if ($i==0) {
    echo "1";
 }else{
 $asunto='Codigo para reestablecer tu contraseña';
 $header='introduce el codigo para terminar con el proceso';
 $mensaje="Estimado usuario el codigo para la restauración de su contraseña es el siguiente: ".$cod;
        
         mail($destino, $asunto, $mensaje, $header);
         echo "Su codigo de verificación ha sido envia con exito al correo ".$destino;
         }
?>