 <?php
 session_start();
 include ("../cone.php");
$link = Conectarse(); 
mysqli_set_charset($link, "utf8");

$opc=$_GET['opc'];
 
if ($opc=='resetear_foto') {
      $rut=$_GET['rut'];
         $sql = "Update funcionarios Set foto='img/foto_user.png' Where rut='$rut';";
             if (mysqli_query($link, $sql)) { }
         $sql = "Update alumno Set foto='img/foto_user.png' Where rut='$rut';";
             if (mysqli_query($link, $sql)) { }
}
 

if ($opc=='cierredeldia') {
      $id=$_GET['fh'];
       $query = "SELECT *  FROM  cierres_cacino where fh='$id'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
}

if ($opc=='listado_cierres') {
      $id=$_GET['fh'];
       $query = "SELECT *  FROM  cierres_cacino order by fh desc";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
           echo json_encode($datos);
}

?>