<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container">
        <input type="hidden" class="form-control" id="id">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nama</label>
              <input type="text" class="form-control" id="category_name" placeholder="Nama Kategori">
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput5" class="form-label">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="1">Aktif</option>
                <option value="9">Tidak Aktif</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput5" class="form-label">Type</label>
              <select name="type" id="type" class="form-control">
                <option value="1">Pemasukan</option>
                <option value="2">Pengeluaran</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
              <textarea class="form-control" id="description" rows="3"></textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add_category">Tambah Kategori</button>
          <button type="button" class="btn btn-primary" id="edit_category">Edit Kategori</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>