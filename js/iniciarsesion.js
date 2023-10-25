angular.module('angular', []).controller("comedorcontroller",function($scope, $http)
{
$sesion=[];
$tipo_registro='';
  $http.get("php/sesion/verificarsesion.php").success(
         function(response) {
         if (response[0].permiso=='0') {
         $("#caja_inicio_sesion").removeClass("oculto");
                                           }
        if (response[0].permiso=='admin') {
         window.location.href = "panel.php"; 
                                           }
        if (response[0].permiso=='Funcionario') {
         window.location.href = "funcionario.php"; 
      }

                        })

document.getElementById('input_rut').addEventListener('input', function(evt) {
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

document.getElementById('user').addEventListener('input', function(evt) {
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


$scope.btn_registrarse= function( ){
    input_rut.value="";
    nombre_pila.value="";
    pw_new_user.value="";
    confir_pw.value="";
   $("#registrarse").modal('show');
}

$scope.verificar_rut= function(){
    if (input_rut.value!=="") {
        $http.get("php/usuarios/traer_usuarios.php?opc=alunno_and_funcionario&rut="+input_rut.value).success(
         function(response) {
            if (response[0].name) {
              nombre_pila.value=response[0].name;  
              $tipo_registro=response[0].tipo;  
          }else{
           Swal.fire({
                    title: 'Error',
                    text: 'No encontramos este Rut en la base de datos' ,
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#1c4365',
                    cancelButtonColor: '#5b6771',
                    confirmButtonText: 'OK',
                     cancelButtonText: 'No'
                            })            
          }
                     })  
         }else{
              $("#input_rut").addClass("vacio"); 
          }
}

$scope.btn_registrarse_final= function(){
   Swal.fire({
    title: '¿Deseas registrarse?',
    text: "Recuerde su contraseña para evitar incovenientes",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $vacio=0;
    if (input_rut.value=='') {$vacio++; $("#input_rut").addClass("vacio");}else{$("#input_rut").removeClass("vacio");}
    if (nombre_pila.value=='') {$vacio++; $("#nombre_pila").addClass("vacio");}else{$("#nombre_pila").removeClass("vacio");}
    if (pw_new_user.value=='') {$vacio++; $("#pw_new_user").addClass("vacio");}else{$("#pw_new_user").removeClass("vacio");}
    if (confir_pw.value=='') {$vacio++; $("#confir_pw").addClass("vacio");}else{$("#confir_pw").removeClass("vacio");}
    if (confir_pw.value!==pw_new_user.value) {$vacio++; $("#confir_pw").addClass("vacio");}else{$("#confir_pw").removeClass("vacio");}
  
    if ($vacio>0) {
     Swal.fire({
                    title: 'Error',
                    text: 'Existen campos vacios o las contraseñas no coinciden' ,
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#1c4365',
                    cancelButtonColor: '#5b6771',
                    confirmButtonText: 'OK',
                     cancelButtonText: 'No'
                            })
 }else{
         $http.get("php/usuarios/agg_user.php?opc=C_alumno&user="+input_rut.value+"&pw="+pw_new_user.value+"&tipo="+$tipo_registro).success(
         function(response) { 
            Swal.fire({
                    title: response,
                    text: '' ,
                    icon: '',
                    showCancelButton: false,
                    confirmButtonColor: '#1c4365',
                    cancelButtonColor: '#5b6771',
                    confirmButtonText: 'OK',
                     cancelButtonText: 'No'
                            })
             $("#registrarse").modal('hide');
                      })
 }
 }}) 
}

$scope.btn_iniciar_sesion= function(){
   $vacio=0;
   if (user.value=='') {$vacio++; $("#user").addClass("vacio");}else{$("#user").removeClass("vacio");}
   if (pw.value=='') {$vacio++; $("#pw").addClass("vacio");}else{$("#pw").removeClass("vacio");}
     if ($vacio>0) {
           Swal.fire({
                    title: 'Error',
                    text: 'Existen campos vacios' ,
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#1c4365',
                    cancelButtonColor: '#5b6771',
                    confirmButtonText: 'OK',
                     cancelButtonText: 'No'
                            })
       }
       else{
           $http.get("php/sesion/iniciarsesion.php?user="+user.value+"&pw="+pw.value).success(
         function(response) {
         if (response[0].permiso=='0') {
                    Swal.fire({
                    title: 'Error',
                    text: 'El usuario y/o contraseña estan erradas, por favor intentelo nuevamente' ,
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#1c4365',
                    cancelButtonColor: '#5b6771',
                    confirmButtonText: 'OK',
                     cancelButtonText: 'No'
                            })
                                           }
        if (response[0].permiso=='admin') {
         window.location.href = "panel.php"; 
                                           }
       if (response[0].permiso=='alumno') {
         window.location.href = "alumno.php"; 
                                           }
       if (response[0].permiso=='Funcionario') {
         window.location.href = "funcionario.php"; 
                                           }
       if (response[0].permiso=='Personal del Casino jr'|| response[0].permiso=='Personal del Casino sr') {
         window.location.href = "comedor_casino.php"; 
                                           }
       if (response[0].permiso=='Emisor de Ticket') {
         window.location.href = "emisor.php"; 
                                           }
       if (response[0].permiso=='Tienda') {
         window.location.href = "tienda.php"; 
                                           }
        if (response[0].permiso=='Supervisor casino') {
         window.location.href = "supervisor.php"; 
                                           }
                        })
       }

}

//--------------------------------------------------------------------------------------------------
$scope.btn_reestablecer= function( ){
 user_pw.value='';
   $("#reestablecer").modal('show');
}

$scope.btn_registrarse2= function( ){
   $("#reestablecer").modal('hide');
    input_rut.value="";
    nombre_pila.value="";
    pw_new_user.value="";
    confir_pw.value="";
   $("#registrarse").modal('show');
}

document.getElementById('user_pw').addEventListener('input', function(evt) {
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

$scope.mensaje='';
$scope.vista_no=false;
$cod='';
$scope.enviar_cod= function(){ 
    $cod=Math.floor((Math.random() * (999999 - 100000 + 1)) + 100000);
        $http.get("mail_restablecer_pw.php?cod="+$cod+"&user="+user_pw.value).success(
         function(response) { 
          if (response=='1') {
             $scope.vista_no=true;
           }else{
             $scope.vista_no=false;
             $scope.mensaje=response;
            }
            })
  // console.log($cod);
}

$scope.reestablecer_user= function(){
     
   if ($cod==codigo_resp.value) {
      $http.get("php/usuarios/agg_user.php?opc=Reset_user&id="+user_pw.value).success(
         function(response) { 
           Swal.fire({
    title: 'Listo, este usuario fue reseteado corectamente',
    text: "Ahora su contraseña es '12345'",
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Ok',
    cancelButtonText: 'No'
  })
                        })
       $("#reestablecer").modal('hide');
   }else{
       $("#codigo_resp").addClass("vacio");
   }
}

});