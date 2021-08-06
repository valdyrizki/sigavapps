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
                <div class="col-sm-8">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- select -->
                                <div class="form-group">
                                <label>Kategori Produk</label>
                                <select class="form-control kategori_produk" name="kategori_produk" id="kategori_produk">
                                    <option value="0" selected>--- Custom Order ---</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{$k->id}}">{{$k->id}} - {{$k->category_name}}</option>
                                    @endforeach

                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-sm-12">
                                <!-- select -->
                                <div class="form-group">
                                <label>Nama Produk</label>
                                <select class="form-control" height="48" name="nama_produk" id="nama_produk">
                                </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                <label>Qty</label>
                                <input type="number" class="form-control" name="jumlah_beli" id="jumlah_beli" min="1" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                <label>Harga Produk</label>
                                <input type="number" class="form-control" name="harga_jual" id="harga_jual" >
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                <label>Stok Produk</label>
                                <input type="number" class="form-control" name="stok" id="stok" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                <label>Deskripsi Produk</label>
                                <textarea class="form-control" name="deskripsi_produk" id="deskripsi_produk" readonly="readonly"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="button" class="form-control btn btn-primary" id="inputProduk">Input</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="card py-3 px-3">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi_transaksi" id="deskripsi_transaksi" ></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <!-- select -->
                                <div class="form-group">
                                <label>Pembayaran Via</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1" selected>Cash</option>
                                    <option value="2">Hutang</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <!-- select -->
                                <div class="form-group">
                                <label>Member</label>
                                <select class="form-control" height="48" name="id_member" id="id_member">
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <!-- select -->
                                <div class="form-group">
                                <label>Uang</label>
                                <input type="text" name="moneyInput" id="moneyInput" class="form-control col-sm-12" disabled>
                                </div>
                            </div>
                        </div>
                        
        
                        <div class="row mt-1 mr-2">
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m5000" disabled>@currency(5000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m10000" disabled>@currency(10000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m20000" disabled>@currency(20000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m50000" disabled>@currency(50000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m100000" disabled>@currency(100000)</button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-12">
                                <table id="cart" class="table table-bordered table-hover text-center">
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
                        
                        <h2 class="col-12" id="total_belanja"></h2>
                        <h2 class="col-sm-12" id="kembalian"></h2>
                        <button type="button" class="col-sm-12 btn btn-primary mt-2" id="btnSaveData">Proses Transaksi</button>
        
                    </div>
                </div>
                
                    

            </div>
        </form>
    </div>

    <script>

$(document).ready(function() {
    $('#nama_produk').select2();
    $('#id_member').select2();
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
            Swal.fire({
                icon: 'error',
                title: 'Pilih produk terlebih dahulu'
            });
            return;
        }

        if (harga <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Harga tidak boleh 0 atau minus'
            });
            return;
        }

        dttable.row.add( [
            nmProduk,
            qty,
            formatNumber(harga),
            formatNumber(total)
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
        $("#total_belanja").html("Total : "+formatNumber(total_belanja));
        $('#moneyInput').removeAttr("disabled").val("");
        $('#m5000').removeAttr("disabled");
        $('#m10000').removeAttr("disabled");
        $('#m20000').removeAttr("disabled");
        $('#m50000').removeAttr("disabled");
        $('#m100000').removeAttr("disabled");
        afterGenerate();
        $("#moneyInput").focus();
    } );


    $("#kategori_produk").change(function () {
        getProduk();
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
        $('#inputProduk').focus();
    });

    $('#moneyInput').keyup(function(){
        let moneyInput = formatRupiah($("#moneyInput").val());
        $("#moneyInput").val(moneyInput);

        var input = $(this).val().replaceAll('.','');
        var hasil = total_belanja-input;

        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+formatNumber(hasil*-1));
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m5000').on('click',function (){
        let moneyInput = $('#moneyInput').val() != "" ? $('#moneyInput').val().replaceAll('.','') : 0;
        let intInput = parseInt(moneyInput)+5000;
        $('#moneyInput').val(formatRupiah(intInput));
        var input = $('#moneyInput').val().replaceAll('.','');
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+formatNumber(hasil*-1));
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m10000').on('click',function (){
        let moneyInput = $('#moneyInput').val() != "" ? $('#moneyInput').val().replaceAll('.','') : 0;
        let intInput = parseInt(moneyInput)+10000;
        $('#moneyInput').val(formatRupiah(intInput));
        var input = $('#moneyInput').val().replaceAll('.','');
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+formatNumber(hasil*-1));
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m20000').on('click',function (){
        let moneyInput = $('#moneyInput').val() != "" ? $('#moneyInput').val().replaceAll('.','') : 0;
        let intInput = parseInt(moneyInput)+20000;
        $('#moneyInput').val(formatRupiah(intInput));
        var input = $('#moneyInput').val().replaceAll('.','');
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+formatNumber(hasil*-1));
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m50000').on('click',function (){
        let moneyInput = $('#moneyInput').val() != "" ? $('#moneyInput').val().replaceAll('.','') : 0;
        let intInput = parseInt(moneyInput)+50000;
        $('#moneyInput').val(formatRupiah(intInput));
        var input = $('#moneyInput').val().replaceAll('.','');
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+formatNumber(hasil*-1));
        }else{
            $('#kembalian').text("");
        }
    });

    $('#m100000').on('click',function (){
        let moneyInput = $('#moneyInput').val() != "" ? $('#moneyInput').val().replaceAll('.','') : 0;
        let intInput = parseInt(moneyInput)+100000;
        $('#moneyInput').val(formatRupiah(intInput));
        var input = $('#moneyInput').val().replaceAll('.','');
        var hasil = total_belanja-input;
        if(hasil <= 0){
            $('#kembalian').text('Kembalian : '+formatNumber(hasil*-1));
        }else{
            $('#kembalian').text("");
        }
    });

    $("#btnSaveData").on('click',function () {
        Swal.fire({
            title: 'Apakah transaksi sudah benar ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, proses Transaksi !'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (dttable.data().count() < 1 ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Input Transaksi Terlebih Dahulu'
                        });
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
                            "detailTransaksi" : detailTransaksi,
                            "deskripsi_transaksi" : $('#deskripsi_transaksi').val(),
                            "status" : $('#status').val(),
                            "id_member" : $('#id_member').val()
                        }, // or JSON.stringify ({name: 'jonas'}),
                        success: function(data) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#kategori_produk").val(0);

                            $('#nama_produk').empty();

                            $('#harga_jual').val('');
                            $('#stok').val('');
                            $('#jumlah_beli').val(1);
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
                            doReset();
                        },
                        // contentType: "application/json",
                        dataType: 'JSON'
                    });
                }else{
                    return;
                }

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
        $.getJSON("/produk/get", function(json){
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
        $("#deskripsi_transaksi").val("");
        $("#status").val(1);
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
        getMember();
    }

    async function getProduk(){
        let id_kategori = $('#kategori_produk').val();
        $('#nama_produk').empty();
        $('#nama_produk').append($('<option disabled selected>').text("--- Pilih Produk ---"));
        if(id_kategori == 0){   //Jika custom order
            await $.getJSON("/produk/get", function(json){
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
            await $.getJSON("/produk/getByKategori/"+id_kategori, function(json){
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
        $("#nama_produk").select2('open');
    }

    async function getMember(){
        $('#id_member').empty();
        $('#id_member').append($('<option disabled selected>').text("--- Pilih Member ---"));
        await $.getJSON("/member/getAll", function(json){
            $.each(json.data, function(i, obj){
                $('#id_member').append($('<option>').text(obj.nama).attr({
                    value: obj.id,
                    name: obj.nama
                }));
            });
        });
    }

    doReset();
    
} );
    </script>

  </section>
@endsection
