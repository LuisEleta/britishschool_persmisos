  angular.module('angular', []).controller("comedorcontroller",function($scope, $http)
{
 $scope.list_almuerzos=[];
 $scope.list_menus=[];
 $parametros=[];
 var f = new Date();
 $varm="";
 if ((f.getMonth() +1)<10) {$varm="0";}
 $vard="";
 if (f.getDate()<10) {$vard="0";}
 $fecha=f.getFullYear()+"-"+$varm+(f.getMonth() +1)+"-"+$vard+f.getDate();
 $fh=f.getFullYear()+$varm+(f.getMonth() +1)+$vard+f.getDate();
 $auxmin='';
 if (f.getMinutes()<10) {
     $auxmin='0';
 }
 $hora= f.getHours()+$auxmin+f.getMinutes(); 
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

               $http.get("php/permisos/rechazo_automatico.php?").success(
                function(resp_horario) { })


  $http.get("php/sesion/verificarsesion.php").success(
         function(response) {   
           if (response[0].permiso=='Funcionario') {
            $sesion=response;
           $http.get("php/usuarios/traer_usuarios.php?opc=alunno_and_funcionario&rut="+$sesion[0].rut).success(
               function(response2) { 
                $ft=response2[0].foto;
                 if (response2[0].foto=='img/foto_user.png') {
                        $("#subirarchivo").modal('show');
                      
                 }
                   })
               $http.get("php/usuarios/traer_usuarios.php?opc=alunno_and_funcionario&rut="+$sesion[0].rut).success(
                function(responsename) {
                    if (responsename[0].name) { $("#texto_sesion").text("Hola "+responsename[0].name);  }
                    else{$("#texto_sesion").text("Hola "+response[0].user) }
                  })

                $http.get("php/funcionarios/crud_funcionarios.php?opc=un_funcionario&rut="+$sesion[0].rut).success(
                function(resp_horario) {
                   $scope.datos_funcionario=resp_horario;
                  })
            console.log("php/horarios/crud_horarios.php?opc=horario_funcionario&rut="+$sesion[0].rut)
              $http.get("php/horarios/crud_horarios.php?opc=horario_funcionario&rut="+$sesion[0].rut).success(
                function(resp_horario) {
                   $scope.horario=resp_horario;
           //        if ($scope.horario[0].nombre=='Normal') {
                     $receso_i=$scope.horario[0].receso_i;
                     $receso_f=$scope.horario[0].receso_f;
                     $hora_receso_i=$scope.horario[0].receso_i.charAt(0)+$scope.horario[0].receso_i.charAt(1);
                     $min_receso_i=$scope.horario[0].receso_i.charAt(3)+$scope.horario[0].receso_i.charAt(4);
                     $hora_receso_f=$scope.horario[0].receso_f.charAt(0)+$scope.horario[0].receso_f.charAt(1);
                     $min_receso_f=$scope.horario[0].receso_f.charAt(3)+$scope.horario[0].receso_f.charAt(4);
             //      }
                  })

              $http.get("php/supervisores/curd_supervisores.php?opc=verificar_supervisor&rut="+$sesion[0].rut).success(
                function(resp) {
                   if (resp[0].id) {$("#opc_responder").removeClass("oculto"); $("#opc_subalternos").removeClass("oculto"); $id_sup= resp[0].id;}
                  })

               $http.get("php/sesion/iniciarsesion.php?user="+$sesion[0].user+"&pw=12345").success(
                     function(response3) {
                        if (response3[0].permiso!=='0') {
                            alert('Su contraseña es muy blanda, te invitamos a cambiarla en el opcion cambio de contraseña')
                        }
                              })
            $("#texto_cerrar_sesion").text("Cerrar sesión");    
           $("#carrito").addClass("oculto"); 
            $(".caja_central").addClass("oculto"); 
           $("#div_inicio").removeClass("oculto"); 
           } else{
            window.location.href = "index.php";    
           }    
                        })
 

$scope.btn_sesion= function(){
  Swal.fire({
    title: 'Imagen de perfil para retiro de almuerzo',
    text: 'Puedes cambiar tu foto en la opción cambio de imagen',
   imageUrl: $ft,
  imageWidth: 300,
  imageAlt: 'Custom image',
  showDenyButton: false,
  showCancelButton: false,
  confirmButtonText: 'OK',
  denyButtonText: ``,
})
}

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


$scope.div_inicio= function(){
           $http.get("php/funcionarios/crud_funcionarios.php?opc=un_funcionario&rut="+$sesion[0].rut).success(
                function(resp_horario) {
                   $scope.datos_funcionario=resp_horario;
                  })
      $(".caja_central").addClass("oculto"); 
      $("#div_inicio").removeClass("oculto"); 
}

$scope.div_crear_permiso= function(){
  $http.get("php/parametros_permisos/crud_permisos.php?opc=trear_permisos").success(
     function(response) { 
       if (response[0].id) {
          $scope.list_permisos=response;
           $(".caja_central").addClass("oculto"); 
           $("#div_crear_permiso").removeClass("oculto"); 
             $("#btn_crear_p").removeClass("oculto"); 
             $("#btn_editar_p").addClass("oculto"); 
                  }
                        }) 
     
}

$scope.list_historial=[];
$scope.div_hitorial= function(){
            $http.get("php/permisos/crud_permisos_funcionarios.php?opc=trear_permisos_de_funcionarios&rut="+$sesion[0].rut).success(
                function(response) { 
                  if (response[0].id) {
                   $scope.list_historial=response;
                  }else{
                    $scope.list_historial=[];
                  }
                          })  
       $(".caja_central").addClass("oculto"); 
       $("#div_hitorial").removeClass("oculto"); 
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
                alert('Cambiar por: El permiso solicitado supera las horas disponibles, en caso de que este sea aprobado estará sujeto a descuento');
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
              
        }
 } ));

