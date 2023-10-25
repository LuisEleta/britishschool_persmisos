 <?php
 session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");

$fh = date("Ymd"); 
$hora = date("Hi"); 
$fecha= date("d-m-Y").' - '. date("H:i:s");
//$fh='20221205';
     $query6 = "SELECT * FROM permisos where fh='$fh' and status='Por revisar'";
      $result6 = mysqli_query($link, $query6); 
        while($row6 = mysqli_fetch_array($result6))
        {  $id_permiso=$row6["id"];
            if ($row6["hi"]=='') {
                $sql = "Update permisos Set status='Rechazado', fecha_resp='$fecha' Where id='$id_permiso';";
                     if (mysqli_query($link, $sql)) { }
            }else{
             $hora_inicio=$row6["hi"];
             $hora_inicio=$hora_inicio[0].$hora_inicio[1].$hora_inicio[3].$hora_inicio[4];
             if ($hora_inicio<=$hora) {
                  $sql = "Update permisos Set status='Rechazado', fecha_resp='$fecha' Where id='$id_permiso';";
                     if (mysqli_query($link, $sql)) { }
             }
            }
        }


?>