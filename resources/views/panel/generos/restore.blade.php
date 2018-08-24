<!-- Modal -->
<div class="modal fade" id="modalRestore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Restaurar Género</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{Form::open(['route'=>['generos.restore',""]])}}
        <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h6 id="txtRestore">¿Está seguro de restaurar el género?</h6>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancelar">
            <input type="submit" class="btn btn-primary" value="Aceptar">
          </div>
          {{Form::Close()}}
      </div>
    </div>
  </div>
