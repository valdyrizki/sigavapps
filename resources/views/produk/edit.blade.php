@extends('template.master')
@section('title', 'Edit Barang')

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
            <div class="col-sm-12">
                <div class="card py-3 px-3">
                    <form action="#">
                        <div class="row">
                            <div class="col-sm-8">
                                <!-- select -->
                                <div class="form-group">
                                <label>Produk</label>
                                <select class="form-control" height="48" name="nama_produk" id="nama_produk">
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" name="nama" id="nama" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Harga Produk</label>
                                <input type="number" class="form-control" name="harga_jual" id="harga_jual" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Harga Modal</label>
                                    <input type="number" class="form-control" name="harga_modal" id="harga_modal" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Distributor</label>
                                        <input type="text" class="form-control" name="distributor" id="distributor" readonly>
                                    </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="form-control btn btn-primary" id="editProduk">Edit Produk</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div>

    <script>

$(document).ready(function() {
    $('#nama_produk').select2();

    $("#nama_produk").change(function () {
        let id_produk = $('#nama_produk').val();
        for (var i = 0; i < produk.length; i++){
            if (produk[i].id == id_produk){
                $('#harga_jual').val(produk[i].harga_jual);
                $('#distributor').val(produk[i].distributor);
                $('#harga_modal').val(produk[i].harga_modal);
                $('#deskripsi').val(produk[i].deskripsi);
                $('#nama').val(produk[i].nama_produk);
            }
        }
        $('#harga_jual').attr('readonly',false);
        $('#distributor').attr('readonly',false);
        $('#harga_modal').attr('readonly',false);
        $('#deskripsi').attr('readonly',false);
        $('#nama').attr('readonly',false);


    });

    $('#editProduk').on( 'click', function () {
        let idProduk = $("#nama_produk").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/produk/update',
            data: {
                "id_produk" : idProduk,
                "nama_produk" : $('#nama').val(),
                "distributor" : $('#distributor').val(),
                "harga_jual" : $('#harga_jual').val(),
                "harga_modal" : $('#harga_modal').val(),
                "deskripsi" : $('#deskripsi').val()
            },
            success: function(data) {
                alert('data: ' + data.message);
                $('#harga_jual').val('');
                $('#distributor').val('')
                $('#harga_modal').val('')
                $('#deskripsi').val('')
                $('#nama').val('')
                $('#harga_jual').attr('readonly',true);
                $('#distributor').attr('readonly',true);
                $('#harga_modal').attr('readonly',true);
                $('#deskripsi').attr('readonly',true);
                $('#nama').attr('readonly',true);
                refresh();
             },
            // contentType: "application/json",
            dataType: 'JSON'
        });

    } );

    refresh();


});



    function refresh(){
        $('#nama_produk').empty();
        $('#nama_produk').append($('<option disabled selected>').text("--- Pilih Produk ---"));
        $.getJSON("/produk/getAllProduk", function(json){
            produk = json;
            $.each(json, function(i, obj){
                $('#nama_produk').append($('<option>').text(obj.nama_produk).attr({
                    value: obj.id,
                    name: obj.nama_produk
                }));
            });
        });
    }


    </script>

  </section>
@endsection
