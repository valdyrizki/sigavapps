@extends('template.master')
@section('title', 'Tambah Stok')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">
                    <div class="row">

                        <div class="col-sm-8">
                            <!-- select -->
                            <div class="form-group">
                            <label>Nama Produk</label>
                            <select class="form-control" height="48" name="nama_produk" id="nama_produk">
                            </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>Tambah Stok</label>
                            <input type="number" class="form-control" name="tambah_stok" id="tambah_stok" min="1" value="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Harga Produk</label>
                            <input type="number" class="form-control" name="harga_jual" id="harga_jual" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Stok Produk Saat Ini</label>
                            <input type="number" class="form-control" name="stok" id="stok" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="button" class="form-control btn btn-primary" id="tambahStok">Tambah Stok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script>

$(document).ready(function() {
    $('#nama_produk').select2();
    $.getJSON("/produk/getAllProduk", function(json){
        produk = json;
        $.each(json, function(i, obj){
            $('#nama_produk').append($('<option>').text(obj.nama_produk).attr({
                value: obj.id,
                name: obj.nama_produk
            }));
        });
    });
    $('#tambahStok').on( 'click', function () {
        let idProduk = $("#nama_produk").val();
        let tambahStok = $("#tambah_stok").val();

        console.log(idProduk +" - "+tambahStok);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/addStok',
            data: {
                "id_produk" : idProduk,
                "tambah_stok" : tambahStok
            },
            success: function(data) {
                alert('data: ' + data.message);
                $('#harga_jual').val('');
                $('#stok').val('');
                $('#tambah_stok').val('1');
             },
            // contentType: "application/json",
            dataType: 'JSON'
        });

    } );

    $("#nama_produk").change(function () {
        let id_produk = $('#nama_produk').val();
        for (var i = 0; i < produk.length; i++){
            if (produk[i].id == id_produk){
                $('#harga_jual').val(produk[i].harga_jual);
                $('#stok').val(produk[i].stok);
            }
        }
    });

});


    </script>

  </section>
@endsection
