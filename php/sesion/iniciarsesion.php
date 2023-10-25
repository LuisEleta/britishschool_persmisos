<?php
$user=$_GET['user'];
$pw=$_GET['pw'];
     $ob= new stdClass;
          $ob->user=0;
        $ob->permiso='0';
        $ob->rut=0;
 include ("../cone.php");
$i=0;
$link = Conectarse();
    $query = "SELECT * FROM usuarios WHERE user='$user' and pw='$pw'";
     $result = mysqli_query($link, $query); 
      while($row = mysqli_fetch_array($result))
      {
        $i++;
        $datos[]=$row ;
        $ob->user=$user;
        $ob->permiso=$row["permiso"];
        $ob->rut=$row["rut"];
       }
       if ($i>0) {
        session_start();
          $_SESSION['S_IDUSUARIO']=$user;
          $_SESSION['S_PERMISO']=$ob->permiso;     
          $_SESSION['S_RUT']=$ob->rut;          
       }
        echo "[".json_encode($ob)."]";
?>

