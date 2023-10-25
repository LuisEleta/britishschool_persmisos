<!DOCTYPE html>
<html lang="es" ng-app="angular">
<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
	    <title>Cuenta - Funcionario</title>
	    <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap4.min.css">
        <link rel="stylesheet" href="css/estilos.css">
         <script src="js/jquery.js"></script> 

</head>
<style>
  .caja-historia{
    border-radius: 10px 10px;
    border: 1px solid var(--azul-oscuro);
  }
  .modal-header{
  background: var(--main-rojo);
  color: white;
  font-weight: bold;
  border-radius: 0px 0px;
}
.btn-base{
 border-radius: 5px 5px;
}
.Suspendido{
  display: none;
}
.Entregado{
  display: none;
}
.nav-item, .link-menu-dere{
  font-size: 13px;
}
 
.contenedorQR {
  display: flex;
  justify-content: center;
  padding: 10px 0;
}
body{
  padding-bottom: 220px;
}
.nav-link{
  font-weight: normal;
}
.Aprobado{
  background: rgba(103, 220, 5, 0.2);
}
.revisar{
  background: rgba(250, 237, 36, 0.2);
}
.Rechazado{
   background: rgba(245, 81, 48, 0.2);
}
.Anulado{
  background: rgba(183, 183, 183, 0.3);
}
.btn_Aprobado, .btn_Rechazado, .btn_Anulado{
  display: none;
}
.vacio{border: 1px solid red;}
</style>
<body ng-controller="comedorcontroller">
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand mr-5" href="index.php"><img src="img/logo.png" height="40px"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link ml-2 mr-2" ng-click="div_inicio()" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" href="#">Inicio</a>
      <a class="nav-item nav-link ml-2 mr-2" ng-click="div_crear_permiso()" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" href="#">Solicitar permiso</a>
      <a class="nav-item nav-link ml-2 mr-2" ng-click="div_hitorial()" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" href="#">Historial de permisos</a>
       <a class="nav-item nav-link ml-2 mr-2 oculto" id="opc_responder" ng-click="div_responder()" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" href="#">Permisos para responder</a>
         <a class="nav-item nav-link ml-2 mr-2 oculto" id="opc_subalternos" ng-click="div_subalternos()" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" href="#">Colaboradores</a>
 
        <a class="nav-item nav-link ml-2 mr-2" ng-click="cambiar_pw()" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" href="#">Cambio de contraseña</a>
    </div>
    <div class="ml-auto mr-5 mt-3 mt-lg-1 mb-3 mb-lg-1 row">
      <a href="" ng-click="btn_sesion()" class="link-menu-dere ml-2"> <span id="texto_sesion"></span></a>
      <a href="" ng-click="btn_cerrar_sesion()" class="link-menu-dere ml-4 mr-4"><span id="texto_cerrar_sesion"></span></a>
    </div>
  </div>
</nav>

<div class="container-fluid mt-3">

<div class="caja_central entrada oculto" id="div_inicio">
  <br>
    <div class="col-12 caja-historia text-center p-2" ng-repeat="x in datos_funcionario">
       <p style="line-height: 20px;" ><span style="font-weight: bold; font-size: 30px; color: var(--main-color);">{{x.nombre}}</span> <br> <span style="font-size: 20px"> {{x.apellido_p}} {{x.apellido_m}}</span><br>{{x.rut}}</p>
        <p style="line-height: 30px;" >
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Horas Disponibles:</span> <br> <span style="font-size: 20px"> {{x.hr_disp}} Horas</span>
          <br>
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Permisos por revisar:</span> <br> <span style="font-size: 20px"> {{x.pr}}</span>
          <br>
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Permisos Aprobados:</span> <br> <span style="font-size: 20px"> {{x.a}}</span>
          <br>
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Permisos Rechazados:</span> <br> <span style="font-size: 20px"> {{x.r}}</span>

        </p>
    </div>
  </div>

