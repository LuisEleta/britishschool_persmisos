angular.module('angular', []).controller("comedorcontroller",function($scope, $http)
{
$sesion=[];
$fecha_ingresada='';
$scope.list_permisos=[];
$scope.list_motivos=[];
$scope.list_supervisores=[];
$scope.list_funcionarios=[];
$scope.insertar=false;
$scope.editar=false;
$scope.name_permiso_tipo='';
$aux='';
 var f = new Date();
 $varm="";
 if ((f.getMonth() +1)<10) {$varm="0";}
 $vard="";
 if (f.getDate()<10) {$vard="0";}
 $fecha=f.getFullYear()+"-"+$varm+(f.getMonth() +1)+"-"+$vard+f.getDate();
 $fh=f.getFullYear()+$varm+(f.getMonth() +1)+$vard+f.getDate();
$name_user='';
 
$acu=0;

$http.get("php/permisos/rechazo_automatico.php?").success(
                function(resp_horario) { })

                
  $http.get("php/sesion/verificarsesion.php").success(
         function(response) {   
           if (response[0].permiso=='admin') {
            $name_user=response[0].user;
           $("#texto_sesion").text("Hola "+response[0].user);  
            $("#texto_cerrar_sesion").text("Cerrar sesión");    
            $("#carrito").addClass("oculto"); 
          
           } else{
            window.location.href = "index.php";    
           }    
                        })
   

      $(".items").click(function(e){
            $(".items").removeClass("items-activo");
                $(this).addClass("items-activo");
              }) 

      $(".titulo-sub-items").click(function(e){
            $(".titulo-sub-items").removeClass("titulo-sub-items-activo");
                $(this).addClass("titulo-sub-items-activo");
             }) 



$scope.btn_cerrar_sesion= function(){
   Swal.fire({
    title: '¿Desea cerrar su sesión?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
   $http.get("php/sesion/cerrarsesion.php").success(
        function(response) {
                window.location.href = "index.php"; 
                            })
 }}) 
}



$scope.btn_crear_permiso= function(){
  $(".caja-dere").addClass("oculto"); 
   $("#div_permisos").removeClass("oculto"); 
   
}

$scope.modal_motivos= function($id, $name){
  $scope.list_motivos=[];
  $scope.name_permiso_tipo=$name;
              $http.get("php/parametros_permisos/crud_permisos.php?opc=parametros_motivos&id="+$id).success(
                function(response) { 
                  if (response[0].id) {
                   $scope.list_motivos=response;
                  }
                   $("#motivos").modal('show');
                        })
  
   
}

$id_motivo_edit='';
$scope.editar_motivo= function($id){
  $id_motivo_edit=$id;
  for (let i in $scope.list_motivos){
    if ($scope.list_motivos[i].id==$id) {
      name_motivo_e.value=$scope.list_motivos[i].descripcion;
      tipo_tiempo_e.value=$scope.list_motivos[i].tipo_tiempo;
      arc_adj_e.value=$scope.list_motivos[i].adjunto;
      dias_archivo_e.value=$scope.list_motivos[i].dias_adjunto;
      leyenda_e.value=$scope.list_motivos[i].leyenda;
      status_permiso.value=$scope.list_motivos[i].status;
         if ($scope.list_motivos[i].tipo_tiempo=='NA') {
            $("#tiempo_hr_e").addClass("oculto"); 
            $("#tiempo_dias_e").addClass("oculto"); 
         }

         if ($scope.list_motivos[i].tipo_tiempo=='HR') {
            $("#tiempo_hr_e").removeClass("oculto"); 
            $("#tiempo_dias_e").addClass("oculto"); 
            tiempo_hr_e.value=$scope.list_motivos[i].tiempo;
         }
         if ($scope.list_motivos[i].tipo_tiempo=='DI') {
            $("#tiempo_hr_e").addClass("oculto"); 
            $("#tiempo_dias_e").removeClass("oculto"); 
            tiempo_dias_e.value=$scope.list_motivos[i].tiempo;
         }

    }
   }


   $("#motivos").modal('hide');
   $("#editar_motivos").modal('show');
  
   
}
 

$scope.btn_listado_permisos_list= function(){
            $http.get("php/parametros_permisos/crud_permisos.php?opc=trear_permisos").success(
                function(response) { 
                  if (response[0].id) {
                    $scope.list_permisos=response;
                     $(".caja-dere").addClass("oculto"); 
                     $("#div_listado").removeClass("oculto"); 
                  }
                        }) 
   
}

$scope.btn_crear_permiso_new= function(){
   Swal.fire({
    title: '¿Desea crear este nuevo tipo de permiso?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $vacio=0;
    if (name_permiso.value=='') {$vacio++; $("#name_permiso").addClass("vacio");}else{$("#name_permiso").removeClass("vacio");}
      if ($vacio>0) {
     Swal.fire({
                    title: 'Error',
                    text: 'Existen campos vacios' ,
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#1c4365',
                    cancelButtonColor: '#5b6771',
                    confirmButtonText: 'OK',
                     cancelButtonText: 'No'
                            })
 }else{
        $http.get("php/parametros_permisos/crud_permisos.php?opc=agg_new&nombre="+name_permiso.value+"&adjunto="+adjunto_permiso.value).success(
         function(response) { 
         if (response[0].ico=='success') {
           Swal.fire({title: response[0].title,text:  response[0].desc,icon: response[0].ico,showCancelButton: false,confirmButtonColor: '#1c4365',
             cancelButtonColor: '#5b6771',confirmButtonText: 'OK',cancelButtonText: 'No'})
            name_permiso.value='';
             $http.get("php/parametros_permisos/crud_permisos.php?opc=trear_permisos").success(
                function(response) { 
                  if (response[0].id) {
                    $scope.list_permisos=response;
                     $(".caja-dere").addClass("oculto"); 
                     $("#div_listado").removeClass("oculto"); 
                  }
                        })
         }else{
            Swal.fire({title: response[0].title,text:  response[0].desc,icon: response[0].ico,showCancelButton: false,confirmButtonColor: '#1c4365',
                    cancelButtonColor: '#5b6771',confirmButtonText: 'OK',cancelButtonText: 'No'})
         }
                        })
 }
 }}) 
}

$ide_permiso='';
$scope.agg_motivo= function($id, $name){
  $scope.list_motivos=[];
  $ide_permiso=$id;
  $("#tiempo_hr").addClass("oculto"); 
    $("#tiempo_dias").addClass("oculto"); 
    tipo_tiempo.value='NA';
  $scope.name_permiso_tipo=$name;
              $http.get("php/parametros_permisos/crud_permisos.php?opc=parametros_motivos&id="+$id).success(
                function(response) { 
                  if (response[0].id) {
                   $scope.list_motivos=response;
                  }
                  $(".caja-dere").addClass("oculto"); 
                  $("#div_agg_motivo").removeClass("oculto"); 
                           }) 
}

$scope.btn_crear_motivo_new= function(){
    $vacio=0;
     $time='';
    if (name_motivo.value=='') {$vacio++; $("#name_motivo").addClass("vacio");}else{$("#name_motivo").removeClass("vacio");}
    if (tipo_tiempo.value=='DI' && tiempo_dias.value=='') {$vacio++; $("#tiempo_dias").addClass("vacio");}else{$("#tiempo_dias").removeClass("vacio");  $time=tiempo_dias.value;}
    if (tipo_tiempo.value=='HR' && tiempo_hr.value=='') {$vacio++; $("#tiempo_hr").addClass("vacio");}else{$("#tiempo_hr").removeClass("vacio");  $time=tiempo_hr.value;}

      if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
    if (tipo_tiempo.value=='DI') {$time=tiempo_dias.value;}
     if (tipo_tiempo.value=='HR') {$time=tiempo_hr.value;}
        $http.get("php/parametros_permisos/crud_permisos.php?opc=agg_motivo&permiso="+$ide_permiso+"&descripcion="+name_motivo.value+"&tipo_tiempo="+tipo_tiempo.value+"&tiempo="+$time+"&leyenda="+leyenda.value+"&adjunto="+arc_adj.value+"&dias_adjunto="+dias_archivo.value).success(
         function(response) { 
                 if (response[0].id) {
                   $scope.list_motivos=response;
                  }
                  name_motivo.value='';
                    $("#tiempo_hr").addClass("oculto"); 
                    $("#tiempo_dias").addClass("oculto"); 
                    tipo_tiempo.value='NA';
                    arc_adj.value='No';
                    dias_archivo.value='';
                    leyenda.value='';
                        })
 }
}


