<?php
include ("../cone.php");
$link = Conectarse(); 
$id_permiso=$_GET['id_permiso'];
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_name = $_FILES['name_archivo']['name'];
    echo $file_name;
    $new_name_file = null;
   if ($file_name != '' || $file_name != null) {
        $file_type = $_FILES['name_archivo']['type'];
        list($type, $extension) = explode('/', $file_type);
            $dir = '../../adjuntos/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_tmp_name = $_FILES['name_archivo']['tmp_name'];
             $new_name_file = $dir .time().$_FILES['name_archivo']['name'];
             $new_name_file2 = 'adjuntos/'.time().$_FILES['name_archivo']['name'];
             
 
            if(move_uploaded_file($_FILES['name_archivo']['tmp_name'] ,  $new_name_file)){

            }

         $sql = "Update permisos Set adjunto='$new_name_file2' Where id='$id_permiso';";
             if (mysqli_query($link, $sql)) { }

 
        
    }
   
} else {
    echo 'fail';
}

  ?>