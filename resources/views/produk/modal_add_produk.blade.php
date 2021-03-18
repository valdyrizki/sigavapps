<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Produk</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container">
        
        <div class="row">
          <div class="col-md-6">
            <input type="hidden" class="form-control" id="id">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama_produk" placeholder="Nama Produk" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="inputNorek" class="form-label">Kategori</label> <br>
              <select height="48" id="id_kategori" name="id_kategori" class="form-control">
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3 mr-3">
              <label for="exampleFormControlInput4" class="form-label">Harga Modal</label>
              <input type="text" class="form-control" id="harga_modal" placeholder="Harga Modal" autocomplete="off">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3 mr-3">
              <label for="exampleFormControlInput4" class="form-label">Harga Jual</label>
              <input type="text" class="form-control" id="harga_jual" placeholder="Harga Jual" autocomplete="off">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3 mr-3">
              <label for="exampleFormControlInput4" class="form-label">Diskon</label>
              <input type="text" class="form-control" id="diskon" placeholder="Diskon Produk" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3 mr-3">
              <label for="exampleFormControlInput4" class="form-label">Stok</label>
              <input type="text" class="form-control" id="stok" placeholder="Stok saat ini" autocomplete="off">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="exampleFormControlInput3" class="form-label">Distributor</label>
              <input type="text" class="form-control" id="distributor" placeholder="Distributor">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="exampleFormControlInput5" class="form-label">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="1">Aktif</option>
                <option value="9">Tidak Aktif</option>
              </select>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
          <textarea class="form-control" id="deskripsi" rows="3"></textarea>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="tambah_produk">Tambah Produk</button>
          <button type="button" class="btn btn-primary" id="edit_produk">Edit Produk</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>