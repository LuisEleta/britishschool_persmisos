 <?php
include ("../cone.php");
$link = Conectarse(); 
$opc=$_GET['opc'];
mysqli_set_charset($link, "utf8");


if ($opc=='predeterminado') {
      $query = "SELECT id, user, permiso, rut, user as nombre FROM usuarios";
        $result = mysqli_query($link, $query); 
        while($row = mysqli_fetch_array($result))
        { 
        $i=0;
        $rut=$row["rut"];
        $query2 = "SELECT * FROM alumno where rut='$rut'";
       $result2 = mysqli_query($link, $query2); 
       while($row2 = mysqli_fetch_array($result2))
        {
         $i++;
          $row["nombre"]=$row2["nombre"]." ".$row2["apellidopaterno"];
        }
        if ($i==0) {
          $query2 = "SELECT * FROM funcionarios where rut='$rut'";
          $result2 = mysqli_query($link, $query2); 
          while($row2 = mysqli_fetch_array($result2))
        {
         $i++;
          $row["nombre"]=$row2["nombre"]." ".$row2["apellido_p"];
        }
        } 
            $datos[]=$row ;
        }
         echo json_encode($datos);   
}

if ($opc=='personalizado') {
 $tipo=$_GET['tipo'];
     $query = "SELECT id, user, permiso, rut FROM usuarios where permiso='$tipo'";
        $result = mysqli_query($link, $query); 
        while($row = mysqli_fetch_array($result))
        { $datos[]=$row ;}
         echo json_encode($datos);
      
}

if ($opc=='funcionario') {
 $rut=$_GET['rut'];
 
     $query = "SELECT * FROM funcionarios where rut='$rut'";
        $result = mysqli_query($link, $query); 
        while($row = mysqli_fetch_array($result))
        { $datos[]=$row ;
           
        }
         echo json_encode($datos);   
}



if ($opc=='alunno_and_funcionario') {
    $i=0;
 $rut=$_GET['rut'];
 $id_padre='';
$ob= new stdClass;
$ob->name="";
$ob->tipo='';
$ob->foto='';

        $query = "SELECT * FROM funcionarios where rut='$rut'";
        $result = mysqli_query($link, $query); 
        while($row = mysqli_fetch_array($result))
        { $i++;
          $datos[]=$row ;
          $ob->name=$row['nombre']." ".$row['apellido_p'];
           $ob->tipo='Funcionario';
            
        }

             echo "[".json_encode($ob, JSON_UNESCAPED_UNICODE)."]";
}


?>