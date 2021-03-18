@extends('template.master')
@section('title', $md5)

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-exchange-alt"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text text-bold">Saldo</span>
                    <span class="info-box-number">
                        <div class="row">
                            <small>Rp </small>
                            <span id="saldo_ppob" class="pl-1"></span>
                        </div>
                    </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <label for="inputCategory" class="form-label">Pilih Kategori</label>
                            <select id="category_id" name="category_id" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inputProvider" class="form-label">Pilih Provider</label>
                            <select id="operator_id" name="operator_id" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inputProduct" class="form-label">Pilih Produk</label>
                            <select id="product_id" name="product_id" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-8">
                            <label for="inputNopel" class="form-label">Nomor Pelanggan</label>
                            <input type="text" class="form-control" name="destination" id="destination" autocomplete="disabled">
                        </div>
                        <div class="col-md-4">
                            <label for="inputNorek" class="form-label">Harga</label>
                            <input type="text" class="form-control" name="product_price" id="product_price" disabled>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-12">
                            <label for="inputNorek" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" id="description" disabled></textarea>
                        </div>
                    </div>
                    
                    <div class="row pb-2">
                        <button type="button" class="btn btn-primary col-12" id="btnKirim">
                            Kirim
                        </button>
                    </div>
                </div>
            </div>
                
            <div class="col-12">
                <div class="card py-3 px-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tableJasaTF" class="table table-bordered table-hover text-center" style="width:100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        

        function doSend(){
            let dataTfHtml = "Kategori : "+$('#category_id option:selected').attr("name")+"<br/>Provider : "+$('#operator_id option:selected').attr("name")+"<br/>Produk : "+$('#product_id option:selected').attr("name")+"<br/>Harga : Rp "+$('#product_price').val()+"<br/>No Tujuan : "+$('#destination').val();            
            Swal.fire({
            title: 'Data Pelanggan :',
            html: dataTfHtml,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proses !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                $.ajax({
                    type: 'POST',
                    url: '/ppob/send',
                    data: {
                        "product_id" : $('#product_id').val(),
                        "destination" : $('#destination').val(),
                        "operator_id" : $('#operator_id').val()
                    }, // or JSON.stringify ({name: 'jonas'}),
                    success: function(data) {
                        console.log(data);
                    },
                    // contentType: "application/json",
                    dataType: 'JSON'
                });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Cancel',
                        text: 'Transaksi dibatalkan !'
                    });
                }
            })
        }

        function doRefreshTable(){
            $.getJSON("/jasatf/getAll", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#tableJasaTF').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "Waktu" },
                        { title: "ID" },
                        { title: "No. Rekening" },
                        { title: "Atas Nama" },
                        { title: "Jumlah TF" },
                        { title: "Biaya Admin" }
                    ],
                });
            });
            doReset();
            getSaldoPpob();
        }

        function doLoadCategory(){
            $('#category_id').empty();
            $('#category_id').append($("<option value='0' disabled selected>").text("--- Pilih Kategori ---"));
                let res = {!!$response!!};
                $.each(res.responseData, function(i, obj){
                    $('#category_id').append($('<option>').text(obj.product_name).attr({
                        value: obj.product_id,
                        name: obj.product_name
                    }));
                });
        }

        function getSaldoPpob(){
            $.getJSON("/ppob/getSaldo", function(json){
                $("#saldo_ppob").html(formatNumber(json));
            });
        }

        function doReset(){
            $("#product_id").empty();
            $("#operator_id").empty();
            doLoadCategory();
        }

$(document).ready(function() {
    $('#btnTambahRekening').on('click', function () {
        doReset();
        $('#modal-lg').modal('show');
    });
    $('#btnKirim').on('click', function () {
        doSend();
    });
    $('#tambah_rekening').on('click', function () {
        doAddRek();
    });

    $("#category_id").change(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'PUT',
            url: '/ppob/getOperator',
            data: {
                "category_id" : $("#category_id").val(),
            },
            success: function(data) {
                if(data.responseCode == 200){
                    $('#operator_id').empty();
                        $.each(data.responseData, function(i, obj){
                        $('#operator_id').append($('<option>').text(obj.product_name).attr({
                            value: obj.product_id,
                            name: obj.product_name
                        }));
                    });
                    $("#operator_id").trigger("change");
                }else{

                }
                
            }
        });
        
    });

    $("#operator_id").change(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'PUT',
            url: '/ppob/getProduct',
            data: {
                "operator_id" : $("#operator_id").val(),
            },
            success: function(data) {
                if(data.responseCode == 200){
                    console.log(data.responseData);
                    $('#product_id').empty();
                    $.each(data.responseData, function(i, obj){
                        $('#product_id').append($('<option>').text(obj.product_name).attr({
                            value: obj.product_id,
                            id: obj.product_id,
                            name: obj.product_name,
                            product_price: obj.product_price,
                            product_detail: obj.product_detail
                        }));
                    });
                    $("#product_id").trigger("change");
                }else{

                }
                
            }
        });
        
    });

    $("#product_id").change(function () {
        let id = "#"+$("#product_id").val();
        $("#description").val($(id).attr("product_detail"));
        $("#product_price").val($(id).attr("product_price"));
        $("#destination").focus();
        $("#product_price").keyup();
    });

    $("#product_price").keyup(function(){
        let product_price = formatRupiah($("#product_price").val());
        $("#product_price").val(product_price);
    });

    doRefreshTable();
});
    </script>
  </section>
@endsection
