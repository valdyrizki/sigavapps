@extends('template.master')
@section('title', 'Tambah Stok')

@section('content')

<style>
    .select2-selection__rendered {
    line-height: 30px !important;
}
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
    .select2-selection__arrow {
        height: 38px !important;
    }
</style>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <div class="card py-3 px-3">
                    <div class="row">

                        <div class="col-sm-12">
                            <!-- select -->
                            <div class="form-group">
                            <label>Nama Produk</label>
                            <select class="form-control" height="48" name="nama_produk" id="nama_produk" required>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Kode Produk</label>
                            <input type="text" class="form-control" name="kode_produk" id="kode_produk" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                    <div class="card py-3 px-3">
                        <h3 class="col-sm-12">Total Barang : <span id="total_input"></span></h3>
                        <button type="button" class="col-sm-12 btn btn-primary mt-2" id="btnSaveData">Simpan Transaksi</button>

                        <div class="col-sm-12">
                                <table id="cart" class="table table-bordered table-hover text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kode Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script>

$(document).ready(function() {
    var data = [];
    var id;
    $('#nama_produk').select2();
    let dttable = $('#cart').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    $("#nama_produk").change(function () {
        id = $('#nama_produk').val();
        $('#nama_produk').attr("disabled", true);
    });

    $("#kode_produk").on('keypress',function(e) {
        if(e.which == 13) {
            let kode_produk = $("#kode_produk").val();
            if(id != null && kode_produk.length > 0){
                let no = data.length+1;
                let dtl = {
                    "id_produk" : id,
                    "kode_produk" : kode_produk
                };
                dttable.row.add( [
                    no,
                    $("#nama_produk option:selected").attr("name"),
                    kode_produk
                ] ).draw( false );

                data.push(dtl);
                $("#kode_produk").val("");
                $("#total_input").html(no);
            }else{
                alert("Data masih kosong");
                return
            }
        }
    });

    $('#btnSaveData').on( 'click', function () {
        if(data.length > 0){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/addStokv2',
                data: {
                    "data" : data
                },
                success: function(data) {
                    alert('data: ' + data.message);
                    getProduct();
                    dttable.clear().draw();
                    data = [];
                    $("#total_input").html(0);
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }else{
            alert("Data masih kosong");
            return;
        }

    } );

});

    function getProduct(){
        $('#nama_produk').attr("disabled", false);
        $('#nama_produk').empty();
        $.getJSON("/produk/getAllProduk", function(json){
        $('#nama_produk').append($('<option disabled selected>').text("--- Pilih Produk ---"));
        $.each(json, function(i, obj){
            $('#nama_produk').append($('<option>').text(obj.nama_produk).attr({
                value: obj.id,
                name: obj.nama_produk
            }));
        });
    });
    }
    getProduct();

    </script>

  </section>
@endsection