<div class="caja_central entrada oculto" id="div_crear_permiso">
  <div class="col-12 col-lg-6 offset-lg-3">
      <label class="px-0 mt-3">Tipo de permiso</label>
     <select  class="col-12 input-formu" type="text" id="tipo_permiso">
       <option value="0">Selecciona un tipo de permiso</option>
       <option ng-repeat="x in list_permisos" value="{{x.id}}">{{x.nombre}}</option>
     </select>
     <label class="px-0 mt-3">Motivo del permiso</label>
     <select  class="col-12 input-formu" type="text" id="motivo">
        <option value="0">Selecciona un motivo</option>
        <option ng-repeat="x in list_motivos" value="{{x.id}}">{{x.descripcion}}</option>
     </select>
     <p class="mb-0 mx-2" style="color: #737373"> {{leyenda}}</p>
     <label class="entrada px-0 mt-3 oculto">Total de horas recomendadas´para este permiso:</label>
     <input class="entrada col-12 input-formu oculto" type="time" id="ht" readonly>
     <label class="px-0 mt-3">Fecha de inicio</label>
     <input class="col-12 input-formu" type="date" id="fi">
      <p class="mb-0 mx-2" style="color: #737373"> {{leyendafi}}</p>
      <label class="my-3 hrs oculto" style="font-size: 16px;"><input type="checkbox" id="cbox1" value="t_j"> Toda la jornada</label><br>
     <label class="entrada hrs oculto px-0 mt-3">Hora de inicio</label>
     <input class="entrada hrs oculto col-12 input-formu" type="time" id="hi">

     <label class="fhf entrada oculto px-0 mt-3">Fecha final</label>
     <input class="fhf entrada oculto col-12 input-formu" type="date" id="ff">
      <p class="mb-0 mx-2" style="color: #737373"> {{leyendaff}}</p>
     <label class="entrada hrs oculto px-0 mt-3">Hora final</label>
     <input class="entrada hrs oculto col-12 input-formu" type="time" id="hf">
     <label class="entrada hrs oculto px-0 mt-3">Hora del permiso</label>
     <input class="entrada hrs oculto col-12 input-formu" type="text" id="hp" readonly>
     <label class="my-3 hrs oculto" style="font-size: 16px;"><input type="checkbox" id="cbox2" value="check_j">Con goce de sueldo  </label> 
     <a  ng-click="modal_leyenda()" class="hrs oculto" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></a><br>
     <label class="px-0 mt-3">Observación</label>
     <textarea class="col-12 input-formu" rows="4" id="observacion" style="height: auto;"></textarea>
     <form enctype="multipart/form-data" id="form1" class="oculto">
              <div class="col-12 px-0 mt-3">
                <label for="description mt-3">Adjuntar foto:</label>
                <input type="file" class="form-control" id="acta" name="acta">
              </div>
            </form>
       <a href="#" class="btn btn-base-rojo mt-4 mb-2 col-10 offset-1 oculto" id="btn_crear_p" ng-click="btn_crear_permiso()">Solicitar permiso</a>
         <a href="#" class="btn btn-base-rojo mt-4 mb-2 col-10 offset-1 oculto" id="btn_editar_p" ng-click="btn_editar_permiso()">Editar permiso</a>
  </div>

      
</div>

<div class="caja_central entrada oculto" id="div_hitorial">
    <div class="col-12 caja-historia text-center p-2 mt-3 {{x.status}}" ng-repeat="x in list_historial">
      <p>{{x.tipo_permiso}}<br><b>Motivo: </b>{{x.motivo}}<br><b>Desde: </b>{{x.fi}} - {{x.hi}}<br><b>Hasta: </b>{{x.ff}} - {{x.hf}}<br><b>Tiempo del permiso: </b>{{x.ht}} {{x.tipo_tiempo}} <br><b>Status: </b>{{x.status}}<br> {{x.descripcion}}</p>
      <div class="col-12 row mx-0 px-0 my-2">
        <div class="col-2 offset-1 text-center">
          <a href="" ng-click="modal_detalles_permiso(x.id)"><i class="fa fa-eye" aria-hidden="true"></i></a>
        </div>
        <div class="col-2 text-center">
          <a href="" class="btnq_{{x.status}}" ng-click="div_editar_permiso(x.id, x.tipo_permiso, x.motivo)"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
        </div>
        <div class="col-2 text-center">
          <a href="pdf.php?id={{x.id}}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
        </div>
        <div class="col-2 text-center {{x.ban_adjunto}}">
          <a href="" ng-click="btn_adjuntar(x.id, x.adjunto)"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
        </div>
        <div class="col-2 text-center">
          <a href="" class="btn_{{x.status}}"  ng-click="btn_eliminar_permiso(x.id)" style="color: red;"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </div>
        
      </div>
    </div>
