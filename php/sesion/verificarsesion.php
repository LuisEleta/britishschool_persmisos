<?php
$ob= new stdClass;
$ob->user="0";
$ob->permiso="0";
$ob->rut="0";
session_start();
 
  if (isset($_SESSION['S_IDUSUARIO'])) { 
	$ob->user=	$_SESSION['S_IDUSUARIO'];
	$ob->permiso=$_SESSION['S_PERMISO'];	
	$ob->rut=$_SESSION['S_RUT'];         
   } 
	
	echo "[".json_encode($ob)."]";
  ?>