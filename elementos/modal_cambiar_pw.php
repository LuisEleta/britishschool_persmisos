<div class="modal fade bd-example-modal-lg" id="cambiar_pw" tabindex="-1" role="dialog" aria-labelledby="1"
     aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">CAMBIAR CONTRASEÑA:</h5>
                </div>
                <div class="modal-body pl-5 pr-5">
                    <label class="col-12 mt-2"><b>Contraseña Actual</b></label>
                    <input class="col-12" type="password" name="pw_user_old" id="pw_user_old" autocomplete="off">
                    <label class="col-12 mt-2"><b>Contraseña Nueva</b></label>
                    <input class="col-12" type="password" name="pw_user_new" id="pw_user_new" autocomplete="off">
                    <label class="col-12 mt-2"><b>Confirmar Nueva contraseña</b></label>
                    <input class="col-12" type="password" name="pw_user_new2" id="pw_user_new2" autocomplete="off">
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cerrar</button>
                    <a href="#" class="btn btn-base-rojo float-right mt-2 mb-2" ng-click="btn_cambiar_pw()">Cambiar
                        Contraseña</a>
                </div>
            </form>
        </div>
    </div>
</div>