$scope.btn_editar_motivo_new= function(){
    $vacio=0;
    $time='';
    if (name_motivo_e.value=='') {$vacio++; $("#name_motivo_e").addClass("vacio");}else{$("#name_motivo_e").removeClass("vacio");}
    if (tipo_tiempo_e.value=='DI' && tiempo_dias_e.value=='') {$vacio++; $("#tiempo_dias_e").addClass("vacio");}else{$("#tiempo_dias_e").removeClass("vacio");  $time=tiempo_dias_e.value;}
    if (tipo_tiempo_e.value=='HR' && tiempo_hr_e.value=='') {$vacio++; $("#tiempo_hr_e").addClass("vacio");}else{$("#tiempo_hr_e").removeClass("vacio");  $time=tiempo_hr_e.value;}

      if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
    if (tipo_tiempo_e.value=='DI') {$time=tiempo_dias_e.value;}
     if (tipo_tiempo_e.value=='HR') {$time=tiempo_hr_e.value;}
     console.log("php/parametros_permisos/crud_permisos.php?opc=editar_motivo&id_motivo="+$id_motivo_edit+"&descripcion="+name_motivo_e.value+"&tipo_tiempo="+tipo_tiempo_e.value+"&tiempo="+$time+"&leyenda="+leyenda_e.value+"&adjunto="+arc_adj_e.value+"&dias_adjunto="+dias_archivo_e.value+"&status="+status_permiso.value);
        $http.get("php/parametros_permisos/crud_permisos.php?opc=editar_motivo&id_motivo="+$id_motivo_edit+"&descripcion="+name_motivo_e.value+"&tipo_tiempo="+tipo_tiempo_e.value+"&tiempo="+$time+"&leyenda="+leyenda_e.value+"&adjunto="+arc_adj_e.value+"&dias_adjunto="+dias_archivo_e.value+"&status="+status_permiso.value).success(
         function(response) { 
                 if (response[0].id) {
                   $scope.list_motivos=response;
                  }
                 $("#motivos").modal('show');
                  $("#editar_motivos").modal('hide');
                        })
 }
}

$scope.btn_eliminar_motivo= function($id){
   Swal.fire({
    title: '¿Desea eliminar este motivo?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_menus=[];
  $http.get("php/parametros_permisos/crud_permisos.php?opc=eliminar_motivo&id="+$id+"&permiso="+$ide_permiso).success(
         function(response) { 
         if (response[0].id) {
                   $scope.list_motivos=response;
                  }else{
                    $scope.list_motivos=[];
                  }


                        })
 }}) 
}


$scope.btn_eliminar_permiso= function($id){
   Swal.fire({
    title: '¿Desea eliminar este permiso?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_menus=[];
  $http.get("php/parametros_permisos/crud_permisos.php?opc=eliminar_permiso&id="+$id).success(
         function(response) { 
         if (response[0].id) {
                   $scope.list_permisos=response;
                  }else{
                    $scope.list_permisos=[];
                  }


                        })
 }}) 
}


$scope.div_supervisores= function(){
          $http.get("php/funcionarios/crud_funcionarios.php?opc=traer_supervisores").success(
         function(response) { 
                 if (response[0].id) {
                   $scope.list_supervisores=response;
                  }
                  rut_supervisor.value='';
                  name_supervisor.value='';
                   $(".caja-dere").addClass("oculto"); 
                   $("#div_supervisores").removeClass("oculto"); 
                        })
 
   
}

document.getElementById('rut_supervisor').addEventListener('input', function(evt) {
  let value = this.value.replace(/\./g, '').replace('-', '');
  
  if (value.match(/^(\d{2})(\d{3}){2}(\w{1})$/)) {
    value = value.replace(/^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3}){2}(\w{0,1})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{3})(\w{0,1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3})(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{0,2})$/, '$1.$2.$3');
  }
  else if (value.match(/^(\d)(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{0,2})$/, '$1.$2');
  }
  this.value = value;
});

document.getElementById('rut_funcionario').addEventListener('input', function(evt) {
  let value = this.value.replace(/\./g, '').replace('-', '');
  
  if (value.match(/^(\d{2})(\d{3}){2}(\w{1})$/)) {
    value = value.replace(/^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3}){2}(\w{0,1})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{3})(\w{0,1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3})(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{0,2})$/, '$1.$2.$3');
  }
  else if (value.match(/^(\d)(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{0,2})$/, '$1.$2');
  }
  this.value = value;
});


 $("#rut_supervisor").keyup(function(){
           $http.get("php/funcionarios/crud_funcionarios.php?opc=un_funcionario&rut="+rut_supervisor.value).success(
             function(response) { 
                 if (response[0].id) {
                   name_supervisor.value=response[0].nombre+" "+response[0].apellido_p+" "+response[0].apellido_m;
                  } 
                })
  });

  $("#rut_funcionario").keyup(function(){
           $http.get("php/funcionarios/crud_funcionarios.php?opc=un_funcionario&rut="+rut_funcionario.value).success(
             function(response) { 
                 if (response[0].id) {
                   name_funcionaro.value=response[0].nombre+" "+response[0].apellido_p+" "+response[0].apellido_m;
                  } 
                })
  });


$scope.btn_agg_supervisor= function(){
    $vacio=0;
    if (rut_supervisor.value=='') {$vacio++; $("#rut_supervisor").addClass("vacio");}else{$("#rut_supervisor").removeClass("vacio");}
     if (name_supervisor.value=='') {$vacio++; $("#name_supervisor").addClass("vacio");}else{$("#name_supervisor").removeClass("vacio");}
      if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
       $http.get("php/funcionarios/crud_funcionarios.php?opc=agg_supervisor&nombre="+name_supervisor.value+"&rut="+rut_supervisor.value).success(
         function(response) { 
                 if (response[0].id) {
                   $scope.list_supervisores=response;
                  }
                  rut_supervisor.value='';
                  name_supervisor.value='';
                        })
 }
}

$scope.btn_eliminar_supervisor= function($id){
   Swal.fire({
    title: '¿Desea eliminar este supervisor?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_menus=[];
  $http.get("php/funcionarios/crud_funcionarios.php?opc=eliminar_supervisor&id="+$id).success(
         function(response) { 
         if (response[0].id) {
                   $scope.list_supervisores=response;
                  }else{
                    $scope.list_supervisores=[];
                  }


                        })
 }}) 
}

$scope.listado_funcionarios= function(){
   $scope.list_funcionarios=[];
            $http.get("php/funcionarios/crud_funcionarios.php?opc=todos_funcionarios").success(
                function(response) { 
                  if (response[0].id) {
                    $scope.list_funcionarios=response;
                    buscador_f.value='';
                     $(".caja-dere").addClass("oculto"); 
                     $("#div_funcionarios").removeClass("oculto"); 
                  }
                        })  
}

$scope.listado_exfuncionarios= function(){
   $scope.list_funcionarios=[];
   console.log("php/funcionarios/crud_funcionarios.php?opc=todos_exfuncionarios");

            $http.get("php/funcionarios/crud_funcionarios.php?opc=todos_exfuncionarios").success(
                function(response) { 
                  if (response[0].id) {
                    $scope.list_funcionarios=response;
                    buscador_f.value='';
                     $(".caja-dere").addClass("oculto"); 
                     $("#div_funcionarios").removeClass("oculto"); 
                  }
                        })  
}

jQuery('#tipo_tiempo').on('change',  (function() {
 if (tipo_tiempo.value=='NA') {
    $("#tiempo_hr").addClass("oculto"); 
    $("#tiempo_dias").addClass("oculto"); 
 }

 if (tipo_tiempo.value=='HR') {
    $("#tiempo_hr").removeClass("oculto"); 
    $("#tiempo_dias").addClass("oculto"); 
 }
 if (tipo_tiempo.value=='DI') {
    $("#tiempo_hr").addClass("oculto"); 
    $("#tiempo_dias").removeClass("oculto"); 
 }

  }));


jQuery('#tipo_tiempo_e').on('change',  (function() {
 if (tipo_tiempo_e.value=='NA') {
    $("#tiempo_hr_e").addClass("oculto"); 
    $("#tiempo_dias_e").addClass("oculto"); 
 }

 if (tipo_tiempo_e.value=='HR') {
    $("#tiempo_hr_e").removeClass("oculto"); 
    $("#tiempo_dias_e").addClass("oculto"); 
 }
 if (tipo_tiempo_e.value=='DI') {
    $("#tiempo_hr_e").addClass("oculto"); 
    $("#tiempo_dias_e").removeClass("oculto"); 
 }

  }));

$id_supervisor='';
$scope.list_victulados=[];
$scope.agg_vinculo_neew= function($id, $name){
  $id_supervisor=$id;
  name_sup_reonly.value=$name;
  rut_funcionario.value='';
  name_funcionaro.value='';
            $http.get("php/supervisores/curd_supervisores.php?opc=trear_vinculados&id="+$id).success(
                function(response) { 
                  if (response[0].id) {
                    $scope.list_victulados=response;
                    }else{
                    $scope.list_victulados=[];
                    }
                    $(".caja-dere").addClass("oculto"); 
                    $("#div_vinculacion").removeClass("oculto"); 
                        }) 
}


