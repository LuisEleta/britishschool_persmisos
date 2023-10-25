<div class="modal fade bd-example-modal-lg" id="modal_impresiones" tabindex="-1" role="dialog" aria-labelledby="1" aria-hidden="true">
  <div class="modal-dialog "  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">IMPRIMIR QR:</h5>
      </div>
      <div class="modal-body pl-5 pr-5"> 
        <label class="col-12 mt-2"><b>Fecha:</b></label>
        <input type="date" class="col-12" name="" id="fecha_imp">
        <label class="col-12 mt-2"><b>Cursos:</b></label>
        <select class="col-12" id="cruso_imp">
          <option>Seleccione una opción</option>
          <option value="Todos">Todos los del día</option>
          <option>Funcionarios</option>
          <option>Todos los niveles</option>
          <option>Primero Basico</option>
          <option>Primero Medio</option>
          <option>Segundo Basico</option>
          <option>Segundo Medio</option>
          <option>Tercero Basico</option>
          <option>Tercero Medio</option>
          <option >Cuarto Basico</option>
          <option value="4 EM">Cuarto Medio</option>
          <option>Quinto Basico</option>
          <option>Sexto Basico</option>
          <option>Septimo Basico</option>
          <option value="8 EB">Octavo Basico</option>
          <option value="K">Kinder</option>
          <option>Play Group</option>
          <option>Pre Kinder</option>
          
        </select>
        <label class="col-12 mt-2"><b>Comensal:</b></label>
        <select class="col-12" id="comensal_rut">
          <option>Todos</option>
          <option ng-repeat="x in list_imp" value={{x.rut}}>{{x.nombre}} -{{x.rut}}</option>
        </select>
      </div> 
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button>
        <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2" ng-click="imprimir()">IMPRIMIR</a>
     </div>
    </div>
    </div>
  </div>