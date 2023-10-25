 <?php
 session_start();
 include ("../cone.php");
$link = Conectarse(); 
$i=0;
$opc=$_GET['opc'];




if ($opc=='C') {
  $user=$_GET['user'];
  $tipo=$_GET['tipo'];
  $pw=$_GET['pw'];
  $rut=$_GET['rut'];
  $name_user='';
       $query = "SELECT * FROM usuarios where rut='$rut' and permiso='$tipo'  ";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $i++;
        $name_user=$row["user"];
       }
     if ($i==0) {
      $sql = "INSERT INTO usuarios( user,pw,permiso,rut)
         VALUES ('$user','$pw','$tipo','$rut');";
       if (mysqli_query($link, $sql)) {
         $query = "SELECT id, user, permiso, rut FROM usuarios";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
         echo json_encode($datos);
      }
     }else{
        echo "Ya existe un usuario (".$name_user.") con este rut asociado y el mismo permiso en la base de datos";
     }

}
if ($opc=='U') {
  $id=$_GET['id'];
  $user=$_GET['user'];
  $tipo=$_GET['tipo'];
  $sql = "Update usuarios Set user='$user', permiso='$tipo'  Where id='$id';";
   if (mysqli_query($link, $sql)) { 
       $query = "SELECT id, user, permiso, rut FROM usuarios";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
         echo json_encode($datos);
      }
}

if ($opc=='Reset') {
  $id=$_GET['id'];
  $sql = "Update usuarios Set pw='12345'  Where id='$id';";
   if (mysqli_query($link, $sql)) { 
       $query = "SELECT id, user, permiso, rut FROM usuarios";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
         echo json_encode($datos);
      }
}

if ($opc=='Reset_user') {
  $id=$_GET['id'];
  $sql = "Update usuarios Set pw='12345'  Where user='$id';";
   if (mysqli_query($link, $sql)) { 
       $query = "SELECT id, user, permiso, rut FROM usuarios";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
         echo json_encode($datos);
      }
}

if ($opc=='D') {
  $id=$_GET['id'];
    $sql = "DELETE FROM usuarios WHERE id='$id'";
   if (mysqli_query($link, $sql)) { 
      $query = "SELECT id, user, permiso, rut FROM usuarios";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $datos[]=$row ;}
         echo json_encode($datos);
      }
}


if ($opc=='C_alumno') {
  $user=$_GET['user'];
  $tipo=$_GET['tipo'];
  $pw=$_GET['pw'];
    $query = "SELECT * FROM usuarios where user='$user'";
       $result = mysqli_query($link, $query); 
       while($row = mysqli_fetch_array($result))
       { $i++;}
     if ($i==0) {
      $sql = "INSERT INTO usuarios( user,pw,permiso,rut)
         VALUES ('$user','$pw','$tipo','$user');";
       if (mysqli_query($link, $sql)) {
      echo "Su usuario fue creado con exito, ahora puede ingresar con su rut y contraseña";
      }
     }else{
        echo "Ya existe este usuario en la base de datos, por favor comuniquese con administración para solucionar su inconveniente";  
     }

}


?>