$scope.btn_agg_viculacion= function(){
    $vacio=0;
    if (name_sup_reonly.value=='') {$vacio++; $("#name_sup_reonly").addClass("vacio");}else{$("#name_sup_reonly").removeClass("vacio");}
     if (rut_funcionario.value=='') {$vacio++; $("#rut_funcionario").addClass("vacio");}else{$("#rut_funcionario").removeClass("vacio");}
     if (name_funcionaro.value=='') {$vacio++; $("#name_funcionaro").addClass("vacio");}else{$("#name_funcionaro").removeClass("vacio");}
      if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
        $http.get("php/supervisores/curd_supervisores.php?opc=agg_vinculacion&nombre="+name_funcionaro.value+"&id_funcionario="+rut_funcionario.value
        +"&id_supervisor="+$id_supervisor).success(
         function(response) { 
                 if (response[0].id) {
                   $scope.list_victulados=response;
                  }
                  rut_funcionario.value='';
                  name_funcionaro.value='';
                        })
 }
}

$scope.btn_eliminar_vinculo= function($id, $id_sup){
   Swal.fire({
    title: '¿Desea eliminar este vinculo?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_menus=[];
  $http.get("php/supervisores/curd_supervisores.php?opc=eliminar_vinculo&id="+$id+"&supervisor="+$id_sup).success(
         function(response) { 
         if (response[0].id) {
                   $scope.list_victulados=response;
                  }else{
                    $scope.list_victulados=[];
                  }


                        })
 }}) 
}

$id_duncionario='';
$scope.btn_editar_f= function($id, $rut, $nombre, $ap_p, $ap_m, $correo, $lun, $mar, $mie, $jue, $vie, $tipo_f, $topo_h, $hr_s, $hr_d, $sab, $cp){
     $id_duncionario=$id;
    correo_funcionario2.value=$cp;
    nombre_funcionario.value=$nombre+" "+$ap_p+" "+$ap_m;
    rut_funcionario_ed.value=$rut;
    correo_funcionario.value=$correo;
    hr_lun.value=$lun;
    hr_mar.value=$mar;
    hr_mie.value=$mie;
    hr_jue.value=$jue;
    hr_vie.value=$vie;
    hr_sab.value=$sab;
    tipo_funcionario.value=$tipo_f;
    tipo_horario.value=$topo_h;
    hr_semanal.value=$hr_s;
    hr_anno.value=$hr_d;
    $("#nombre_funcionario").attr("readonly","readonly");
    $("#rut_funcionario_ed").attr("readonly","readonly");
    $("#btn_editar_f").removeClass("oculto"); 
    $("#btn_crear_f").addClass("oculto"); 
   $("#modal_funcionarios").modal('show');   
}


document.getElementById('rut_funcionario_ed').addEventListener('input', function(evt) {
  let value = this.value.replace(/\./g, '').replace('-', '');
  
  if (value.match(/^(\d{2})(\d{3}){2}(\w{1})$/)) {
    value = value.replace(/^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3}){2}(\w{0,1})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{3})(\w{0,1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3})(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{0,2})$/, '$1.$2.$3');
  }
  else if (value.match(/^(\d)(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{0,2})$/, '$1.$2');
  }
  this.value = value;
});