$permiso_descuento='NO';
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
                if ($scope.datos_funcionario[0].hr_disp!='00:00') {
                     $miCheckbox.checked = true;
                }
               
              
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
  if (fi.value==ff.value) {
         $http.get("php/parametros_permisos/crud_permisos.php?opc=trear_permisos_dias_funcionario&rut="+$sesion[0].rut+"&fecha="+fi.value).success(
                function(response) { 
                if (response[0].rut) {
                    $ban_fi='';
                    $ban_ff='';
                    $f_hi=hi.value.charAt(0)+hi.value.charAt(1)+hi.value.charAt(3)+hi.value.charAt(4);
                    $f_hf=hf.value.charAt(0)+hf.value.charAt(1)+hf.value.charAt(3)+hf.value.charAt(4);
                   for (let i in response){
                     if (parseInt($f_hi)>parseInt(response[0].hi) && parseInt($f_hi)<parseInt(response[0].hf)) {
                       alert('Ya tienes un permiso en este horario, por favor verifica tu historial de permisos y vuelve a intentarlo');
                        fi.value=''; hi.value=''; ff.value=''; hf.value=''; return 0;
                     }
                     if (parseInt($f_hi)<parseInt(response[0].hi)) {
                        $ban_fi='Antes';
                     }
                      if (parseInt($f_hi)>parseInt(response[0].hf)) {
                       $ban_fi='Despues';
                        }
                         
                          if (parseInt($f_hf)>parseInt(response[0].hi) && parseInt($f_hf)<parseInt(response[0].hf)) {
                           alert('Ya tienes un permiso en este horario, por favor verifica tu historial de permisos y vuelve a intentarlo');
                            fi.value=''; hi.value=''; ff.value=''; hf.value=''; return 0;
                             }
                             if (parseInt($f_hf)<parseInt(response[0].hi)) {
                                $ban_ff='Antes';
                             }
                              if (parseInt($f_hf)>parseInt(response[0].hf)) {
                               $ban_ff='Despues';
                                }
                    if ($ban_fi!=$ban_ff) {
                       alert('Ya tienes un permiso en este horario, por favor verifica tu historial de permisos y vuelve a intentarlo');
                        fi.value=''; hi.value=''; ff.value=''; hf.value=''; return 0;
                    }

                   }
                }
                        }) 

  }
    

  $hr_ingresada=hf.value.charAt(0)+hf.value.charAt(1)+hf.value.charAt(3)+hf.value.charAt(4);
  $hora_min=$hora_min_ff.charAt(0)+$hora_min_ff.charAt(1)+$hora_min_ff.charAt(3)+$hora_min_ff.charAt(4);
  $hora_max=$hora_max_ff.charAt(0)+$hora_max_ff.charAt(1)+$hora_max_ff.charAt(3)+$hora_max_ff.charAt(4);
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


