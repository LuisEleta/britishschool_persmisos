<?php
include ("../cone.php");
$link = Conectarse(); 
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
$fecha= date("d-m-Y");
$fh=date("Ymd");
$id_permiso=$_GET['id_permiso'];;
 
  $sql = "Update permisos Set tipo_permiso='$permiso', motivo='$motivo', descripcion='$observacion', fi='$fi', ff='$ff', hi='$hi', hf='$hf', ht='$ht', descuento='$descuento' Where id='$id_permiso';";
             if (mysqli_query($link, $sql)) {
           echo "El permiso ha sido editado con exito";
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