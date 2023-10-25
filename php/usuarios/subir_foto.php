<?php
include ("../cone.php");
$link = Conectarse(); 
    $cui=$_GET['rut'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $file_name = $_FILES['acta']['name'];

    $new_name_file = null;

    if ($file_name != '' || $file_name != null) {
        $file_type = $_FILES['acta']['type'];
        list($type, $extension) = explode('/', $file_type);
       
            $dir = '../../img/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_tmp_name = $_FILES['acta']['tmp_name'];
             $new_name_file = $dir .time().$cui.$_FILES['acta']['name'];
             $new_name_file2 = 'img/'.time().$cui.$_FILES['acta']['name'];
            if(move_uploaded_file($_FILES['acta']['tmp_name'] ,  $new_name_file)){

            }

         $sql = "Update funcionarios Set foto='$new_name_file2' Where rut='$cui';";
             if (mysqli_query($link, $sql)) { }

         $sql = "Update alumno Set foto='$new_name_file2' Where rut='$cui';";
             if (mysqli_query($link, $sql)) { }
 
        
    }
   
} else {
    echo 'fail';
}

  ?>