$scope.btn_crear_permiso= function(){
       $vacio=0;
    if (tipo_permiso.value=='0') {$vacio++; $("#tipo_permiso").addClass("vacio");}else{$("#tipo_permiso").removeClass("vacio");}
     if (motivo.value=='0') {$vacio++; $("#motivo").addClass("vacio");}else{$("#motivo").removeClass("vacio");}
     if (fi.value=='0') {$vacio++; $("#fi").addClass("vacio");}else{$("#fi").removeClass("vacio");}
     if (tipo_permiso.value=='2' && motivo.value=='19' && observacion.value=='') {$vacio++; $("#observacion").addClass("vacio");}else{$("#observacion").removeClass("vacio");}
        if (tipo_permiso.value==2) {
            if (ff.value=='') {$vacio++; $("#ff").addClass("vacio");}else{$("#ff").removeClass("vacio");}
            if (hf.value=='') {$vacio++; $("#hf").addClass("vacio");}else{$("#hf").removeClass("vacio");}
            if (hp.value=='') {$vacio++; $("#hp").addClass("vacio");}else{$("#hp").removeClass("vacio");}
      }
       if ($vacio>0) {
         Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
let timerInterval
Swal.fire({
    customClass: {
    confirmButton: 'oculto',
    cancelButton: 'btn btn-danger'
  },
  showConfirmButton: false,
  title: 'Casi listo',
  html: 'Estamos creando su permiso, por favor espere.',
  timer: 5000,
  timerProgressBar: true,
   willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }
})


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
                                xhttp.open("POST", "php/permisos/crear_permiso.php?permiso="+tipo_permiso.value+"&motivo="+motivo.value+"&fi="+fi.value
                                    +"&ff="+ff.value+"&hi="+hi.value+"&hf="+hf.value+"&ht="+$ht+"&observacion="+observacion.value+"&rut="+$sesion[0].rut+"&descuento="+$permiso_descuento, true);
                                xhttp.send(data);
                                $('#form1').trigger('reset');
                                xhttp.onload = () => alert(xhttp.response);
                                    setTimeout(function(){
                                        window.location.reload();
                                    },2000);
 }
}


$id_permiso='';
$scope.div_editar_permiso= function($id, $pp, $mm){
    $id_permiso=$id;
    $(".caja_central").addClass("oculto"); 
      $http.get("php/parametros_permisos/crud_permisos.php?opc=trear_permisos").success(
     function(response) { 
       if (response[0].id) {
          $scope.list_permisos=response;
           for (let i in $scope.list_permisos){
               if ($scope.list_permisos[i].nombre==$pp) {
                   setTimeout(function(){
                  tipo_permiso.value=$scope.list_permisos[i].id;
                   $http.get("php/parametros_permisos/crud_permisos.php?opc=parametros_motivos_user&id="+tipo_permiso.value).success(
                            function(response) { 
                              if (response[0].id) {
                               $scope.list_motivos=response;
                                for (let i in $scope.list_motivos){
                                 if ($scope.list_motivos[i].descripcion==$mm) {
                                      setTimeout(function(){
                                         motivo.value=$scope.list_motivos[i].id;
                                            $scope.leyenda=$scope.list_motivos[i].leyenda;
                                            $tipo_tiempo=$scope.list_motivos[i].tipo_tiempo;
                                            $tiempo_motivo=$scope.list_motivos[i].tiempo; 
                                            
                                                for (let i in $scope.list_historial){
                                                   if ($scope.list_historial[i].id==$id) {
                                                        fi.value=$scope.list_historial[i].fi;
                                                        hi.value=$scope.list_historial[i].hi;
                                                        ff.value=$scope.list_historial[i].ff;
                                                        hf.value=$scope.list_historial[i].hf;
                                                        hp.value=$scope.list_historial[i].ht;
                                                        observacion.value=$scope.list_historial[i].descripcion;
                                                        if ($scope.list_historial[i].descuento=='SI') {
                                                            document.getElementById("cbox2").checked = true;
                                                        }
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
                                                   $(".hrs").removeClass("oculto"); 
                                                   $(".fhf").removeClass("oculto");  
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
                                                        if (weekday==5 || weekday==6) {
                                                         fi.value='';
                                                         return 0;
                                                        }
                                                         $scope.leyendafi='Su hora de inicio debe estar entre '+$hora_min_fi+' y '+$hora_max_fi;
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
                                                }
                                                 if ($tipo_tiempo=='NA') {
                                                   $(".fhf").removeClass("oculto");  
                                                   $(".hrs").addClass("oculto");  
                                                   
                                               }
                                                                                          }
                                                       $("#btn_crear_p").addClass("oculto"); 
                                                        $("#btn_editar_p").removeClass("oculto"); 
                                                        
                                                        
                                                        $("#div_crear_permiso").removeClass("oculto");
                                                        $scope.$apply();    
                                                                                      }
                                      },500);
                                 }}
                             }else{  $scope.list_motivos=[];   }
                        })   },500);  }}  }  }) 
 }
 

 $scope.btn_editar_permiso= function(){
       $vacio=0;
    if (tipo_permiso.value=='0') {$vacio++; $("#tipo_permiso").addClass("vacio");}else{$("#tipo_permiso").removeClass("vacio");}
     if (motivo.value=='0') {$vacio++; $("#motivo").addClass("vacio");}else{$("#motivo").removeClass("vacio");}
     if (fi.value=='0') {$vacio++; $("#fi").addClass("vacio");}else{$("#fi").removeClass("vacio");}
       if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'Existen campos vacios' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
let timerInterval
Swal.fire({
    customClass: {
    confirmButton: 'oculto',
    cancelButton: 'btn btn-danger'
  },
  showConfirmButton: false,
  title: 'Casi listo',
  html: 'Estamos editando su permiso, por favor espere.',
  timer: 5000,
  timerProgressBar: true,
   willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }
})
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
                                xhttp.open("POST", "php/permisos/editar_permiso.php?permiso="+tipo_permiso.value+"&motivo="+motivo.value+"&fi="+fi.value
                                    +"&ff="+ff.value+"&hi="+hi.value+"&hf="+hf.value+"&ht="+$ht+"&observacion="+observacion.value+"&rut="+$sesion[0].rut
                                    +"&descuento="+$permiso_descuento+"&id_permiso="+$id_permiso, true);
                                xhttp.send(data);
                                $('#form1').trigger('reset');
                                xhttp.onload = () => alert(xhttp.response);
                                    setTimeout(function(){
                                       $http.get("mails/sent_permiso_editado.php?id="+$id_permiso).success(
                                        function(response) { 
                                            window.location.reload();
                                                })
                                     },2000);
 }
}

