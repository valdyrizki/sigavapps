@extends('template.master')
@section('title', 'Input Transaksi')

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
                                <select class="form-control" height="48" name="nama_produk" id="nama_produk">
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

                        <h2 class="col-sm-12" id="total_belanja"></h2>
                        <input type="number" name="moneyInput" id="moneyInput" class="form-control col-sm-12" disabled>
                        <div class="row mt-1">
                            <button type="button" class="btn btn-success col-sm-2 mr-3 btn-xs" id="m5000" disabled>@currency(5000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-3 btn-xs" id="m10000" disabled>@currency(10000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-3 btn-xs" id="m20000" disabled>@currency(20000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-3 btn-xs" id="m50000" disabled>@currency(50000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-3 btn-xs" id="m100000" disabled>@currency(100000)</button>
                        </div>

                        <h2 class="col-sm-12" id="kembalian"></h2>
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
    $('#nama_produk').select2();
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

        if(!idProduk){
            alert("Pilih produk terlebih dahulu");
            return;
        }

        if (harga <= 0){
            alert("Harga tidak boleh 0 atau minus");
            return;
        }

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
        $('#moneyInput').removeAttr("disabled").val(0);
        $('#m5000').removeAttr("disabled");
        $('#m10000').removeAttr("disabled");
        $('#m20000').removeAttr("disabled");
        $('#m50000').removeAttr("disabled");
        $('#m100000').removeAttr("disabled");
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
                let hargaJual = produk[i].harga_jual;
                $('#harga_jual').val(hargaJual);
                $('#stok').val(produk[i].stok);
                $('#deskripsi_produk').val(produk[i].deskripsi);
            }
        }
    });

    $('#moneyInput').keyup(function(){
        var input = $(this).val();
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+hasil*-1);
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m5000').on('click',function (){
        let moneyInput = $('#moneyInput').val();
        $('#moneyInput').val(parseInt(moneyInput)+5000);
        var input = $('#moneyInput').val();
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+hasil*-1);
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m10000').on('click',function (){
        let moneyInput = $('#moneyInput').val();
        $('#moneyInput').val(parseInt(moneyInput)+10000);
        var input = $('#moneyInput').val();
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+hasil*-1);
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m20000').on('click',function (){
        let moneyInput = $('#moneyInput').val();
        $('#moneyInput').val(parseInt(moneyInput)+20000);
        var input = $('#moneyInput').val();
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+hasil*-1);
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m50000').on('click',function (){
        let moneyInput = $('#moneyInput').val();
        $('#moneyInput').val(parseInt(moneyInput)+50000);
        var input = $('#moneyInput').val();
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+hasil*-1);
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m100000').on('click',function (){
        let moneyInput = $('#moneyInput').val();
        $('#moneyInput').val(parseInt(moneyInput)+100000);
        var input = $('#moneyInput').val();
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+hasil*-1);
        }else{
            $('#kembalian').text("");
        }
    });

    $("#btnSaveData").on('click',function () {
        if (!confirm('Apakah transaksi sudah benar ?')) return;
        if (dttable.data().count() < 1 ) {
            alert( 'Input Transaksi Terlebih Dahulu' );
            return;
        }
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
                $("#total_belanja").text("");
                detailTransaksi = [];
                $('#moneyInput').val("").prop("disabled",true);
                $('#kembalian').text("")
                $('#m5000').prop("disabled",true);
                $('#m10000').prop("disabled",true);
                $('#m20000').prop("disabled",true);
                $('#m50000').prop("disabled",true);
                $('#m100000').prop("disabled",true);
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
