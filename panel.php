<!DOCTYPE html>
<html lang="es" ng-app="angular">
<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
	    <title>Permisos - Administrador</title>
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
.precio-parametro{
  font-size: 20px;
}

.precio-parametro span{
  font-size:30px;
  font-weight: bold;
}
.tipo_comedor{
  font-size: 25px;
  font-weight: bold;
}
.dia{
  border-bottom: 1px solid black;
}
  .caja-historia{
    border-radius: 10px 10px;
    border: 1px solid var(--azul-oscuro);
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
.vacio{
  border: 1px solid red;
}
.ssD{
  background: #4ca4f2;
}
.ssND{
  background: #ca8586;
}
.ssA{
  background: #90bba3;
}
.btn_anular{
  position: absolute;
  top: 10px;
  right: 20px;
  color: red;
}

.btn_anular2{
  color: red;
}
</style>
<body ng-controller="comedorcontroller">
   <?php include ('elementos/menu.php'); ?>

    <div class="row caja-principal">
       <div class="col-md-3 col-lg-2 pl-0 pr-0 ">
        <div id="accordion" class="items-barra lateral-menu">
          <div class="card items-barra">
            <div  id="op1" class="items" data-toggle="collapse" data-target="#items1" aria-expanded="true" aria-controls="items1" id="1">
              <h5 class="mb-0"><p class="text-center pt-3 pl-1 pr-1"><b>PERMISOS</b></p></h5>
            </div>
             <div id="items1" class="collapse" aria-labelledby="1" data-parent="#accordion">
              <div class="card-body p-0">
                <p ng-click="btn_crear_permiso()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center " >CREAR PERMISO</p>
                 <p ng-click="btn_listado_permisos_list()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center " >LISTADO</p>
             </div>
            </div>
          </div>  <!--fin de categoria-->
         <!--fin de acordion-->

         <div class="card items-barra">
            <div ng-click="div_asignacion()"id="op3" class="items" data-toggle="collapse" data-target="#items3" aria-expanded="true" aria-controls="items3" id="1">
              <h5 class="mb-0"><p class="text-center pt-3 pl-1 pr-1"><b>PARAMETROS</b></p></h5>
            </div>
            <div id="items3" class="collapse" aria-labelledby="1" data-parent="#accordion">
              <div class="card-body p-0">
                 <p ng-click="div_supervisores()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">SUPERVISORES</p>
             </div>
            </div>
          </div>  <!--fin de categoria-->
         <!--fin de acordion-->
           <div class="card items-barra">
            <div id="op71" class="items" data-toggle="collapse" data-target="#items71" aria-expanded="true" aria-controls="items71" id="1">
              <h5 class="mb-0"><p class="text-center pt-3 pl-1 pr-1"><b>GESTIÓN</b></p></h5>
            </div>
            <div id="items71" class="collapse" aria-labelledby="1" data-parent="#accordion">
              <div class="card-body p-0">
                 <p ng-click="div_crear_permiso()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">PERMISO EXTRAORDINARIO</p>  
                 <p ng-click="btn_listado_permisos()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">HISTORIAL DE PERMISOS</p>          
                  <p ng-click="btn_listado_permisosnew()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">HISTORIAL DE PERMISOS (NUEVO)</p>   
                  <p ng-click="modal_pre_calendario()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">CALENDARIO DE PERMISOS</p> 
                 <p ng-click="listado_funcionarios_hr()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">FUNCIONARIOS / HRS DISP.</p>          
              </div>
            </div>
          </div>

          <div class="card items-barra">
            <div id="op7" class="items" data-toggle="collapse" data-target="#items7" aria-expanded="true" aria-controls="items7" id="1">
              <h5 class="mb-0"><p class="text-center pt-3 pl-1 pr-1"><b>FUNCIONARIOS</b></p></h5>
            </div>
            <div id="items7" class="collapse" aria-labelledby="1" data-parent="#accordion">
              <div class="card-body p-0">
                 <p ng-click="btn_crear_f()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">CREAR FUNCIONARIOS</p>          
                 <p ng-click="listado_funcionarios()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">LISTADO FUNCIONARIOS</p>   
                  <p ng-click="listado_exfuncionarios()" class="mb-0 pt-1 pb-2 titulo-sub-items text-center">LISTADO EXFUNCIONARIOS</p>          
              </div>
            </div>
          </div> 
     
       </div>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_permisos">
           <div class="col-12 mx-0 px-0">
             <div class="col-6 offset-3 mt-5">
               <label class="px-0">Nombre del tipo de permiso</label>
               <input class="col-12 input-formu" type="text" id="name_permiso">
               <label class="px-0 mt-3">¿Archivo adjunto obligatorio?</label>
               <select  class="col-12 input-formu" type="text" id="adjunto_permiso">
                 <option>No</option>
                 <option>Si</option>
               </select>
                
                
               <a href="" ng-click="btn_crear_permiso_new()" class="col-8 offset-2 btn btn-base mt-4 mb-4">Crear tipo de permiso</a>
             </div>
           </div>
      </div>

        <div class="caja-dere col-8 offset-lg-1 pt-5 entrada oculto" id="div_crear_permisoe">
          <label class="px-0 mt-3">Rut del funcionario:</label>
               <input class="col-12 input-formu" type="text" id="rut_fun" placeholder="Rut del funcionario">
              <input class="col-12 input-formu mt-3" type="text" id="name_fun">
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
             <input class="col-12 input-formu" type="date" id="fi"  onchange="timeFunction()">
              <p class="mb-0 mx-2" style="color: #737373"> {{leyendafi}}</p>
              <label class="my-3 hrs oculto" style="font-size: 16px;"><input type="checkbox" id="cbox1" value="t_j"> Toda la jornada</label><br>
             <label class="entrada hrs oculto px-0 mt-3">Hora de inicio</label>
             <input class="entrada hrs oculto col-12 input-formu" type="time" id="hi">

             <label class="fhf entrada oculto px-0 mt-3">Fecha final</label>
             <input class="fhf entrada oculto col-12 input-formu" type="date" id="ff">
              <p class="mb-0 mx-2" style="color: #737373"> {{leyendaff}}</p>
             <label class="entrada hrs oculto px-0 mt-3">Hora final</label>
             <input class="entrada hrs oculto col-12 input-formu" type="time" id="hf" onchange="timeFunction()">
             <label class="entrada hrs oculto px-0 mt-3">Hora del permiso</label>
             <input class="entrada hrs oculto col-12 input-formu" type="text" id="hp"  >

               <script>

function timeFunction() {
  const getSeconds = s => s.split(":").reduce((acc, curr) => acc * 60 + +curr, 0);
  var seconds1 = getSeconds(document.getElementById("hi1").value);
  var seconds2 = getSeconds(document.getElementById("hf1").value);

  var res = Math.abs(seconds2 - seconds1);

  var hours = Math.floor(res / 3600);

  var minutes = Math.floor(res % 3600 / 60);

  var seconds = res % 60;
  document.getElementById("hp1").value =   minutes + ":" + seconds;
}
</script>  
             <label class="my-3 hrs oculto" style="font-size: 16px;"><input type="checkbox" id="cbox2" value="check_j">Con goce de sueldo  </label> 
             <a  ng-click="modal_leyenda()" class="hrs oculto" href=""><i class="fa fa-question-circle" aria-hidden="true"></i></a><br>
             <label class="px-0 mt-3">Observación</label>
             <textarea class="col-12 input-formu" rows="4" id="observacion" style="height: auto;"></textarea>
             <form enctype="multipart/form-data" id="form1">
                      <div class="col-12 px-0 mt-3">
                        <label for="description mt-3">Adjuntar archivo de respaldo:</label>
                        <input type="file" class="form-control" id="acta" name="acta">
                      </div>
                    </form>
               <a href="#" class="btn btn-base-rojo mt-4 mb-2 col-10 offset-1 oculto" id="btn_crear_p" ng-click="btn_crear_permiso2()">Crear permiso</a>
       </div>

       <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_listado">
            <table  class="table mt-5">
               <thead class="cabecera">
                <tr class="text-center">
                 <th scope="col">NOMBRE</th>
                 <th scope="col">ADJUNTO</th>
                 <th scope="col">MOTIVOS</th>
                 <th scope="col">AGREGAR MOTIVO</th>
                 <th scope="col">EDITAR</th>
                 <th scope="col">ELIMINAR</th>
                </tr>
              </thead>
              <tbody >
                <tr class="text-center" ng-repeat="x in list_permisos">
                  <td >{{x.nombre}} </td>
                  <td >{{x.adjunto}} </td>
                  <td><a href="" ng-click="modal_motivos(x.id, x.nombre)"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  <td><a href=""  ng-click="agg_motivo(x.id, x.nombre)"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                  <td><a href=""><i class="fa fa-pencil-square" aria-hidden="true"></i></a></td>
                  <td><a href="" ng-click="btn_eliminar_permiso(x.id)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
              </tbody>
           </table>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_agg_motivo">
            <div class="col-12 row mx-0 px-0">
             <div class="col-12">
                <p class="text-right mb-0"><b>Motivos actuales de {{name_permiso_tipo}}:</b> </p>
             </div>
              <div class="col-5 pt-3">
               <label class="px-0">Nuevo motivo para el permiso {{name_permiso_tipo}}</label>
               <input class="col-12 input-formu" type="text" id="name_motivo">
               <label class="px-0 mt-3">Tipo de tiempo establecido</label>
               <select  class="col-12 input-formu" type="text" id="tipo_tiempo">
                 <option value="NA">No aplica</option>
                 <option value="HR">Horas</option>
                 <option value="DI">Dias</option>
               </select>
               <input class="col-12 input-formu mt-1 oculto" type="time" id="tiempo_hr">
               <input class="col-12 input-formu mt-1 oculto" type="text" id="tiempo_dias">
                <label class="px-0 mt-3">Archivo adjunto obligatorio</label>
               <select  class="col-12 input-formu" type="text" id="arc_adj">
                 <option value="No">No</option>
                 <option value="Si">Si</option>
                </select>
                <label class="px-0 mt-3">Dias para adjuntar archivo</label>
               <input class="col-12 input-formu" type="number" id="dias_archivo">
               <label class="px-0 mt-3">Leyenda</label>
               <textarea class="col-12 input-formu" id="leyenda" rows="4" style="height: auto;"></textarea>
               <a href="" ng-click="btn_crear_motivo_new()" class="col-8 offset-2 btn btn-base mt-4 mb-4">Agregar motivo</a>

              </div>
              <div class="col-7 pt-3">
                
                <table  class="table">
            <thead class="cabecera">
             <tr class="text-center">
               <th scope="col">MOTIVOS</th>
                <th scope="col">ELIMINAR</th>
             </tr>
           </thead>
           <tbody >
             <tr class="text-center" ng-repeat="x in list_motivos">
               <td >{{x.descripcion}} </td>
               <td><a href="" ng-click="btn_eliminar_motivo(x.id)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
             </tr>
           </tbody>
        </table>
              </div>
            </div>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_supervisores">
            <div class="col-12 row mx-0 px-0">
              <div class="col-12 mt-1 row">
               <p class="mb-0 pt-2 mr-3 ml-auto"><b>Listado de supervisores:</b> </p>
               <input class="float-right input-formu" type="text" id="buscador_s" placeholder="Buscar">
             </div>
              <div class="col-5 pt-3">
               <label class="px-0">Rut del nuevo supervisor</label>
               <input class="col-12 input-formu" type="text" id="rut_supervisor">
               <label class="px-0 mt-3">Nombre del supervisor</label>
               <input class="col-12 input-formu" type="text" id="name_supervisor" readonly>
               <a href="" ng-click="btn_agg_supervisor()" class="col-8 offset-2 btn btn-base mt-4 mb-4">Agregar Supervisor</a>

              </div>
              <div class="col-7 pt-3">
             <table  class="table">
            <thead class="cabecera">
             <tr class="text-center">
               <th scope="col">NOMBRE SUPERVISOR</th>
               <th scope="col"><i class="fa fa-plus" aria-hidden="true"></i></th>
                <th scope="col">ELIMINAR</th>
             </tr>
           </thead>
           <tbody >
             <tr class="text-center {{x.foto}}" ng-repeat="x in list_supervisores">
               <td >{{x.nombre}} ({{x.n}}) </td>
               <td><a href="" ng-click="agg_vinculo_neew(x.id, x.nombre)"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
               <td><a href="" ng-click="btn_eliminar_supervisor(x.id)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
             </tr>
           </tbody>
        </table>
              </div>
            </div>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_vinculacion">
            <div class="col-12 row mx-0 px-0">
             
              <div class="col-5 pt-3">
                <label class="px-0">Nombre del supervisor</label>
               <input class="col-12 input-formu" type="text" id="name_sup_reonly" readonly>
               <label class="px-0 mt-3">Rut del nuevo funcionario</label>
               <input class="col-12 input-formu" type="text" id="rut_funcionario">
               <label class="px-0 mt-3">Nombre del funcionario</label>
               <input class="col-12 input-formu" type="text" id="name_funcionaro" readonly>
               <a href="" ng-click="btn_agg_viculacion()" class="col-8 offset-2 btn btn-base mt-4 mb-2">Agregar funcionario</a>
                <a href="" ng-click="div_supervisores()" class="col-6 offset-3 btn btn-danger mt-2 mb-4" style="border-radius: 10px 10px;">Volver</a>

              </div>
              <div class="col-7 pt-3">
             <table  class="table">
            <thead class="cabecera">
             <tr class="text-center">
               <th scope="col">FUNCIONARIO ADJUNTO</th>
                <th scope="col">ELIMINAR</th>
             </tr>
           </thead>
           <tbody >
             <tr class="text-center" ng-repeat="x in list_victulados">
               <td >{{x.nombre}} </td>
                 <td><a href="" ng-click="btn_eliminar_vinculo(x.id, x.id_supervisor)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
             </tr>
           </tbody>
        </table>
              </div>
            </div>
      </div>

       <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_list_permisos">
        <div class="col-12 my-5">
          <a href="" class="btn btn-base-rojo float-right ml-1" ng-click="blanqueo_lp()" style="font-size: 11px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
          <input class="float-right mb-1" type="text" id="buscador_lp" placeholder="Buscar">
        </div>
          <div class="col-12 caja-historia text-center p-2 mt-3 {{x.status}} {{x.foto}}" ng-repeat="x in list_permisos">
            <a href="" ng-click="btn_eliminar_permiso(x.id)" class="btn_anular"><i class="fa fa-times" aria-hidden="true"></i></a>
            <p>{{x.name}} <br> {{x.rut}}<br>{{x.tipo_permiso}}<br><b>Motivo: </b>{{x.motivo}}<br><b>Desde: </b>{{x.fi}} - {{x.hi}}<br><b>Hasta: </b>{{x.ff}} - {{x.hf}}<br><b>Tiempo del permiso: </b>{{x.ht}} {{x.tipo_tiempo}} <br><b>Status: </b>{{x.status}}<br> {{x.descripcion}}</p>
                  <div class="col-12 row mx-0 px-0 my-2">
                    <div class="col-3 text-center">
                      <a href="pdf.php?id={{x.id}}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-3 text-center">
                      <a href="" ng-click="btn_aprobar_permiso(x.id, x.status)" style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-3 text-center {{x.adjunto}}">
                      <a href="{{x.adjunto}}"  style="color: red;" target="_blank"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a>
                    </div>
                    
                 </div>
          </div>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_list_permisosnew">
        <div class="col-12 my-5">
          <a href="" class="btn btn-base-rojo float-right ml-1" ng-click="blanqueo_lp2()" style="font-size: 11px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
          <input class="float-right mb-1" type="text" id="buscador_lp2" placeholder="Buscar">
        </div>
             <table  class="table">
               <thead class="cabecera">
                <tr class="text-center">
                 <th scope="col">RUT</th>
                 <th scope="col">FUNCIONARIO</th>                 
                 <th scope="col">DESDE</th>
                 <th scope="col">HASTA</th>
                  <th scope="col">TOTAL H</th>
                 <th scope="col">TIPO P</th>
                 
                 <th scope="col">MOTIVO</th>
                 <th scope="col">STATUS</th>
                 <th scope="col"><i class="fa fa-print" aria-hidden="true"></i></th>
                 <th scope="col" ><i class="fa fa-check" aria-hidden="true"></i></th>
                 <th scope="col"><i class="fa fa-folder-open-o" aria-hidden="true"></i></th>
                 <th scope="col"><i class="fa fa-times" aria-hidden="true"></th>
                
                 </tr>
              </thead>
              <tbody >
                <tr class="text-center {{x.status}} {{x.foto}}" ng-repeat="x in list_permisos" style="font-size: 12px;">
                  <td >{{x.rut}} </td>
                  <td >{{x.name}} </td>
                  <td>{{x.fi}} / {{x.hi}}</td>
                   <td >{{x.ff}} / {{x.hf}}</td>
                    <td>{{x.ht}} </td>
                  <td>{{x.tipo_permiso}} </td>

                  <td>{{x.motivo}}</td>
                  <td>{{x.status}}</td>
                  <td> <a href="pdf.php?id={{x.id}}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a></td>
                  <td> <a href="" ng-click="btn_aprobar_permiso(x.id, x.status)" style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></a></td>
                  <td>  <a href="{{x.adjunto}}" class="{{x.adjunto}}"  style="color: red;" target="_blank"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a></td>
                  <td><a href="" ng-click="btn_eliminar_permiso(x.id)" class="btn_anular2"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                </tr>
              </tbody>
           </table>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_funcionarios">
        <div class="col-12 mt-3">
          <a href="" class="btn btn-base-rojo float-right ml-1" ng-click="blanqueo_f()" style="font-size: 11px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
          <input class="float-right mb-1" type="text" id="buscador_f" placeholder="Buscar">
        </div>
               <table  class="table">
               <thead class="cabecera">
                <tr class="text-center">
                 <th scope="col" style="width: 120px;">RUT</th>
                 <th scope="col" style="width: 240px;">NOMBRE</th>                 
                 <th scope="col"  style="width: 240px;">SUPERVISOR</th>
                 <th scope="col">T</th>
                 <th scope="col">HORARIO</th>
                 <th scope="col">HRS SEM</th>
                 <th scope="col">HRS CON</th>
                 <th scope="col">HRS UTI</th>
                 <th scope="col">HRS DISP</th>
                 <th scope="col">HR COBRA.</th>
                 <th scope="col" ><i class="fas fa-edit"></i></th>
                 <th scope="col"> STATUS</th>
                
                 </tr>
              </thead>
              <tbody >
                <tr class="text-center {{x.foto}}" ng-repeat="x in list_funcionarios" style="font-size: 13px;">
                  <td >{{x.rut}} </td>
                  <td >{{x.nombre}} {{x.apellido_p}} </td>
                  <td>{{x.supe}}</td>
                   <td >{{x.prev}}</td>
                  <td><a href="" ng-click="btn_ver_horario(x.rut)">{{x.horario}}</a> </td>
                  <td>{{x.hr_semanal}}:00</td>
                  <td>{{x.hr_contrato}}</td>
                  <td>{{x.hr_utilizadas}}</td>
                  <td>{{x.hr_disp}}</td>
                   <td>{{x.hrs_cobradas}}</td>
                  
                  <td class="celda-cuerpo"> <a href="" ng-click="btn_editar_f(x.id, x.rut, x.nombre, x.apellido_p, x.apellido_m, x.correo, x.lun_hr, x.mar_hr, x.mie_hr, x.jue_hr, x.vie_hr, x.tipo_f, x.horario, x.hr_semanal, x.hr_disp, x.sab_hr, x.correo_p, x.hrs_cobradas)"> <i class="fas fa-edit"></i></a></td>
                  <td  class="celda-cuerpo"><a href="" ng-click="btn_eliminar_funcionario(x.id, x.status, x.rut)"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> ({{x.status}})</a> </td>
                </tr>
              </tbody>
           </table>
      </div>

            <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_funcionarios_hr">
        <div class="col-12 mt-3">
            <input class="float-right mb-1" type="text" id="info_f" placeholder="Buscar">
           <a href="informes/funcionarios_hr_excel.php" target="_blank" class="btn btn-base-rojo float-right ml-2 mr-2" style="font-size: 12px; background: green;border: 1px solid green;">Exportar Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
           <a href="informes/funcionarios_hr_pdf.php" target="_blank" class="btn btn-base-rojo float-right ml-2 mr-2" style="font-size: 12px;">Exportar PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>


        </div>
               <table  class="table">
               <thead class="cabecera">
                <tr class="text-center">
                 <th scope="col" style="width: 120px;">RUT</th>
                 <th scope="col">NOMBRE</th>                 
                 <th scope="col">LEG</th>
                 <th scope="col">HRS LAB</th>
                 <th scope="col">HRS PERMISO</th>
                 <th scope="col">HRS UTILIZADAS</th>
                 <th scope="col">HR DISP.</th>
                  <th scope="col">HR COBRA.</th>
                 <th scope="col">APROBADOS</th>
                 <th scope="col">RECHAZADOS</th>
 
                 </tr>
              </thead>
              <tbody >
                <tr class="text-center {{x.foto}}" ng-repeat="x in list_funcionarios">
                  <td >{{x.rut}} </td>
                  <td >{{x.nombre}} {{x.apellido_p}} </td>
                  <td>{{x.hr_leg}}</td>
                  <td>{{x.hr_lab}}</td>
                  <td>{{x.hr_contrato}}</td>
                  <td >{{x.hr_utilizadas}}</td>
                  <td>{{x.hr_disp}}</td>
                  <td>{{x.hrs_cobradas}}</td>
                  <td>{{x.apro}}</td>
                  <td>{{x.noapro}}</td>
                   
                </tr>
              </tbody>
           </table>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_calendario">
               <table  class="table">
               <thead class="cabecera">
                <tr class="text-center">
                  <th scope="col" style="width: 120px;">FECHA</th>                 
                 <th scope="col">NOMBRE FUNCIONARIO</th>
                 <th scope="col">TIPO</th>
                 <th scope="col">FECHA / HORA</th>
                 <th scope="col">MOTIVO</th>
                
                 </tr>
              </thead>
              <tbody >
                <tr class="text-center ss{{x.tipo_f}}" ng-repeat="x in list_calendario">
                  <td >{{x.fi}} </td>
                  <td >{{x.name_f}} </td>
                  <td>{{x.tipo_f}}</td>
                  <td ><b>Desde:</b><br> {{x.fi}} <br> {{x.hi}} <br> <b>Hasta:</b> <br>{{x.ff}} <br> {{x.hf}}</td>
                  <td><b>{{x.tipo_permiso}}</b> <br> {{x.motivo}} <br> {{x.descripcion}}</td>
                  
                </tr>
              </tbody>
           </table>
      </div>

      <div class="col-md-9 col-lg-10 pl-5 pr-5 pb-5 pt-1 oculto entrada caja-dere" id="div_calendario2">
         <div class="col-12 caja-superior my-4 row">
          <div class="col-3">
            <div class="btn-azul m-2 p-2">
              <label class="label_input"><input type="checkbox" id="cbox_docente" value="docentes"> Docentes</label>
            </div>
            
          </div>
          <div class="col-3">
            
            <div class="btn-rojizo m-2 p-2">
              <label class="label_input"><input type="checkbox" id="cbox_no_docente" value="docentes"> No Docentes</label>
            </div>
             
          </div>
          
          <div class="col-3">
            
            <div class="btn-verde m-2 p-2">
              <label class="label_input"><input type="checkbox" id="cbox_auxiliar" value="docentes"> Auxiliares</label>
            </div>
          </div>

          <div class="col-3">
            <input class="m-2 p-2 col-12" type="date" id="fecha_calendario" style=" height:40px; border-radius: 10px 10px;">
          </div>


           <input class="oculto" type="text" id="f_oculta">
           <a class="oculto" href="" id="btn_modal" ng-click="modal_dia()"></a>
         </div>
         <div class="calendar col-12" style="margin-left: -13px;">
              <div class="calendar__info">
                  <div class="calendar__prev" id="prev-month"></div>
                  <div class="calendar__month" id="month"></div>
                  <div class="calendar__year" id="year"></div>
                  <div class="calendar__next" id="next-month"></div>
              </div>

              <div class="calendar__week my-2" >
                  <div class="calendar__day calendar__item2">Lunes</div>
                  <div class="calendar__day calendar__item2">Martes</div>
                  <div class="calendar__day calendar__item2">Miercoles</div>
                  <div class="calendar__day calendar__item2">Jueves</div>
                  <div class="calendar__day calendar__item2">Viernes</div>
                  <div class="calendar__day calendar__item2">Sabado</div>
                  <div class="calendar__day calendar__item2">Domingo</div>
              </div>

              <div class="calendar__dates" id="dates"></div>
          </div>
      </div>

  </div>

   <?php include ('elementos/pie.php');
         include ('elementos/modal_cambiar_pw.php');
    ?>
 
 <div class="modal fade bd-example-modal-lg" id="motivos" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Motivos del permiso {{name_permiso_tipo}}:</h5>
       </div>
      <div class="modal-body pl-5 pr-5"> 
         <table  class="table">
            <thead class="cabecera">
             <tr class="text-center">
               <th scope="col">MOTIVOS</th>
                <th scope="col"><i class="fa fa-pencil-square" aria-hidden="true"></i></th>
                <th scope="col" class="oculto"><i class="fa fa-trash" aria-hidden="true"></i></th>
             </tr>
           </thead>
           <tbody >
             <tr class="text-center" ng-repeat="x in list_motivos">
               <td >{{x.descripcion}} ({{x.status}})</td>
               <td><a href="" ng-click="editar_motivo(x.id)"><i class="fa fa-pencil-square" aria-hidden="true"></i></a></td>
                <td class="oculto"><a href="" ng-click="btn_eliminar_motivo(x.id)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
             </tr>
           </tbody>
        </table>
        
         </div> 
      <div class="modal-footer ">
      <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
     </div>
    </div>
  </div>
 </div>

  <div class="modal fade bd-example-modal-lg" id="editar_motivos" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar Motivo:</h5>
       </div>
      <div class="modal-body pl-5 pr-5"> 
         <label class="px-0">Nombre del motivo</label>
               <input class="col-12 input-formu" type="text" id="name_motivo_e">
               <label class="px-0 mt-3">Tipo de tiempo establecido</label>
               <select  class="col-12 input-formu" type="text" id="tipo_tiempo_e">
                 <option value="NA">No aplica</option>
                 <option value="HR">Horas</option>
                 <option value="DI">Dias</option>
               </select>
               <input class="col-12 input-formu mt-1 oculto" type="time" id="tiempo_hr_e">
               <input class="col-12 input-formu mt-1 oculto" type="text" id="tiempo_dias_e">
                <label class="px-0 mt-3">Archivo adjunto obligatorio</label>
               <select  class="col-12 input-formu" type="text" id="arc_adj_e">
                 <option value="No">No</option>
                 <option value="Si">Si</option>
                </select>
                <label class="px-0 mt-3">Dias para adjuntar archivo</label>
               <input class="col-12 input-formu" type="number" id="dias_archivo_e">
                 <label class="px-0 mt-3">Status</label>
               <select  class="col-12 input-formu" type="text" id="status_permiso">
                 <option value="A">Activo</option>
                 <option value="I">Inactivo</option>
                </select>
               <label class="px-0 mt-3">Leyenda</label>
               <textarea class="col-12 input-formu" id="leyenda_e" rows="4" style="height: auto;"></textarea>
         </div> 
      <div class="modal-footer ">
      <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
      <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2" ng-click="btn_editar_motivo_new()">Editar motivo</a>
     </div>
    </div>
  </div>
 </div>

  <div class="modal fade bd-example-modal-lg" id="modal_funcionarios" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document" style="    margin-left: 0px;">
    <div class="modal-content modal-lg" style="min-width: 90vw; margin-left: 5vw;">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Funcionario:</h5>
       </div>
      <div class="modal-body pl-5 pr-5"> 
       <div class="col-12 row mx-0 px-0">
         <div class="col-6">
             <label class="px-0">Nombre:</label>
               <input class="col-12 input-formu" type="text" id="nombre_funcionario" style="background: #E4E4E4;" >
               <label class="px-0 mt-3">Rut:</label>
               <input class="col-12 input-formu" type="text" id="rut_funcionario_ed" style="background: #E4E4E4;" >
               <label class="px-0 mt-3">Correo institucional:</label>
               <input class="col-12 input-formu" type="text" id="correo_funcionario">
               <label class="px-0 mt-3">Correo personal:</label>
               <input class="col-12 input-formu" type="text" id="correo_funcionario2">
               <label class="px-0 mt-3">Tipo de funcionario:</label>
               <select  class="col-12 input-formu" type="text" id="tipo_funcionario">
                  <option >Auxiliar</option>
                  <option >Docente</option>
                  <option >No docente</option>           
               </select>
               <label class="px-0 mt-3">Tipo de Horario:</label>
               <select  class="col-12 input-formu" type="text" id="tipo_horario">
                <option>Normal</option>
               </select>
 
               <label class="px-0 mt-3">Horas disponibles en el año:</label>
               <input class="col-12 input-formu" type="text" id="hr_anno" readonly>
                <label class="px-0 mt-3">Horas cobradas por exceso en el año:</label>
               <input class="col-12 input-formu" type="time" id="hr_cobradas" >
         </div>
         <div class="col-6">
               <label class="px-0">Horas de trabajo a la semana:</label>
               <input class="col-12 input-formu" type="text" id="hr_semanal">
               <label class="px-0 mt-3">Horas de trabajo del día lunes</label>
               <input class="col-12 input-formu" type="time" id="hr_lun">
               <label class="px-0 mt-3">Horas de trabajo del día martes</label>
               <input class="col-12 input-formu" type="time" id="hr_mar">
               <label class="px-0 mt-3">Horas de trabajo del día miercoles</label>
               <input class="col-12 input-formu" type="time" id="hr_mie">
               <label class="px-0 mt-3">Horas de trabajo del día jueves</label>
               <input class="col-12 input-formu" type="time" id="hr_jue">
               <label class="px-0 mt-3">Horas de trabajo del día viernes</label>
               <input class="col-12 input-formu" type="time" id="hr_vie">
                 <label class="px-0 mt-3">Horas de trabajo del día sabado</label>
               <input class="col-12 input-formu" type="time" id="hr_sab">
         </div>
       </div>
        
         </div> 
      <div class="modal-footer ">
       <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
       <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2 oculto" ng-click="btn_editar_funcionario()" id="btn_editar_f">Editar funcionario</a>
       <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2 oculto" ng-click="btn_crear_funcionario()" id="btn_crear_f">Crear funcionario</a>

     </div>
    </div>
  </div>
 </div>


  <div class="modal fade bd-example-modal-lg" id="modal_horario" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document" style="    margin-left: 0px;">
    <div class="modal-content modal-lg" style="min-width: 50vw; margin-left: 25vw;">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Horario:</h5>
       </div>
      <div class="modal-body pl-5 pr-5" ng-repeat="x in detalle_horario"> 
       <div class="col-12 dia py-2">
         <p><b>Lunes:</b></p>
         <p>Desde las <b>{{x.lun_entrada}}</b> a las <b>{{x.lun_receso_i}}</b> y desde las <b>{{x.lun_receso_f}}</b> hasta las <b>{{x.lun_salida}}</b></p>
       </div>
       <div class="col-12 dia py-2">
         <p><b>Martes:</b></p>
        <p>Desde las <b>{{x.mar_entrada}}</b> a las <b>{{x.mar_receso_i}}</b> y desde las <b>{{x.mar_receso_f}}</b> hasta las <b>{{x.mar_salida}}</b></p>
       </div>
       <div class="col-12 dia py-2">
         <p><b>Miercoles:</b></p>
         <p>Desde las <b>{{x.mie_entrada}}</b> a las <b>{{x.mie_receso_i}}</b> y desde las <b>{{x.mie_receso_f}}</b> hasta las <b>{{x.mie_salida}}</b></p>
       </div>
       <div class="col-12 dia py-2">
         <p><b>Jueves:</b></p>
        <p>Desde las <b>{{x.jue_entrada}}</b> a las <b>{{x.jue_receso_i}}</b> y desde las <b>{{x.jue_receso_f}}</b> hasta las <b>{{x.jue_salida}}</b></p>
       </div>
       <div class="col-12 dia py-2">
         <p><b>Viernes:</b></p>
         <p>Desde las <b>{{x.vie_entrada}}</b> a las <b>{{x.vie_receso_i}}</b> y desde las <b>{{x.vie_receso_f}}</b> hasta las <b>{{x.vie_salida}}</b></p>
       </div>
       <div class="col-12 dia py-2">
         <p><b>Sabado:</b></p>
         <p>Desde las <b>{{x.sab_entrada}}</b> a las <b>{{x.sab_receso_i}}</b> y desde las <b>{{x.sab_receso_f}}</b> hasta las <b>{{x.sab_salida}}</b></p>
       </div>
        
         </div> 
      <div class="modal-footer ">
       <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
      </div>
    </div>
  </div>
 </div>

  <div class="modal fade bd-example-modal-lg" id="modal_pre_calendario" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document" style="    margin-left: 0px;">
    <div class="modal-content modal-lg" style="min-width: 50vw; margin-left: 25vw;">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Calendario de permisos:</h5>
       </div>
      <div class="modal-body pl-5 pr-5"> 
        <div class="col-12">
               <label class="px-0">Fecha de inicio:</label>
               <input class="col-12 input-formu" type="date" id="fi_calendario">
               <label class="px-0 mt-3">Fecha final:</label>
               <input class="col-12 input-formu" type="date" id="ff_calendario">
               <label class="px-0 mt-3">Tipo de funcionario:</label>
               <select  class="col-12 input-formu" type="text" id="tipo_funcionario_c">
                  <option value="0">Todos</option>
                  <option >Auxiliar</option>
                  <option >Docente</option>
                  <option >No Docente</option>           
               </select>
         </div>
      </div> 
      <div class="modal-footer ">
       <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
        <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2" ng-click="div_calendario()">Generar Calendario</a>
      </div>
    </div>
  </div>
 </div>


  <div class="modal fade bd-example-modal-lg" id="modal_permisos_diarios" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document" style="    margin-left: 0px;">
    <div class="modal-content modal-lg" style="min-width: 90vw; margin-left: 5vw;">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Permisos del dia:</h5>
       </div>
      <div class="modal-body pl-5 pr-5"> 
            <table  class="table">
               <thead class="cabecera">
                <tr class="text-center">
                  <th scope="col" style="width: 120px;">FECHA</th>                 
                 <th scope="col">NOMBRE FUNCIONARIO</th>
                 <th scope="col">TIPO</th>
                 <th scope="col">DESDE</th>
                 <th scope="col">HASTA</th>
                 <th scope="col">MOTIVO</th>
                
                 </tr>
              </thead>
              <tbody >
                <tr class="text-center ss{{x.tipo_f}}" ng-repeat="x in list_calendario">
                  <td >{{x.fi}} </td>
                  <td >{{x.name_f}} </td>
                  <td>{{x.tipo_f}}</td>
                  <td >{{x.fi}} <br> {{x.hi}}</td>
                   <td >{{x.ff}} <br> {{x.hf}}</td>
                  <td><b>{{x.tipo_permiso}}</b> {{x.motivo}} <br> {{x.descripcion}}</td>
                  
                </tr>
              </tbody>
           </table>
         </div> 
      <div class="modal-footer ">
       <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button> 
      </div>
    </div>
  </div>
 </div>

 
   <script src="js/bootstrap.min.js"></script>
    <script src="js/sweetalert.js"></script>
   <script src="js/angular.js"></script>
   <script src="js/paneladmin.js" ></script>
   <script src="https://kit.fontawesome.com/9f856f1951.js" crossorigin="anonymous"></script>

   <script>
function myFunction(pp) {
  f_oculta.value=pp;
   document.querySelector('#btn_modal').click();
}
</script>


 



</body>
</html>