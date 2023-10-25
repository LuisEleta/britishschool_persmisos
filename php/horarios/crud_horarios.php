 <?php
// session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");

$opc=$_GET['opc'];
 


 if ($opc=='horario_funcionario') {
     $rut=$_GET['rut'];
     $nombre='';
      $query = "SELECT *  FROM  funcionarios where rut='$rut'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $nombre=$row["horario"];
         if ($nombre=='Personal') {
            $nombre=$row["rut"];
         }
        }
        $query = "SELECT *  FROM  horarios where nombre='$nombre'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           
           echo json_encode($datos);
}
 

?>