</div>


<div class="caja_central entrada oculto" id="div_responder">
    <div class="col-12 caja-historia text-center p-2 mt-3" ng-repeat="x in list_permisos_responder">
      <p>{{x.name}} <br> {{x.rut}}<br><b>Horas disponibles: </b>{{x.hr_disp}} Horas<br> {{x.tipo_permiso}}<br><b>Motivo: </b>{{x.motivo}}<br><b>Desde: </b>{{x.fi}} - {{x.hi}}<br><b>Hasta: </b>{{x.ff}} - {{x.hf}}<br><b>Tiempo del permiso: </b>{{x.ht}} {{x.tipo_tiempo}} <br><b>Status: </b>{{x.status}}<br> {{x.descripcion}}</p>
      <div class="col-12 row mx-0 px-0 my-2">
        <div class="col-4 text-center">
          <a href="pdf.php?id={{x.id}}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
        </div>
        <div class="col-4 text-center">
          <a href="" ng-click="btn_aprobar_permiso(x.id)" style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></a>
        </div>
        <div class="col-4 text-center">
          <a href="" style="color: red;" ng-click="btn_rechazar_permiso(x.id)"><i class="fa fa-times" aria-hidden="true"></i></a>
        </div>        
      </div>
    </div>
</div>

<div class="caja_central entrada oculto" id="div_subalternos">
      <table  class="table mt-3">
               <thead class="cabecera">
                <tr class="text-center">
                 <th scope="col">Colaboradores</th>
                 <th scope="col"><i class="fa fa-history" aria-hidden="true"></i></th>
                </tr> 
              </thead>
              <tbody >
                <tr class="text-center" ng-repeat="x in list_subalternos">
                   <td ><a href="" ng-click="btn_datos_subalternos(x.id_funcionario)">{{x.nombre}}</a> </td>
                   <td ><a href="" ng-click="div_historial_subalternos(x.id_funcionario, x.nombre)"><i class="fa fa-history" aria-hidden="true"></i></a> </td>
                </tr>
              </tbody>
           </table>
</div>
 

</div>

 
<div class="caja_central entrada oculto" id="div_historial_subalternos">
    <div class="col-12 caja-historia text-center p-2 mt-3 {{x.status}}" ng-repeat="x in list_historial">
      <p><b>{{name_c}}</b> <br> {{x.tipo_permiso}}<br><b>Motivo: </b>{{x.motivo}}<br><b>Desde: </b>{{x.fi}} - {{x.hi}}<br><b>Hasta: </b>{{x.ff}} - {{x.hf}}<br><b>Tiempo del permiso: </b>{{x.ht}} {{x.tipo_tiempo}} <br><b>Status: </b>{{x.status}}<br> {{x.descripcion}}</p>
 
    </div>
