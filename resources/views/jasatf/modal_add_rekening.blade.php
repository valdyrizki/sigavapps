<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Rekening</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container">
        <input type="hidden" class="form-control" id="add_id">
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Nama</label>
          <input type="text" class="form-control" id="add_nama" placeholder="Nama Member">
        </div>
        <div class="mb-3">
          <label for="exampleFormControlInput3" class="form-label">No Rekening</label>
          <input type="text" class="form-control" id="add_norek" placeholder="No Rekening">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3 mr-3">
              <label for="exampleFormControlInput4" class="form-label">Bank</label>
              <input type="text" class="form-control" id="add_bank" placeholder="Bank">
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="tambah_rekening">Tambah Rekening</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>