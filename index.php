<!DOCTYPE html>
<html lang="es" ng-app="angular">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
      <title>Sistema de permisos - Inicio Sesión</title>
      <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap4.min.css">
        <link rel="stylesheet" href="css/estilos.css">
         <script src="js/jquery.js"></script>

</head>
<style>
  .modal-header{
  background: var(--main-rojo);
  color: white;
  font-weight: bold;
  border-radius: 0px 0px;
}
 body{
  padding-bottom: 200px;
 }
</style>
<body ng-controller="comedorcontroller">
  

   <div class="caja-sesion oculto entrada col-10 offset-1 col-md-6 offset-md-3 mt-5  pt-4 row" id="caja_inicio_sesion">
    <label class="col-12"><b>Usuario o RUT:</b></label>
    <input class="col-12" type="text" name="user" id="user">
    <label class="mt-3 col-12"><b>Contraseña:</b></label>
     <input class="col-12" type="password" name="pw" id="pw">
     <a href="" ng-click="btn_iniciar_sesion()" class="col-8 offset-2 btn btn-base mt-4 mb-4">INICIAR SESIÓN</a>
     <p class="ml-auto mt-2">Si aùn no tienes una cuenta <a href="" ng-click="btn_registrarse()"><b>Registrate Aqui</b></a></p>
     <p class="ml-auto mt-2">Si no recuerdas tu contraseña <a href="" ng-click="btn_reestablecer()"><b>Reestablecela Aqui</b></a></p>
   </div>

   
   <?php include ('elementos/pie.php'); ?>
 
  <div class="modal fade bd-example-modal-lg" id="registrarse" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registrarse:</h5>
      </div>
      <div class="modal-body pl-5 pr-5"> 
        <label class="col-12 mt-2"><b>Introduce tu rut:</b></label>
        <input class="col-12" type="text" name="input_rut" id="input_rut">
        <a href="#" class="btn btn-base-rojo col-12 mt-2" ng-click="verificar_rut()">Verificar RUT</a>
        <input class="col-12 mt-2" type="text" name="nombre_pila" id="nombre_pila" readonly>
        <label class="col-12 mt-2"><b>Introduce tu contraseña:</b></label>
        <input class="col-12" type="password" name="pw_new_user" id="pw_new_user" >
        <label class="col-12 mt-2"><b>Confirma tu contraseña:</b></label>
        <input class="col-12" type="password" name="confir_pw" id="confir_pw" >
       </div> 
      <div class="modal-footer ">
      <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button>
       <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2" ng-click="btn_registrarse_final()">Registrarse</a>
     </div>
        </div>
    </div>
  </div>

   <div class="modal fade bd-example-modal-lg" id="reestablecer" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registrarse:</h5>
      </div>
      <div class="modal-body pl-5 pr-5 text-center"> 
        <label class="col-12 mt-2"><b>Introduce tu usuario:</b></label>
        <input class="col-12" type="text" name="user_pw" id="user_pw">
        <a href="" ng-click="enviar_cod()" class="btn btn-base-rojo mt-3 col-12">Obtener codigo</a>
        <p  ng-hide="vista_no">{{mensaje}}</p>
        <p ng-show="vista_no">El usuario ingresado no existe en nuestra base de datos, por favor verifique la información ingresada, en caso contrario debe registrarse en la opción <a ng-click="btn_registrarse2()" href="">Regístrate aquí</a></p>
        <label class="col-12 mt-2"><b>Introduce el codigo enviado a tu correo:</b></label>
        <input class="col-12" type="text" name="codigo_resp" id="codigo_resp">
       </div> 
      <div class="modal-footer ">
      <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button>
       <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2" ng-click="reestablecer_user()">Reestablecer contraseña</a>
     </div>
        </div>
    </div>
  </div>


   <script src="js/bootstrap.min.js"></script>
   <script src="js/sweetalert.js"></script>
   <script src="js/angular.js"></script>
   <script src="js/iniciarsesion.js" ></script>
   <script src="https://kit.fontawesome.com/9f856f1951.js" crossorigin="anonymous"></script>
<!--        <script src="js/aos.js"></script>-->
     <script>  AOS.init();</script>
</body>
</html>