 <?php 
 include ("../cone.php");
$link = Conectarse(); 
$i=0;
$pwold=$_GET['pwold'];
$pwnew=$_GET['pwnew'];
$user= $_GET['user'];

 $query = "SELECT * FROM usuarios WHERE user='$user' and pw='$pwold'";
     $result = mysqli_query($link, $query); 
      while($row = mysqli_fetch_array($result))
      { $i++;    }
     
     if ($i>0) {
       $sql = "Update usuarios Set pw='$pwnew'  Where user='$user';";
       if (mysqli_query($link, $sql)) { 
         echo "Su contraseña fue actualizada correctamente";
        }
      }else{
        echo "Su contraseña actual no coincide";
      }
?>