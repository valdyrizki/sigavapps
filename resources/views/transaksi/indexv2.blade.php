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
                <div class="col-sm-8">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                <label>Kode Produk</label>
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                    <table id="cart" class="table table-bordered table-hover text-center" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card py-3 px-3">

                        <h2 class="col-sm-12" id="total_belanja"></h2>
                        <input type="number" name="moneyInput" id="moneyInput" class="form-control col-sm-12" disabled>
                        <div class="row mt-1">
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m5000" disabled>@currency(5000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m10000" disabled>@currency(10000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m20000" disabled>@currency(20000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m50000" disabled>@currency(50000)</button>
                            <button type="button" class="btn btn-success col-sm-2 mr-2 btn-xs" id="m100000" disabled>@currency(100000)</button>
                        </div>

                        <h2 class="col-sm-12" id="kembalian"></h2>
                        <button type="button" class="col-sm-12 btn btn-primary mt-2" id="btnSave">Proses Transaksi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>

$(document).ready(function() {
    let data = [];
    let total_belanja = 0;
    let dttable = $('#cart').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "order": [[ 0, "desc" ]]
    });

    $("#kode_produk").on('keypress',function(e) {
        if(e.which == 13) {
            let kode_produk = $("#kode_produk").val();
            $.getJSON("/produk/getproductbycode/"+kode_produk, function(json){
                if(json.length > 0){
                    let no = data.length+1;
                    let id_produk = json[0].id;
                    let nama_produk = json[0].nama_produk;
                    let harga_jual = json[0].harga_jual;
                    let stok = json[0].stok;
                    let jumlah = 1;

                    let dtl = {
                        "id_produk" : id_produk,
                        "jumlah" : jumlah,
                        "harga_jual" : harga_jual,
                        "kode_produk" : kode_produk
                    };
                    data.push(dtl);

                    dttable.row.add( [
                        no,
                        nama_produk,
                        jumlah,
                        harga_jual
                    ] ).draw( false );

                    total_belanja += parseInt(harga_jual);
                    $("#total_belanja").html("Total : "+total_belanja);
                    $('#moneyInput').removeAttr("disabled").val(0);
                    $('#m5000').removeAttr("disabled");
                    $('#m10000').removeAttr("disabled");
                    $('#m20000').removeAttr("disabled");
                    $('#m50000').removeAttr("disabled");
                    $('#m100000').removeAttr("disabled");
                    $("#kode_produk").val("");

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Data tidak ditemukan'
                    });
                    return
                }
            });

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

    $("#btnSave").on('click',function () {
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
                        url: '/transaksi/insertv2',
                        data: {
                            "totalHarga" : total_belanja,
                            "data" : data
                        }, // or JSON.stringify ({name: 'jonas'}),
                        success: function(data) {
                            alert('data: ' + data.message);
                            dttable.clear().draw();
                            total_belanja = 0;
                            $("#total_belanja").text("");
                            $('#moneyInput').val("").prop("disabled",true);
                            $('#kembalian').text("")
                            $('#m5000').prop("disabled",true);
                            $('#m10000').prop("disabled",true);
                            $('#m20000').prop("disabled",true);
                            $('#m50000').prop("disabled",true);
                            $('#m100000').prop("disabled",true);
                            $("#kode_produk").focus();
                        },
                        // contentType: "application/json",
                        dataType: 'JSON'
                    });
                }
            });
    });

    function doReset(){
        dttable.clear().draw();
        total_belanja = 0;
        $("#total_belanja").html("Total : "+total_belanja);
        $("#kode_produk").focus();
    }

    $("#kode_produk").focus();
} );
    </script>

  </section>
@endsection
