@extends('template.master')
@section('title', 'Input Transaksi')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="#" method="POST">
            @csrf
      <!-- Info boxes -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- select -->
                                <div class="form-group">
                                <label>Kategori Produk</label>
                                <select class="form-control" name="kategori_produk" id="kategori_produk">
                                    <option value="0" selected>--- Custom Order ---</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{$k->id}}">{{$k->id}} - {{$k->nama_kategori}}</option>
                                    @endforeach

                                </select>
                                </div>
                            </div>

                            <div class="col-sm-10">
                                <!-- select -->
                                <div class="form-group">
                                <label>Nama Produk</label>
                                <select class="form-control" name="nama_produk" id="nama_produk">
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                <label>Qty</label>
                                <input type="number" class="form-control" name="jumlah_beli" id="jumlah_beli" min="1" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Harga Produk</label>
                                <input type="number" class="form-control" name="harga_jual" id="harga_jual" >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Stok Produk</label>
                                <input type="number" class="form-control" name="stok" id="stok" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                <label>Deskripsi Produk</label>
                                <textarea class="form-control" name="deskripsi_produk" id="deskripsi_produk" readonly="readonly"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="form-control btn btn-primary" id="inputProduk">Input</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card py-3 px-3">

                        <div class="col-sm-12">
                            <h2 class="col-sm-12" id="total_belanja"></h2>
                        </div>

                        <button type="button" class="col-sm-12 btn btn-primary mt-2" id="btnSaveData">Proses Transaksi</button>


                        <div class="col-sm-12">
                                <table id="cart" class="table table-bordered table-hover text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>

$(document).ready(function() {
    let saveData = [];
    let detailTransaksi = [];
    let produk = [];
    let total_belanja = 0;
    let dttable = $('#cart').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    $('#inputProduk').on( 'click', function () {

        let nmProduk = $("#nama_produk").find('option:selected').attr("name");
        let idProduk = $("#nama_produk").val();
        let qty = $("#jumlah_beli").val();
        let harga = $("#harga_jual").val();
        let total = qty*harga;

        dttable.row.add( [
            nmProduk,
            qty,
            harga,
            total
        ] ).draw( false );

        //save to detailTransaksi
        let dtl = {
            "nama_produk" : nmProduk,
            "id_produk" : idProduk,
            "jumlah" : qty,
            "total_harga" : total
        };

        detailTransaksi.push(dtl);

        total_belanja += parseInt(total);
        $("#total_belanja").html("Total : "+total_belanja);
        afterGenerate();
    } );

    $("#kategori_produk").change(function () {
        let id_kategori = $('#kategori_produk').val();
        $('#nama_produk').empty();
        $('#nama_produk').append($('<option disabled selected>').text("--- Pilih Produk ---"));
        if(id_kategori == 0){   //Jika custom order
            $.getJSON("/produk/getAllProduk", function(json){
                produk = json;
                $.each(json, function(i, obj){
                    $('#nama_produk').append($('<option>').text(obj.nama_produk).attr({
                        value: obj.id,
                        name: obj.nama_produk
                    }));
                });
            });
            $('#harga_jual').attr('readonly',false);
            $('#jumlah_beli').val(1);
            $('#harga_jual').val('');
            $('#stok').val('');
            $('#deskripsi_produk').val('');
        }else{
            $.getJSON("/produk/getProdukByKategori/"+id_kategori, function(json){
                produk = json;
                $.each(json, function(i, obj){
                    $('#nama_produk').append($('<option>').text(obj.nama_produk).attr({
                        value: obj.id,
                        name: obj.nama_produk
                    }));
                });
            });
            $('#harga_jual').attr('readonly',true)
            $('#jumlah_beli').val(1);
            $('#harga_jual').val('');
            $('#stok').val('');
            $('#deskripsi_produk').val('');
        }
    });


    $("#nama_produk").change(function () {
        let id_produk = $('#nama_produk').val();
        for (var i = 0; i < produk.length; i++){
            if (produk[i].id == id_produk){
                $('#harga_jual').val(produk[i].harga_jual);
                $('#stok').val(produk[i].stok);
                $('#deskripsi_produk').val(produk[i].deskripsi);
            }
        }

    });

    $("#btnSaveData").on('click',function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/transaksi/insert',
            data: {
                "totalHarga" : total_belanja,
                "detailTransaksi" : detailTransaksi
            }, // or JSON.stringify ({name: 'jonas'}),
            success: function(data) {
                alert('data: ' + data.message);
                $("#kategori_produk").val(0);

                $('#nama_produk').empty();

                $('#harga_jual').val('');
                $('#stok').val('');
                $('#jumlah_beli').val(1);

                dttable.clear().draw();
                total_belanja = 0;
                $("#total_belanja").html("Total : "+total_belanja);
                afterGenerate();
             },
            // contentType: "application/json",
            dataType: 'JSON'
        });

    });

    function afterGenerate(){
        $("#deskripsi_produk").val("");
        $("#kategori_produk").val(0);
        $('#nama_produk').empty();
        $('#harga_jual').val('');
        $('#harga_jual').attr('readonly',false)
        $('#stok').val('');
        $('#jumlah_beli').val(1);
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

    function doReset(){
        $("#deskripsi_produk").val("");
        $("#kategori_produk").val(0);
        $('#nama_produk').empty();
        $('#harga_jual').val('');
        $('#harga_jual').attr('readonly',false)
        $('#stok').val('');
        $('#jumlah_beli').val(1);
        dttable.clear().draw();
        total_belanja = 0;
        $("#total_belanja").html("Total : "+total_belanja);
        afterGenerate();
    }

    afterGenerate();



} );


    </script>

  </section>
@endsection
