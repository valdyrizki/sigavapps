@extends('template.master')
@section('title', 'Laporan Penjualan')

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
                            <select class="form-control" name="nama_produk" id="nama_produk">
                                    <option value="today">Hari Ini</option>
                                    <option option="this_week">Minggu Ini</option>
                                    <option option="this_month">Bulan Ini</option>
                                    <option option="lifetime">Semua Transaksi</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <button type="button" class="form-control btn btn-primary" id="tambahStok">Tampilkan Laporan</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Total Jual</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report as $rpt)
                                    <td>{{$rpt->id}}</td>
                                    <td>{{$rpt->total_jual}}</td>
                                    <td>{{$rpt->total_harga}}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
    </div>

    <script>

$(document).ready(function() {
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
                $("#kategori_produk").val(0);

                $('#nama_produk').empty();
                $('#nama_produk').append($('<option disabled selected>').text("--- Pilih Produk ---"));

                $('#harga_jual').val('');
                $('#stok').val('');
                $('#tambah_stok').val('1');
             },
            // contentType: "application/json",
            dataType: 'JSON'
        });

    } );

    $("#kategori_produk").change(function () {
        let id_kategori = $('#kategori_produk').val();
        // if(id_kategori == 99){
        //     return;
        // }
        $.getJSON("/produk/getProdukByKategori/"+id_kategori, function(json){
            produk = json;
            $('#nama_produk').empty();
            $('#nama_produk').append($('<option disabled selected>').text("--- Pilih Produk ---"));
            $.each(json, function(i, obj){
                $('#nama_produk').append($('<option>').text(obj.nama_produk).attr({
                    value: obj.id,
                    name: obj.nama_produk
                }));
            });
        });
    });


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