$scope.btn_crear_f= function(){
    nombre_funcionario.value='';
    rut_funcionario_ed.value='';
    correo_funcionario.value='';
    hr_lun.value='';
    hr_mar.value='';
    hr_mie.value='';
    hr_jue.value='';
    hr_vie.value='';
    hr_sab.value='';
    tipo_funcionario.value='';
    tipo_horario.value='';
    hr_semanal.value='';
    hr_anno.value='';
    $("#nombre_funcionario").removeAttr("readonly");
    $("#rut_funcionario_ed").removeAttr("readonly");
    $("#btn_editar_f").addClass("oculto"); 
    $("#btn_crear_f").removeClass("oculto"); 
   $("#modal_funcionarios").modal('show');   
}
$scope.btn_editar_funcionario= function(){
    $vacio=0;
    if (nombre_funcionario.value=='') {$vacio++; $("#nombre_funcionario").addClass("vacio");}else{$("#nombre_funcionario").removeClass("vacio");}
     if (rut_funcionario_ed.value=='') {$vacio++; $("#rut_funcionario_ed").addClass("vacio");}else{$("#rut_funcionario_ed").removeClass("vacio");}
     if (correo_funcionario.value=='') {$vacio++; $("#correo_funcionario").addClass("vacio");}else{$("#correo_funcionario").removeClass("vacio");}
     $con=0;
      $con=(parseFloat(hr_lun.value.charAt(0)+hr_lun.value.charAt(1))+(parseFloat(hr_lun.value.charAt(3)+hr_lun.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_mar.value.charAt(0)+hr_mar.value.charAt(1))+(parseFloat(hr_mar.value.charAt(3)+hr_mar.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_mie.value.charAt(0)+hr_mie.value.charAt(1))+(parseFloat(hr_mie.value.charAt(3)+hr_mie.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_jue.value.charAt(0)+hr_jue.value.charAt(1))+(parseFloat(hr_jue.value.charAt(3)+hr_jue.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_vie.value.charAt(0)+hr_vie.value.charAt(1))+(parseFloat(hr_vie.value.charAt(3)+hr_vie.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_sab.value.charAt(0)+hr_sab.value.charAt(1))+(parseFloat(hr_sab.value.charAt(3)+hr_sab.value.charAt(4))/60));
      $con=Math.ceil($con);
      //console.log($con+' != '+hr_semanal.value);
       if (parseFloat($con)!=parseFloat(hr_semanal.value)) {
        alert('Las horas de los dias no coinciden con las horas semanales');
        return 0;
      }
      if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
         $http.get("php/funcionarios/crud_funcionarios.php?opc=editar_funcionario&id="+$id_duncionario+"&correo="+correo_funcionario.value
            +"&tipo_funcionario="+tipo_funcionario.value+"&tipo_horario="+tipo_horario.value+"&hr_anno="+hr_anno.value+"&hr_semanal="+hr_semanal.value
            +"&lunes="+hr_lun.value+"&martes="+hr_mar.value+"&miercoles="+hr_mie.value+"&jueves="+hr_jue.value+"&viernes="+hr_vie.value+"&sabado="+hr_sab.value+"&correo2="+correo_funcionario2.value).success(
         function(response) { 
                 if (response[0].id) {
                   $scope.list_funcionarios=response;
                  }
                  $("#modal_funcionarios").modal('hide');   
                        })
 }
}

$scope.btn_crear_funcionario= function(){
    $vacio=0;
    if (nombre_funcionario.value=='') {$vacio++; $("#nombre_funcionario").addClass("vacio");}else{$("#nombre_funcionario").removeClass("vacio");}
     if (rut_funcionario_ed.value=='') {$vacio++; $("#rut_funcionario_ed").addClass("vacio");}else{$("#rut_funcionario_ed").removeClass("vacio");}
     if (correo_funcionario.value=='') {$vacio++; $("#correo_funcionario").addClass("vacio");}else{$("#correo_funcionario").removeClass("vacio");}
     $con=0;
      $con=(parseFloat(hr_lun.value.charAt(0)+hr_lun.value.charAt(1))+(parseFloat(hr_lun.value.charAt(3)+hr_lun.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_mar.value.charAt(0)+hr_mar.value.charAt(1))+(parseFloat(hr_mar.value.charAt(3)+hr_mar.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_mie.value.charAt(0)+hr_mie.value.charAt(1))+(parseFloat(hr_mie.value.charAt(3)+hr_mie.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_jue.value.charAt(0)+hr_jue.value.charAt(1))+(parseFloat(hr_jue.value.charAt(3)+hr_jue.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_vie.value.charAt(0)+hr_vie.value.charAt(1))+(parseFloat(hr_vie.value.charAt(3)+hr_vie.value.charAt(4))/60));
      $con=parseFloat($con) +parseFloat(parseFloat(hr_sab.value.charAt(0)+hr_sab.value.charAt(1))+(parseFloat(hr_sab.value.charAt(3)+hr_sab.value.charAt(4))/60));
       $con=Math.ceil($con);
      if (parseFloat($con)!=parseFloat(hr_semanal.value)) {
      
        alert('Las horas de los dias no coinciden con las horas semanales');7
        return 0;
      }
      if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
         $http.get("php/funcionarios/crud_funcionarios.php?opc=crear_funcionario&nombre="+nombre_funcionario.value+"&rut="+rut_funcionario_ed.value+"&correo="+correo_funcionario.value
            +"&tipo_funcionario="+tipo_funcionario.value+"&tipo_horario="+tipo_horario.value+"&hr_anno="+hr_anno.value+"&hr_semanal="+hr_semanal.value
            +"&lunes="+hr_lun.value+"&martes="+hr_mar.value+"&miercoles="+hr_mie.value+"&jueves="+hr_jue.value+"&viernes="+hr_vie.value+"&sabado="+hr_sab.value+"&correo2="+correo_funcionario2.value).success(
         function(response) { 
                 if (response[0].id) {
                   $scope.list_funcionarios=response;
                  }
                  $("#modal_funcionarios").modal('hide');   
                        })
 }
}

$scope.btn_eliminar_funcionario= function($id, $status, $rut){
   Swal.fire({
    title: '¿Desea cambiar el status de este funcionario?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_menus=[];
  $http.get("php/funcionarios/crud_funcionarios.php?opc=eliminar_funcionario&id="+$id+"&status="+$status+"&rut="+$rut).success(
         function(response) { 
         if (response[0].id) {
                   $scope.list_funcionarios=response;
                  }else{
                    $scope.list_funcionarios=[];
                  }


                        })
 }}) 
}


 $("#buscador_f").keyup(function(){
     for (let i in $scope.list_funcionarios){
        if (buscador_f.value!=="") {
       index = 0;
       index = $scope.list_funcionarios[i].rut.indexOf(buscador_f.value);
       if (index<0){index = $scope.list_funcionarios[i].nombre.toUpperCase().indexOf(buscador_f.value.toUpperCase());}
       if (index<0){index = $scope.list_funcionarios[i].apellido_p.toUpperCase().indexOf(buscador_f.value.toUpperCase());}
       if (index<0){index = $scope.list_funcionarios[i].correo.toUpperCase().indexOf(buscador_f.value.toUpperCase());}
       if (index<0){index = $scope.list_funcionarios[i].tipo_f.toUpperCase().indexOf(buscador_f.value.toUpperCase());}
        if (index<0){index = $scope.list_funcionarios[i].horario.toUpperCase().indexOf(buscador_f.value.toUpperCase());}
      if(index >= 0) {
           $scope.list_funcionarios[i].foto=i;
       } else {
           $scope.list_funcionarios[i].foto='oculto';
       }
      }else{
        $scope.list_funcionarios[i].foto=i;
      }
     }
      $scope.$apply();         
  });

$scope.blanqueo_f= function(){
  buscador_f.value='';
  for (let i in $scope.list_funcionarios){
  $scope.list_funcionarios[i].foto=i;
      }
        $scope.$apply();       
}


$scope.detalle_horario=[];
$scope.btn_ver_horario= function($rt){
    $http.get("php/horarios/crud_horarios.php?opc=horario_funcionario&rut="+$rt).success(
         function(response) { 
         if (response[0].id) {
                   $scope.detalle_horario=response;
                  }else{
                    $scope.detalle_horario=[];
                  }
         })
   $("#modal_horario").modal('show');
 }

$scope.list_permisos
$scope.btn_listado_permisos= function(){
  $(".caja-dere").addClass("oculto"); 
   $("#div_list_permisos").removeClass("oculto"); 
       $http.get("php/permisos/crud_permisos_funcionarios.php?opc=traer_todos_los_permisos").success(
         function(response) { 
         if (response[0].id) {
                   $scope.list_permisos=response;
                  }else{
                    $scope.list_permisos=[];
                  }
         })
}

 $("#buscador_lp").keyup(function(){
     for (let i in $scope.list_permisos){
        if (buscador_lp.value!=="") {
       index = 0;
       index = $scope.list_permisos[i].rut.indexOf(buscador_lp.value);
       if (index<0){index = $scope.list_permisos[i].name.toUpperCase().indexOf(buscador_lp.value.toUpperCase());}
       if (index<0){index = $scope.list_permisos[i].tipo_permiso.toUpperCase().indexOf(buscador_lp.value.toUpperCase());}
       if (index<0){index = $scope.list_permisos[i].motivo.toUpperCase().indexOf(buscador_lp.value.toUpperCase());}
       if (index<0){index = $scope.list_permisos[i].status.toUpperCase().indexOf(buscador_lp.value.toUpperCase());}
        if (index<0){index = $scope.list_permisos[i].fi.indexOf(buscador_lp.value.toUpperCase());}
        if (index<0){index = $scope.list_permisos[i].ff.indexOf(buscador_lp.value.toUpperCase());}
      if(index >= 0) {
           $scope.list_permisos[i].foto=i;
       } else {
           $scope.list_permisos[i].foto='oculto';
       }
      }else{
        $scope.list_permisos[i].foto=i;
      }
     }
      $scope.$apply();         
  });

$scope.blanqueo_lp= function(){
  buscador_lp.value='';
  for (let i in $scope.list_permisos){
  $scope.list_permisos[i].foto=i;
      }
        $scope.$apply();       
}


$scope.btn_aprobar_permiso= function($id, $status){
  if ($status=='Aprobado') {return 0;}
   Swal.fire({
    title: '¿Desea aprobar este permiso?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_permisos=[];
       $http.get("php/permisos/crud_permisos_funcionarios.php?opc=aprobar_permiso&id="+$id+"&id_sup=1").success(
         function(response) { 
            $http.get("php/permisos/crud_permisos_funcionarios.php?opc=traer_todos_los_permisos").success(
               function(response) { 
               if (response[0].id) {
                         $scope.list_permisos=response;
                        }else{
                          $scope.list_permisos=[];
                        }
               })
                     $http.get("php/mails/mail_aprobado.php?id="+$id).success(
                           function(response) {    })
         })

 }}) 
}


jQuery('#hr_semanal').on('change',  (function() {
 console.log('cambia');
 if (hr_semanal.value>=45) {
  hr_anno.value=27;
 }else{
  hr_anno.value=Math.ceil((hr_semanal.value/45)*27);
 }
 } ));


//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
 $ft='';
 $scope.horario=[];
 $scope.datos_funcionario=[];
 $id_sup='';
 $receso_i='';
 $receso_f='';
 $hora_receso_i='';
 $min_receso_i='';
 $hora_receso_f='';
 $min_receso_f='';

document.getElementById('rut_fun').addEventListener('input', function(evt) {
  let value = this.value.replace(/\./g, '').replace('-', '');
  
  if (value.match(/^(\d{2})(\d{3}){2}(\w{1})$/)) {
    value = value.replace(/^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3}){2}(\w{0,1})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{3})(\w{0,1})$/, '$1.$2.$3-$4');
  }
  else if (value.match(/^(\d)(\d{3})(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{3})(\d{0,2})$/, '$1.$2.$3');
  }
  else if (value.match(/^(\d)(\d{0,2})$/)) {
    value = value.replace(/^(\d)(\d{0,2})$/, '$1.$2');
  }
  this.value = value;
});

jQuery('#rut_fun').on('change',  (function() {
          $http.get("php/funcionarios/crud_funcionarios.php?opc=un_funcionario&rut="+rut_fun.value).success(
                function(response) { 
                  if (response[0].rut) {
                 name_fun.value=response[0].nombre+' '+response[0].apellido_p;
                                     $http.get("php/funcionarios/crud_funcionarios.php?opc=un_funcionario&rut="+response[0].rut).success(
                function(resp_horario) {
                   $scope.datos_funcionario=resp_horario;
                  })

              $http.get("php/horarios/crud_horarios.php?opc=horario_funcionario&rut="+response[0].rut).success(
                function(resp_horario) {
                   $scope.horario=resp_horario;
                   if ($scope.horario[0].nombre=='Normal') {
                     $receso_i=$scope.horario[0].receso_i;
                     $receso_f=$scope.horario[0].receso_f;
                     $hora_receso_i=$scope.horario[0].receso_i.charAt(0)+$scope.horario[0].receso_i.charAt(1);
                     $min_receso_i=$scope.horario[0].receso_i.charAt(3)+$scope.horario[0].receso_i.charAt(4);
                     $hora_receso_f=$scope.horario[0].receso_f.charAt(0)+$scope.horario[0].receso_f.charAt(1);
                     $min_receso_f=$scope.horario[0].receso_f.charAt(3)+$scope.horario[0].receso_f.charAt(4);
                   }
                  })
                  } else{
                    rut_fun.value='';
                  }
                          })


 } ));

$scope.div_crear_permiso= function(){
    $http.get("php/parametros_permisos/crud_permisos.php?opc=trear_permisos").success(
     function(response) { 
       if (response[0].id) {
          $scope.list_permisos=response;
            $(".caja-dere").addClass("oculto"); 
            $("#div_crear_permisoe").removeClass("oculto"); 
             $("#btn_crear_p").removeClass("oculto"); 
             $("#btn_editar_p").addClass("oculto"); 
                  }
                        })   
}
jQuery('#tipo_permiso').on('change',  (function() {
     $scope.leyenda='';
         $http.get("php/parametros_permisos/crud_permisos.php?opc=parametros_motivos_user&id="+tipo_permiso.value).success(
                function(response) { 
                  if (response[0].id) {
                   $scope.list_motivos=response;
                  }else{
                    $scope.list_motivos=[];
                  }
                          })


 } ));

jQuery('#cbox1').on('change',  (function() {
      if( $('#cbox1').prop('checked') ) {
        ff.value=fi.value;
        hi.value=$hora_min_fi;
        hf.value=$hora_max_fi;
       
         $("#ff").attr("readonly","readonly");
         $("#hi").attr("readonly","readonly");
         $("#hf").attr("readonly","readonly");
         $("#hp").attr("readonly","readonly");

       if (hi.value!='' && hf.value!='') {
        $hrini=hi.value.charAt(0)+hi.value.charAt(1);
        $hrfin=hf.value.charAt(0)+hf.value.charAt(1);
        $minini=hi.value.charAt(3)+hi.value.charAt(4);
        $minfin=hf.value.charAt(3)+hf.value.charAt(4);
        $hr_receso=$scope.horario[0].receso_t.charAt(0)+$scope.horario[0].receso_t.charAt(1);
        $min_receso=$scope.horario[0].receso_t.charAt(3)+$scope.horario[0].receso_t.charAt(4);
         $minfin=$minfin-$min_receso;
        $hrfin=$hrfin-$hr_receso;
         if (parseInt($minfin)<parseInt($minini)) {
           $minfin= parseInt($minfin)+parseInt(60);
           $hrfin=parseInt($hrfin)-1;
        }
        $min_total=parseInt($minfin)-parseInt($minini);
        $hr_total=parseInt($hrfin)-parseInt($hrini);
        if (parseInt($min_total)<10) {$min_total='0'+$min_total;}
        if (parseInt($hr_total)<10) {$hr_total='0'+$hr_total;}
        $cal_total=$hr_total+':'+$min_total;
        hp.value=$cal_total;

            minutos_totales_disp=0;
            minutos_totales_disp=$scope.datos_funcionario[0].hr_disp.charAt(0)+$scope.datos_funcionario[0].hr_disp.charAt(1);
            minutos_totales_disp=minutos_totales_disp*60;
            minutos_totales_disp=parseInt(minutos_totales_disp)+parseInt(($scope.datos_funcionario[0].hr_disp.charAt(3)+$scope.datos_funcionario[0].hr_disp.charAt(4)));
            console.log(minutos_totales_disp);
            min_permiso=0;
             min_permiso=$cal_total.charAt(0)+$cal_total.charAt(1);
            min_permiso=min_permiso*60;
            min_permiso=parseInt(min_permiso)+parseInt(($cal_total.charAt(3)+$cal_total.charAt(4)));
            console.log(min_permiso);
            if (parseInt(minutos_totales_disp)<parseInt(min_permiso)) {
                alert('El permiso solicitado supera las horas disponibles, en caso de que este seaa aprobador se les descontara la diferencia');
            }
    }
        }else{
            ff.value='';
            hi.value='';
            hf.value='';
            hp.value='';
             $("#ff").removeAttr("readonly");
              $("#hi").removeAttr("readonly");
              $("#hf").removeAttr("readonly");
                $("#hp").removeAttr("readonly");
        }
 } ));

$permiso_descuento='SI';
jQuery('#cbox2').on('change',  (function() {
      if( $('#cbox2').prop('checked') ) {
       $permiso_descuento='SI';
        }else{
        $permiso_descuento='NO';
        }
 } ));

$tipo_tiempo='';
$tiempo_motivo='';
$scope.leyenda='';
const $miCheckbox = document.querySelector("#cbox2")
 jQuery('#motivo').on('change',  (function() {
      for (let i in $scope.list_motivos){
        if ($scope.list_motivos[i].id==motivo.value) {
            $scope.leyenda='';
            $tipo_tiempo=$scope.list_motivos[i].tipo_tiempo;
            $tiempo_motivo=$scope.list_motivos[i].tiempo;
            $scope.leyenda=$scope.list_motivos[i].leyenda;
             $scope.$apply();      
            if ($tipo_tiempo=='DI') {
               $(".fhf").removeClass("oculto");  
               $(".hrs").addClass("oculto");  
               $("#hi").attr("readonly","readonly");
               $("#hf").attr("readonly","readonly");
               if (parseInt($tiempo_motivo)>0) {
                 $("#ff").attr("readonly","readonly");
               }
           }
            if ($tipo_tiempo=='HR') {
                $miCheckbox.checked = true;
               $(".hrs").removeClass("oculto"); 
               $(".fhf").removeClass("oculto");  
                fi.value=$fecha;
                hi.value='';
                hf.value='';
                ht.value=$tiempo_motivo;

                    var Xmas95 = new Date(fi.value);
                     weekday = Xmas95.getDay();
                     if (weekday==0) {
                       $hora_min_fi=$scope.horario[0].lun_entrada;
                       $hora_max_fi=$scope.horario[0].lun_salida;
                    }
                    if (weekday==1) {
                       $hora_min_fi=$scope.horario[0].mar_entrada;
                       $hora_max_fi=$scope.horario[0].mar_salido;
                    }
                    if (weekday==2) {
                       $hora_min_fi=$scope.horario[0].mie_entrada;
                       $hora_max_fi=$scope.horario[0].mie_salida;
                    }
                    if (weekday==3) {
                       $hora_min_fi=$scope.horario[0].jue_entrada;
                       $hora_max_fi=$scope.horario[0].jue_salida;
                    }
                    if (weekday==4) {
                       $hora_min_fi=$scope.horario[0].vie_entrada;
                       $hora_max_fi=$scope.horario[0].vie_salida;
                    }
                    if (weekday==5) {
                       $hora_min_fi=$scope.horario[0].sab_entrada;
                       $hora_max_fi=$scope.horario[0].sab_salida;
                       if ($hora_min_fi=='00:00') {
                         fi.value='';
                         ff.value='';
                         return 0;
                       }
                     }
                    if (weekday==6) {
                     fi.value='';
                     return 0;
                    }
                     if (tipo_permiso.value=='3' || tipo_permiso.value=='2') {
                        ff.value=fi.value;
                       $hora_min_ff=$hora_min_fi;
                       $hora_max_ff=$hora_max_fi; 
                       $scope.leyendaff='Su hora de inicio debe estar entre '+$hora_min_ff+' y '+$hora_max_ff; 
                     }
                     $scope.leyendafi='Su hora de inicio debe estar entre '+$hora_min_fi+' y '+$hora_max_fi;
                   $scope.$apply(); 
            }
             if ($tipo_tiempo=='NA') {
               $(".fhf").removeClass("oculto");  
               $(".hrs").addClass("oculto");  
               
           }

         
        }

      }
 }
));


$hora_min_fi='';
$hora_max_fi='';
$hora_min_ff='';
$hora_max_ff='';
$scope.leyendafi='';
jQuery('#fi').on('change',  (function() {
    hi.value='';
    ff.value='';
    hf.value='';
    hp.value='';
     if (tipo_permiso.value=='3') {
        ff.value=fi.value;
     }
 if ($tipo_tiempo=='HR') {
    var Xmas95 = new Date(fi.value);
     weekday = Xmas95.getDay();
     if (weekday==0) {
       $hora_min_fi=$scope.horario[0].lun_entrada;
       $hora_max_fi=$scope.horario[0].lun_salida;
    }
    if (weekday==1) {
       $hora_min_fi=$scope.horario[0].mar_entrada;
       $hora_max_fi=$scope.horario[0].mar_salido;
    }
    if (weekday==2) {
       $hora_min_fi=$scope.horario[0].mie_entrada;
       $hora_max_fi=$scope.horario[0].mie_salida;
    }
    if (weekday==3) {
       $hora_min_fi=$scope.horario[0].jue_entrada;
       $hora_max_fi=$scope.horario[0].jue_salida;
    }
    if (weekday==4) {
       $hora_min_fi=$scope.horario[0].vie_entrada;
       $hora_max_fi=$scope.horario[0].vie_salida;
    }
    if (weekday==5 || weekday==6) {
     alert('El dia seleccionado no es valido, elija un dia entre lunes y viernes');
     fi.value='';
     return 0;
    }
     $scope.leyendafi='Su hora de inicio debe estar entre '+$hora_min_fi+' y '+$hora_max_fi;
    }
 
   if ($tipo_tiempo=='DI') {
    $ban=fi.value.charAt(5)+fi.value.charAt(6)+'/'+fi.value.charAt(8)+fi.value.charAt(9)+'/'+fi.value.charAt(0)+fi.value.charAt(1)+fi.value.charAt(2)+fi.value.charAt(3);
     var TuFecha = new Date($ban);  
     var dias = parseInt($tiempo_motivo-1);
    TuFecha.setDate(TuFecha.getDate() + dias);
    $a=TuFecha.getFullYear();
    $m=(TuFecha.getMonth() + 1);
    $d=TuFecha.getDate();
    if (($m+'').length<2) {$m='0'+$m; console.log('agregue mes')}
         if (($d+'').length<2) {$d='0'+$d; console.log('agregue dia')}
            ff.value=$a+'-'+$m+'-'+$d;
           }
           $scope.$apply();   
 } ));


$scope.leyendaff='';
 jQuery('#ff').on('change',  (function() {
    hf.value='';
    hp.value='';
    if (hi.value=='') {
     alert('Primero debe elegir la hora de inicio del permiso');
     ff.value='';
     return 0;
    }
    /*if (fi.value!=ff.value) {
     alert('La fecha de inico debe ser igual a la de final del permiso');
     ff.value='';
     return 0;
    }*/

   if ($tipo_tiempo=='HR') {
    var Xmas95 = new Date(ff.value);
     weekday = Xmas95.getDay();
     if (weekday==0) {
       $hora_min_ff=$scope.horario[0].lun_entrada;
       $hora_max_ff=$scope.horario[0].lun_salida;
    }
    if (weekday==1) {
       $hora_min_ff=$scope.horario[0].mar_entrada;
       $hora_max_ff=$scope.horario[0].mar_salido;
    }
    if (weekday==2) {
       $hora_min_ff=$scope.horario[0].mie_entrada;
       $hora_max_ff=$scope.horario[0].mie_salida;
    }
    if (weekday==3) {
       $hora_min_ff=$scope.horario[0].jue_entrada;
       $hora_max_ff=$scope.horario[0].jue_salida;
    }
    if (weekday==4) {
       $hora_min_ff=$scope.horario[0].vie_entrada;
       $hora_max_ff=$scope.horario[0].vie_salida;
    }
    if (weekday==5 || weekday==6) {
     alert('El dia seleccionado no es valido, elija un dia entre lunes y viernes');
     ff.value='';
     return 0;
    }
     $scope.leyendaff='Su hora final debe estar entre '+$hora_min_ff+' y '+$hora_max_ff;
        $scope.$apply();   
    }
 }
));

$hrini=0;
$hrfin=0;
$minini=0;
$minfin=0;
$hr_total=0;
$min_total=0;
$cal_total='';

jQuery('#hi').on('change',  (function() {
     ff.value='';
    hf.value='';
    hp.value='';

 if (fi.value=='') {
    alert('Primero debes elegir el dia de comienzo del permiso');
    hi.value='';
    return 0;
 }
   if (tipo_permiso.value=='3' || tipo_permiso.value=='2') {
           ff.value=fi.value;
     }

 $hr_ingresada=hi.value.charAt(0)+hi.value.charAt(1)+hi.value.charAt(3)+hi.value.charAt(4);
  $hora_min=$hora_min_fi.charAt(0)+$hora_min_fi.charAt(1)+$hora_min_fi.charAt(3)+$hora_min_fi.charAt(4);
  $hora_max=$hora_max_fi.charAt(0)+$hora_max_fi.charAt(1)+$hora_max_fi.charAt(3)+$hora_max_fi.charAt(4);
  $hora_inicio_receso=$hora_receso_i+$min_receso_i;
  $hora_fin_receso=$hora_receso_f+$min_receso_f;

 if ($scope.horario[0].nombre=='Normal') {
      if (parseInt($hr_ingresada)>parseInt($hora_inicio_receso) && parseInt($hr_ingresada)<parseInt($hora_fin_receso)) {
    alert('La hora de inicio no puede estar entre su hora de receso, su hora de receso es desde las '+$scope.horario[0].receso_i+' hasta las '+$scope.horario[0].receso_f);
    hi.value='';
    return 0;
  }
 }
  

  if (parseInt($hr_ingresada)<parseInt($hora_min) || parseInt($hr_ingresada)>parseInt($hora_max)) {
    alert('La hora no esta entre los parametros establecidos');
    hi.value='';
    return 0;
  }

 }
));


 jQuery('#hf').on('change',  (function() {
 hp.value='';
 $ban=0;
 if (ff.value=='') {
    alert('Primero debes elegir el dia de comienzo del permiso');
    hf.value='';
    return 0;
 }
  $hr_ingresada=hf.value.charAt(0)+hf.value.charAt(1)+hf.value.charAt(3)+hf.value.charAt(4);
  $hora_min=$hora_min_ff.charAt(0)+$hora_min_ff.charAt(1)+$hora_min_ff.charAt(3)+$hora_min_ff.charAt(4);
  $hora_max=$hora_max_ff.charAt(0)+$hora_max_ff.charAt(1)+$hora_max_ff.charAt(3)+$hora_max_ff.charAt(4);
  console.log($hora_min_ff+" - "+$hora_max_ff);
  $hr_ingresada2=hi.value.charAt(0)+hi.value.charAt(1)+hi.value.charAt(3)+hi.value.charAt(4);
  $hora_inicio_receso=$hora_receso_i+$min_receso_i;
  $hora_fin_receso=$hora_receso_f+$min_receso_f;



    if (hi.value!='' && hf.value!='' && fi.value==ff.value) {
         if ($scope.horario[0].nombre=='Normal') {
           if (parseInt($hr_ingresada)>parseInt($hora_inicio_receso) && parseInt($hr_ingresada)<parseInt($hora_fin_receso)) {
                  alert('La hora de finalización no puede estar entre su hora de receso, su hora de receso es desde las '+$scope.horario[0].receso_i+' hasta las '+$scope.horario[0].receso_f);
                  hf.value='';
                  return 0;
                }
           if (parseInt($hr_ingresada2)<parseInt($hora_inicio_receso) && parseInt($hr_ingresada)>parseInt($hora_fin_receso) && fi.value==ff.value) {$ban=1; }
         }

          if (parseInt($hr_ingresada)<parseInt($hora_min) || parseInt($hr_ingresada)>parseInt($hora_max) || parseInt($hr_ingresada)<parseInt($hr_ingresada2)) {
            alert('La hora ingresada no es valida');
            hf.value='';
            return 0;
          }
        $hrini=hi.value.charAt(0)+hi.value.charAt(1);
        $hrfin=hf.value.charAt(0)+hf.value.charAt(1);
        $minini=hi.value.charAt(3)+hi.value.charAt(4);
        $minfin=hf.value.charAt(3)+hf.value.charAt(4);
        if (parseInt($minfin)<parseInt($minini)) {
           $minfin= parseInt($minfin)+parseInt(60);
           $hrfin=parseInt($hrfin)-1;
        }
          if ($ban==1) {
           $hr_receso=$scope.horario[0].receso_t.charAt(0)+$scope.horario[0].receso_t.charAt(1);
           $min_receso=$scope.horario[0].receso_t.charAt(3)+$scope.horario[0].receso_t.charAt(4);
          $minfin=$minfin-$min_receso;
          if (parseInt($minfin)<0) {$minfin=parseInt($minfin)+parseInt(60); $hrfin=parseInt($hrfin)-parseInt(1); }
          $hrfin=$hrfin-$hr_receso;
          } 
        $min_total=parseInt($minfin)-parseInt($minini);
        $hr_total=parseInt($hrfin)-parseInt($hrini);
        if (parseInt($min_total)<0) {$min_total=parseInt(60)+parseInt($min_total); $hr_total=$hr_total-1;}
        if (parseInt($min_total)<10) {$min_total='0'+$min_total;}
        if (parseInt($hr_total)<10) {$hr_total='0'+$hr_total;}
        $cal_total=$hr_total+':'+$min_total;
        hp.value=$cal_total;
    }

    if (hi.value!='' && hf.value!='' && fi.value!=ff.value) {
          var Xmas95 = new Date(fi.value);
           weekday1 = Xmas95.getDay();
           var Xmas95 = new Date(ff.value);
           weekday2 = Xmas95.getDay();
           $fechai=fi.value;
           $fechaf=ff.value;
           $fecha_ban_f=ff.value;

           //--------------------------------------------------------------------------------------
            $ban=$fechaf.charAt(5)+$fechaf.charAt(6)+'/'+$fechaf.charAt(8)+$fechaf.charAt(9)+'/'+$fechaf.charAt(0)+$fechaf.charAt(1)+$fechaf.charAt(2)+$fechaf.charAt(3);
               var TuFecha = new Date($ban);  
               var dias = parseInt(1);
                TuFecha.setDate(TuFecha.getDate() + dias);
                $a=TuFecha.getFullYear();
                $m=(TuFecha.getMonth() + 1);
                $d=TuFecha.getDate();
                if (parseInt($m<10)) {$m='0'+$m}
                    if (parseInt($d<10)) {$d='0'+$d}
                        $fechaf=$a+'-'+$m+'-'+$d;
           //---------------------------------------------------------------------------------------
           $horas_acumuladas=0;
           $minutos_acumulados=0;
        
          while($fechai!=$fechaf){
             $hra_entrada='';
            $hra_salida='';
             var Xmas95 = new Date($fechai);
                     weekday = Xmas95.getDay();
                     if (weekday==0) {
                       $hora_min_fi=$scope.horario[0].lun_entrada;
                       $hora_max_fi=$scope.horario[0].lun_salida;
                    }
                    if (weekday==1) {
                       $hora_min_fi=$scope.horario[0].mar_entrada;
                       $hora_max_fi=$scope.horario[0].mar_salido;
                    }
                    if (weekday==2) {
                       $hora_min_fi=$scope.horario[0].mie_entrada;
                       $hora_max_fi=$scope.horario[0].mie_salida;
                    }
                    if (weekday==3) {
                       $hora_min_fi=$scope.horario[0].jue_entrada;
                       $hora_max_fi=$scope.horario[0].jue_salida;
                    }
                    if (weekday==4) {
                       $hora_min_fi=$scope.horario[0].vie_entrada;
                       $hora_max_fi=$scope.horario[0].vie_salida;
                    }
                    if (weekday==5) {
                       $hora_min_fi=$scope.horario[0].sab_entrada;
                       $hora_max_fi=$scope.horario[0].sab_salida;
                       }
                      $hra_entrada=$hora_min_fi;
                      $hra_salida=$hora_max_fi;
                      $ban=0;
                     
            if ($fechai==fi.value) {
               $hra_entrada=hi.value;
                 $hr_ingresada=$hra_salida.charAt(0)+$hra_salida.charAt(1)+$hra_salida.charAt(3)+$hra_salida.charAt(4);
                       $hr_ingresada2=$hra_entrada.charAt(0)+$hra_entrada.charAt(1)+$hra_entrada.charAt(3)+$hra_entrada.charAt(4);
                       $hora_inicio_receso=$hora_receso_i+$min_receso_i;
                       $hora_fin_receso=$hora_receso_f+$min_receso_f;
                       if (parseInt($hr_ingresada2)<parseInt($hora_inicio_receso) && parseInt($hr_ingresada)>parseInt($hora_fin_receso) && fi.value!=ff.value) {$ban=1; }
         //---------------------------------------------------------------------------------
                        $hrini=$hra_entrada.charAt(0)+$hra_entrada.charAt(1);
                        $hrfin=$hra_salida.charAt(0)+$hra_salida.charAt(1);
                        $minini=$hra_entrada.charAt(3)+$hra_entrada.charAt(4);
                        $minfin=$hra_salida.charAt(3)+$hra_salida.charAt(4);
                        if (parseInt($minfin)<parseInt($minini)) {
                           $minfin= parseInt($minfin)+parseInt(60);
                           $hrfin=parseInt($hrfin)-1;
                        }
                          if ($ban==1) {
                           $hr_receso=$scope.horario[0].receso_t.charAt(0)+$scope.horario[0].receso_t.charAt(1);
                           $min_receso=$scope.horario[0].receso_t.charAt(3)+$scope.horario[0].receso_t.charAt(4);
                          $minfin=$minfin-$min_receso;
                          if (parseInt($minfin)<0) {$minfin=parseInt($minfin)+parseInt(60); $hrfin=parseInt($hrfin)-parseInt(1); }
                          $hrfin=$hrfin-$hr_receso;
                          } 
                        $min_total=parseInt($minfin)-parseInt($minini);
                        $hr_total=parseInt($hrfin)-parseInt($hrini);
                        if (parseInt($min_total)<0) {$min_total=parseInt(60)+parseInt($min_total); $hr_total=$hr_total-1;}
                        if (parseInt($min_total)<10) {$min_total='0'+$min_total;}
                        if (parseInt($hr_total)<10) {$hr_total='0'+$hr_total;}
                         $horas_acumuladas=parseInt($hr_total)+parseInt($horas_acumuladas);
                         $minutos_acumulados=parseInt($min_total)+parseInt($minutos_acumulados);
                        while ($minutos_acumulados>=60) {
                            $horas_acumuladas=parseInt($horas_acumuladas)+1;
                            $minutos_acumulados=$minutos_acumulados-60;
                        }
        //---------------------------------------------------------------------------------
            }else{
                if ($fechai==$fecha_ban_f) {
                    $hra_salida=hf.value;
                 } 
                   $hr_ingresada=$hra_salida.charAt(0)+$hra_salida.charAt(1)+$hra_salida.charAt(3)+$hra_salida.charAt(4);
                       $hr_ingresada2=$hra_entrada.charAt(0)+$hra_entrada.charAt(1)+$hra_entrada.charAt(3)+$hra_entrada.charAt(4);
                       $hora_inicio_receso=$hora_receso_i+$min_receso_i;
                       $hora_fin_receso=$hora_receso_f+$min_receso_f;
                       if (parseInt($hr_ingresada2)<parseInt($hora_inicio_receso) && parseInt($hr_ingresada)>parseInt($hora_fin_receso) && fi.value!=ff.value) {$ban=1; }
                         $hrini=$hra_entrada.charAt(0)+$hra_entrada.charAt(1);
                        $hrfin=$hra_salida.charAt(0)+$hra_salida.charAt(1);
                        $minini=$hra_entrada.charAt(3)+$hra_entrada.charAt(4);
                        $minfin=$hra_salida.charAt(3)+$hra_salida.charAt(4);
                        if (parseInt($minfin)<parseInt($minini)) {
                           $minfin= parseInt($minfin)+parseInt(60);
                           $hrfin=parseInt($hrfin)-1;
                        }
                          if ($ban==1) {
                           $hr_receso=$scope.horario[0].receso_t.charAt(0)+$scope.horario[0].receso_t.charAt(1);
                           $min_receso=$scope.horario[0].receso_t.charAt(3)+$scope.horario[0].receso_t.charAt(4);
                          $minfin=$minfin-$min_receso;
                          if (parseInt($minfin)<0) {$minfin=parseInt($minfin)+parseInt(60); $hrfin=parseInt($hrfin)-parseInt(1); }
                          $hrfin=$hrfin-$hr_receso;
                          } 
                        $min_total=parseInt($minfin)-parseInt($minini);
                        $hr_total=parseInt($hrfin)-parseInt($hrini);
                        if (parseInt($min_total)<0) {$min_total=parseInt(60)+parseInt($min_total); $hr_total=$hr_total-1;}
                        if (parseInt($min_total)<10) {$min_total='0'+$min_total;}
                        if (parseInt($hr_total)<10) {$hr_total='0'+$hr_total;}
                         $horas_acumuladas=parseInt($hr_total)+parseInt($horas_acumuladas);
                         $minutos_acumulados=parseInt($min_total)+parseInt($minutos_acumulados);
                        while ($minutos_acumulados>=60) {
                            $horas_acumuladas=parseInt($horas_acumuladas)+1;
                            $minutos_acumulados=$minutos_acumulados-60;
                        }
        //---------------------------------------------------------------------------------  
            }
               $ban=$fechai.charAt(5)+$fechai.charAt(6)+'/'+$fechai.charAt(8)+$fechai.charAt(9)+'/'+$fechai.charAt(0)+$fechai.charAt(1)+$fechai.charAt(2)+$fechai.charAt(3);
               var TuFecha = new Date($ban);  
               var dias = parseInt(1);
                TuFecha.setDate(TuFecha.getDate() + dias);
                $a=TuFecha.getFullYear();
                $m=(TuFecha.getMonth() + 1);
                $d=TuFecha.getDate();
                if (parseInt($m<10)) {$m='0'+$m}
                    if (parseInt($d<10)) {$d='0'+$d}
                        $fechai=$a+'-'+$m+'-'+$d;
             

           }
               if (parseInt($minutos_acumulados)<10) {$minutos_acumulados='0'+$minutos_acumulados;}
                if (parseInt($horas_acumuladas)<10) {$horas_acumuladas='0'+$horas_acumuladas;}
                $cal_total=$horas_acumuladas+':'+$minutos_acumulados;
                hp.value=$cal_total;
          
    }
            minutos_totales_disp=0;
            minutos_totales_disp=$scope.datos_funcionario[0].hr_disp.charAt(0)+$scope.datos_funcionario[0].hr_disp.charAt(1);
            minutos_totales_disp=minutos_totales_disp*60;
            minutos_totales_disp=parseInt(minutos_totales_disp)+parseInt(($scope.datos_funcionario[0].hr_disp.charAt(3)+$scope.datos_funcionario[0].hr_disp.charAt(4)));
            console.log(minutos_totales_disp);
            min_permiso=0;
             min_permiso=$cal_total.charAt(0)+$cal_total.charAt(1);
            min_permiso=min_permiso*60;
            min_permiso=parseInt(min_permiso)+parseInt(($cal_total.charAt(3)+$cal_total.charAt(4)));
            console.log(min_permiso);
            if (parseInt(minutos_totales_disp)<parseInt(min_permiso)) {
                alert('El permiso solicitado supera las horas disponibles, en caso de que este seaa aprobador se les descontara la diferencia');
            }

 }
));


$scope.btn_crear_permiso2= function(){
       $vacio=0;
    if (tipo_permiso.value=='0') {$vacio++; $("#tipo_permiso").addClass("vacio");}else{$("#tipo_permiso").removeClass("vacio");}
     if (motivo.value=='0') {$vacio++; $("#motivo").addClass("vacio");}else{$("#motivo").removeClass("vacio");}
     if (fi.value=='0') {$vacio++; $("#fi").addClass("vacio");}else{$("#fi").removeClass("vacio");}
       if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
    if ($tipo_tiempo=='DI') {$ht=$tiempo_motivo;}
    if ($tipo_tiempo=='HR') {$ht=hp.value;}
 
         var frm = document.getElementById('form1');
                                var data = new FormData(frm);
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function () {
                                    if (this.readyState == 4) {
                                        var msg = xhttp.responseText;
                                        if (msg == 'success') {
                                            alert(msg);
                                            $('#exampleModal').modal('hide')
                                        } else {
                                            
                                        }
                                    }
                                };
                                xhttp.open("POST", "php/permisos/crear_permiso_extra.php?permiso="+tipo_permiso.value+"&motivo="+motivo.value+"&fi="+fi.value
                                    +"&ff="+ff.value+"&hi="+hi.value+"&hf="+hf.value+"&ht="+$ht+"&observacion="+observacion.value+"&rut="+rut_fun.value+"&descuento="+$permiso_descuento, true);
                                xhttp.send(data);
                                $('#form1').trigger('reset');
                               // xhttp.onload = () => alert(xhttp.response);
                                    setTimeout(function(){
                                        window.location.reload();
                                    },1000);
 }
}


 $("#buscador_s").keyup(function(){
     for (let i in $scope.list_supervisores){
        if (buscador_s.value!=="") {
       index = 0;
       index = $scope.list_supervisores[i].nombre.toUpperCase().indexOf(buscador_s.value.toUpperCase());
      if(index >= 0) {
           $scope.list_supervisores[i].foto=i;
       } else {
           $scope.list_supervisores[i].foto='oculto';
       }
      }else{
        $scope.list_supervisores[i].foto=i;
      }
     }
      $scope.$apply();         
  });


$scope.listado_funcionarios_hr= function(){
   $scope.list_funcionarios=[];
            $http.get("php/funcionarios/crud_funcionarios.php?opc=todos_funcionarios_hr").success(
                function(response) { 
                  if (response[0].id) {
                    $scope.list_funcionarios=response;
                    buscador_f.value='';
                     $(".caja-dere").addClass("oculto"); 
                     $("#div_funcionarios_hr").removeClass("oculto"); 
                  }
                        })  
}


 



$scope.list_calendario=[];
$scope.div_calendario= function(){
  if (fi_calendario.value=='') {$("#fi_calendario").addClass("vacio"); console.log('ff1'); return 0;}else{$("#fi_calendario").removeClass("vacio");}
  if (ff_calendario.value=='') {$("#ff_calendario").addClass("vacio"); console.log('ff'); return 0;}else{$("#ff_calendario").removeClass("vacio");}
   $fecha_i_c=fi_calendario.value.charAt(0)+fi_calendario.value.charAt(1)+fi_calendario.value.charAt(2)+fi_calendario.value.charAt(3)+fi_calendario.value.charAt(5)+fi_calendario.value.charAt(6)+fi_calendario.value.charAt(8)+fi_calendario.value.charAt(9);
   $fecha_f_c=ff_calendario.value.charAt(0)+ff_calendario.value.charAt(1)+ff_calendario.value.charAt(2)+ff_calendario.value.charAt(3)+ff_calendario.value.charAt(5)+ff_calendario.value.charAt(6)+ff_calendario.value.charAt(8)+ff_calendario.value.charAt(9);
   $scope.list_calendario=[];
   if (parseInt($fecha_i_c)>parseInt($fecha_f_c)) {alert('La fecha de inicio no puede ser mayor que la fecha final'); return 0;}
     $http.get("php/permisos/crud_permisos_funcionarios.php?opc=permisos_calendario&fi="+$fecha_i_c+"&ff="+$fecha_f_c+"&tipo="+tipo_funcionario_c.value).success(
     function(response) { 
       if (response[0].id) {
          $scope.list_calendario=response;
            $(".caja-dere").addClass("oculto"); 
               $("#div_calendario").removeClass("oculto"); 
                $("#modal_pre_calendario").modal('hide');
                            }
              else{
                alert('No se encontraron resultados en el periodo seleccionado');
              }
                        })   
}

$scope.modal_dia= function(){
   $fecha_i_c=f_oculta.value.charAt(0)+f_oculta.value.charAt(1)+f_oculta.value.charAt(2)+f_oculta.value.charAt(3)+f_oculta.value.charAt(5)+f_oculta.value.charAt(6)+f_oculta.value.charAt(8)+f_oculta.value.charAt(9);
   $fecha_f_c=f_oculta.value.charAt(0)+f_oculta.value.charAt(1)+f_oculta.value.charAt(2)+f_oculta.value.charAt(3)+f_oculta.value.charAt(5)+f_oculta.value.charAt(6)+f_oculta.value.charAt(8)+f_oculta.value.charAt(9);
   $scope.list_calendario=[];
   if (parseInt($fecha_i_c)>parseInt($fecha_f_c)) {alert('La fecha de inicio no puede ser mayor que la fecha final'); return 0;}
   console.log();
     $http.get("php/permisos/crud_permisos_funcionarios.php?opc=permisos_calendario&fi="+$fecha_i_c+"&ff="+$fecha_f_c+"&tipo="+tipo_funcionario_c.value).success(
     function(response) { 
       if (response[0].id) {
          $scope.list_calendario=response;
             $("#modal_permisos_diarios").modal('show');
                            }
              else{
                alert('No se encontraron resultados en el periodo seleccionado');
              }
                        }) 

}


$scope.modal_pre_calendario= function(){
    $(".caja-dere").addClass("oculto"); 
    $("#div_calendario2").removeClass("oculto"); 
  // $("#modal_pre_calendario").modal('show');
    }

 
//--------------------------------------------------------------------------------------------------------------------------------
let monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre','Octubre', 'Noviembre', 'Diciembre'];

let currentDate = new Date();
let currentDay = currentDate.getDate();
let monthNumber = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

let dates = document.getElementById('dates');
let month = document.getElementById('month');
let year = document.getElementById('year');

let prevMonthDOM = document.getElementById('prev-month');
let nextMonthDOM = document.getElementById('next-month');

month.textContent = monthNames[monthNumber];
year.textContent = currentYear.toString();

prevMonthDOM.addEventListener('click', ()=>lastMonth());
nextMonthDOM.addEventListener('click', ()=>nextMonth());



const writeMonth = (month) => {
dates.innerHTML ='';
    for(let i = startDay(); i>0;i--){
        dates.innerHTML += ` <div class="calendar__date calendar__item calendar__last-days">
           
        </div>`;
    }

    for(let i=1; i<=getTotalDays(month); i++){

       let day_n=i;
       let mes_n=month+1;
       if (parseInt(day_n)<10) {day_n='0'+day_n.toString();}
       if (parseInt(mes_n)<10) {mes_n='0'+mes_n.toString();}
       let  $fech=currentYear+'-'+mes_n+'-'+day_n;
          setTimeout(function(){
          $http.get("php/permisos/crud_permisos_funcionarios.php?opc=permisos_calendario_dia&fecha="+$fech+"&dia="+day_n).success(
                function(response) { 
                     dates.innerHTML += ` <div onclick="myFunction('${response[0].fecha}')" class="calendar__date calendar__item"><spam class="n_dia">${response[0].dia}
                                            <div class="btn-azul m-2 p-2">
                                              <label class="label_input">${response[0].docentes} Docentes</label>
                                            </div>
                                            <div class="btn-rojizo m-2 p-2">
                                              <label class="label_input">${response[0].nodocentes} No Docentes</label>
                                            </div>
                                            <div class="btn-verde m-2 p-2">
                                              <label class="label_input">${response[0].auxiliares} Auxiliares</label>
                                            </div> 
                                          </spam></div>`;
                        }) 
              },500);

     
        
    }
}

const getTotalDays = month => {
    if(month === -1) month = 11;

    if (month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
        return  31;

    } else if (month == 3 || month == 5 || month == 8 || month == 10) {
        return 30;

    } else {

        return isLeap() ? 29:28;
    }
}

const isLeap = () => {
    return ((currentYear % 100 !==0) && (currentYear % 4 === 0) || (currentYear % 400 === 0));
}

const startDay = () => {
    let start = new Date(currentYear, monthNumber, 1);
    return ((start.getDay()-1) === -1) ? 6 : start.getDay()-1;
}

const lastMonth = () => {
    if(monthNumber !== 0){
        monthNumber--;
    }else{
        monthNumber = 11;
        currentYear--;
    }

    setNewDate();
}

const nextMonth = () => {
    if(monthNumber !== 11){
        monthNumber++;
    }else{
        monthNumber = 0;
        currentYear++;
    }

    setNewDate();
}

const setNewDate = () => {
    currentDate.setFullYear(currentYear,monthNumber,currentDay);
    month.textContent = monthNames[monthNumber];
    year.textContent = currentYear.toString();
    dates.textContent = '';
    writeMonth(monthNumber);
}

writeMonth(monthNumber);


//--------------------------------------------------------------------------------------------------------------------------





});