</div>


   
   <?php include ('elementos/pie.php'); ?>

  <div class="modal fade bd-example-modal-lg" id="cambiar_pw" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">CAMBIAR CONTRASEÑA:</h5>
      </div>
      <div class="modal-body pl-5 pr-5"> 
        <label class="col-12 mt-2"><b>Contraseña Actual</b></label>
        <input class="col-12" type="password" id="pw_user">
        <label class="col-12 mt-2"><b>Contraseña Nueva</b></label>
        <input class="col-12" type="password" id="pw_user2">
        <label class="col-12 mt-2"><b>Confirmar Nueva contraseña</b></label>
        <input class="col-12" type="password" id="pw_user3">
      </div> 
      <div class="modal-footer ">
      <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button>
       <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2" ng-click="btn_cambiar_pw()">Cambiar Contraseña</a>
     </div>
        </div>
    </div>
  </div>

  <div class="modal fade bd-example-modal-lg" id="detalles_de_permiso" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detalles del permiso:</h5>
       </div>
      <div class="modal-body pl-5 pr-5"> 
 
        <p style="line-height: 25px;" ng-repeat="x in detalles_permiso" >
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Permiso:</span> <br> <span style="font-size: 15px"> {{x.tipo_permiso}}  - {{x.motivo}} </span>
          <br>
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Status:</span> <br> <span style="font-size: 15px"> {{x.status}}</span>
          <br>
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Inicio:</span> <br> <span style="font-size: 15px"> {{x.fi}} - {{x.hi}} Horas</span>
          <br>
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Final:</span> <br> <span style="font-size: 15px"> {{x.ff}} - {{x.hf}} Horas</span>
          <br>
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Tiempo del permiso:</span> <br> <span style="font-size: 15px"> {{x.ht}} - {{x.tipo_tiempo}}</span>
          <br>
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Nota:</span> <br> <span style="font-size: 15px"> {{x.descripcion}}</span>
          <br>
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Numero de permiso:</span> <br> <span style="font-size: 15px"> {{x.anno}}{{x.n}}</span>
          <br>
          <span style="font-weight: bold; font-size: 20px; color: var(--main-color);">Con goze de sueldo:</span> <br> <span style="font-size: 15px"> {{x.descuento}}</span>

        </p>
        
         </div> 
      <div class="modal-footer ">
      <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
     </div>
    </div>
  </div>
 </div>
 

 

  <?php include ('elementos/modal_cambiar_pw.php'); ?>


  <div class="modal fade bd-example-modal-lg" id="modal_datos_subalternos" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document"  >
    <div class="modal-content modal-lg">
       <div class="modal-header">
       <h5 class="modal-title" id="exampleModalLongTitle">Datos del subalterno:</h5>
       </div>
      <div class="modal-body pl-5 pr-5"> 
      <div class="col-12 caja-historia text-center p-2" ng-repeat="x in datos_funcionario2">
       <p style="line-height: 20px;" ><span style="font-weight: bold; font-size: 30px; color: var(--main-color);">{{x.nombre}}</span> <br> <span style="font-size: 20px"> {{x.apellido_p}} {{x.apellido_m}}</span><br>{{x.rut}}</p>
        <p style="line-height: 30px;" >
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Horas Disponibles:</span> <br> <span style="font-size: 20px"> {{x.hr_disp}} Horas</span>
          <br>
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Permisos por revisar:</span> <br> <span style="font-size: 20px"> {{x.pr}}</span>
          <br>
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Permisos Aprobados:</span> <br> <span style="font-size: 20px"> {{x.a}}</span>
          <br>
          <span style="font-weight: bold; font-size: 25px; color: var(--main-color);">Permisos Rechazados:</span> <br> <span style="font-size: 20px"> {{x.r}}</span>

        </p>
    </div>
        
         </div> 
      <div class="modal-footer ">
       <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
      </div>
    </div>
  </div>
 </div>

 <div class="modal fade bd-example-modal-lg" id="modal_leyenda" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true" style="margin-top:200px ;">
  <div class="modal-dialog "  role="document"  >
    <div class="modal-content modal-lg">
        
      <div class="modal-body px-3 pb-0"> 
       <p style="font-size: 18px;">Si se desmarca esta opción, las horas solicitadas de permiso serán descontadas en su próxima remuneración.</p>
        
         </div> 
      
    </div>
  </div>
 </div>



 <div class="modal fade bd-example-modal-lg" id="modal_adjuntar" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document"  >
    <div class="modal-content modal-lg">
        <div class="modal-body px-3 pb-0"> 
       <form enctype="multipart/form-data" id="form22">
          <div class="col-12 px-0 mt-3">
               <label for="description mt-3">Adjuntar archivo de respaldo:</label>
                <input type="file" class="form-control" id="name_archivo" name="name_archivo">
          </div>
        </form>
      </div>  
        <div class="modal-footer ">
       <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
          <a href="#" class="btn btn-base-rojo" ng-click="btn_adjuntar_archivo()">Adjuntar archivo</a>
     
      </div>
    </div>
  </div>
 </div>


   <script src="js/bootstrap.min.js"></script>
   <script src="js/sweetalert.js"></script>
   <script src="js/angular.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
   <script src="js/funcionario.js?v=1.1" ></script>
   <script src="https://kit.fontawesome.com/9f856f1951.js" crossorigin="anonymous"></script>
</body>
</html>