$scope.detalles_permiso=[];
$scope.modal_detalles_permiso= function($id){
               $http.get("php/permisos/crud_permisos_funcionarios.php?opc=trear_un_permiso&id="+$id).success(
                function(response) { 
                  if (response[0].id) {
                   $scope.detalles_permiso=response;
                  }
                   $("#detalles_de_permiso").modal('show');
                        })
  
}

$scope.btn_eliminar_permiso= function($id){
   Swal.fire({
    title: '¿Desea anular este permiso?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_historial=[];
  $http.get("php/permisos/crud_permisos_funcionarios.php?opc=eliminar_permiso_funcionario&id="+$id+"&rut="+$sesion[0].rut).success(
         function(response) { 
            if (response[0].id) {
              $scope.list_historial=response;   
          }            })
 }}) 
}


$scope.list_permisos_responder=[];
$scope.div_responder= function(){
            $http.get("php/permisos/crud_permisos_funcionarios.php?opc=trear_permisos_para_responder&id="+$id_sup).success(
                function(response) { 
                  if (response[0].id) {
                   $scope.list_permisos_responder=response;
                  }else{
                    $scope.list_permisos_responder=[];
                  }
                          })  
       $(".caja_central").addClass("oculto"); 
       $("#div_responder").removeClass("oculto"); 
}

$scope.btn_rechazar_permiso= function($id){
   Swal.fire({
    title: '¿Desea rechazar este permiso?',
    text: "",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#1c4365',
    cancelButtonColor: '#5b6771',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
  if (result.isConfirmed) {
    $scope.list_permisos_responder=[];
   $http.get("php/permisos/crud_permisos_funcionarios.php?opc=rechazar_permiso&id="+$id+"&id_sup="+$id_sup).success(
         function(response) { 
           if (response[0].id) {
                   $scope.list_permisos_responder=response;
                  }else{
                    $scope.list_permisos_responder=[];
                  }
                             })
               $http.get("php/mails/mail_rechazado.php?id="+$id).success(
                     function(response) {    })
 }}) 
}

$scope.btn_aprobar_permiso= function($id){
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
    $scope.list_permisos_responder=[];
    $http.get("php/permisos/crud_permisos_funcionarios.php?opc=aprobar_permiso&id="+$id+"&id_sup="+$id_sup).success(
         function(response) { 
              $http.get("php/parametros_permisos/actualizar_horas.php").success(
                          function(response) { })
           if (response[0].id) {
                   $scope.list_permisos_responder=response;
                  }else{
                    $scope.list_permisos_responder=[];
                  }
                             })
               $http.get("php/mails/mail_aprobado.php?id="+$id).success(
                     function(response) {    })
 }}) 
}

