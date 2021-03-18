<div class="modal fade" id="modal-sm">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Refund Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/refund/insert" method="POST">
          @csrf
          <input type="hidden" name="id_detailtransaksi" id="id_detailtransaksi">
          <div class="modal-body">
              <textarea name="deskripsi_refund" id="deskripsi_refund" class="form-control" placeholder="Deskripsi Refund" required></textarea>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Refund Transaksi</button>
          </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>