$scope.list_subalternos=[];
$scope.div_subalternos= function(){
           $http.get("php/supervisores/curd_supervisores.php?opc=trear_vinculados&id="+$id_sup).success(
                function(resp) {
                   $scope.list_subalternos=resp;
                  })
      $(".caja_central").addClass("oculto"); 
      $("#div_subalternos").removeClass("oculto"); 
}

$scope.name_c='';
$scope.div_historial_subalternos= function($rt, $nm ){
    $scope.name_c=$nm;
             $http.get("php/permisos/crud_permisos_funcionarios.php?opc=trear_permisos_de_funcionarios&rut="+$rt).success(
                function(response) { 
                  if (response[0].id) {
                   $scope.list_historial=response;
                  }else{
                    $scope.list_historial=[];
                  }
                          }) 
      $(".caja_central").addClass("oculto"); 
      $("#div_historial_subalternos").removeClass("oculto"); 
}


$scope.datos_funcionario2=[];
$scope.btn_datos_subalternos= function($rt){
                 $http.get("php/funcionarios/crud_funcionarios.php?opc=un_funcionario&rut="+$rt).success(
                function(resp_horario) {
                   $scope.datos_funcionario2=resp_horario;
                    $("#modal_datos_subalternos").modal('show');   
                  })
  
}


$scope.modal_leyenda= function(){
        $("#modal_leyenda").modal('show');
 
}

$scope.cambiar_pw= function(){
        $("#cambiar_pw").modal('show');
 
}


$scope.btn_cambiar_pw= function(){
   Swal.fire({
    title: '¿Deseas cambiar tu contraseña?',
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
      if (pw_user.value=='') {$vacio++; $("#pw_user").addClass("vacio");}else{$("#pw_user").removeClass("vacio");}
    if (pw_user2.value=='') {$vacio++; $("#pw_user2").addClass("vacio");}else{$("#pw_user2").removeClass("vacio");}
    if (pw_user3.value!=pw_user2.value) {$vacio++; $("#pw_user3").addClass("vacio");}else{$("#pw_user3").removeClass("vacio");}
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
    $http.get("php/sesion/cambiarpw.php?pwold="+pw_user.value+"&pwnew="+pw_user2.value+"&user="+$sesion[0].user).success(
         function(response) { 
             $("#cambiar_pw").modal('hide');
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
                        })
 }
 }}) 
}


$id_permiso='';
$scope.btn_adjuntar= function($id, $adjunto){
    $id_permiso=$id;

    if ($adjunto=='') {
          $("#modal_adjuntar").modal('show'); 
    }else{
      window.open($adjunto, '_blank');  
    }
}

$scope.btn_adjuntar_archivo= function(){
       $vacio=0;
      if (name_archivo.value=='') {$vacio++; $("#name_archivo").addClass("vacio");}else{$("#name_archivo").removeClass("vacio");}
       if ($vacio>0) {
        Swal.fire({ title: 'Error', text: 'No hay archivos adjuntos' , icon: 'info', showCancelButton: false,confirmButtonColor: '#1c4365', 
          cancelButtonColor: '#5b6771', confirmButtonText: 'OK', cancelButtonText: 'No' })
 }else{
         var frm = document.getElementById('form22');
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
                                 xhttp.open("POST", "php/permisos/adjuntar_archivo.php?id_permiso="+$id_permiso, true);
                                xhttp.send(data);
                                $('#form1').trigger('reset');
                               // xhttp.onload = () => alert(xhttp.response);
                                    setTimeout(function(){
                                    $http.get("php/permisos/crud_permisos_funcionarios.php?opc=trear_permisos_de_funcionarios&rut="+$sesion[0].rut).success(
                                            function(response) { 
                                              if (response[0].id) {
                                               $scope.list_historial=response;
                                              }else{
                                                $scope.list_historial=[];
                                              }
                                              $("#modal_adjuntar").modal('hide');
                                              $(".caja_central").addClass("oculto"); 
                                              $("#div_hitorial").removeClass("oculto"); 
                                                      })  
                                 
                                    },1000);
 }
}

jQuery('#cbox2').on('change',  (function() {
    if (document.getElementById('cbox2').checked){
           if ($scope.datos_funcionario[0].hr_disp=='00:00') {
                     $miCheckbox.checked = false;
                     alert('Usted no posee horas disponibles para usar');
                       $permiso_descuento='NO';
                }
          }
 }));

});