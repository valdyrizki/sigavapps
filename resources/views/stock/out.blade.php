@extends('template.master')
@section('title', 'Stock Out')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="#" method="POST">
            @csrf
      <!-- Info boxes -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- select -->
                                <div class="form-group">
                                <label>Nama Produk</label>
                                <select class="form-control" height="48" name="nama_produk" id="nama_produk">
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                <label>Stock Saat Ini</label>
                                <input type="text" class="form-control" name="last_stock" id="last_stock" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                <label>Kurangi Stok</label>
                                <input type="text" class="form-control" name="stock_out" id="stock_out">
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>
                            
                        </div>

                        <p id="desc_kategori" class="text-danger"/>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="form-control btn btn-primary" id="save">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-sm-8">
                                <!-- select -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control float-right" name="dtReport" id="reservation">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="button" class="form-control btn btn-primary" id="btnSearch">Tampilkan History</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="tableHistStok" class="table table-bordered table-hover text-center" style="width:100%">
                                    <thead>
                                        <tr>
                                            {{-- <th>Tanggal</th>
                                            <th>Deskripsi Pengeluaran</th>
                                            <th>Kategori</th>
                                            <th>Jumlah Pengeluaran</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($transaksi as $trx)
                                        <tr>
                                            <td>{{$trx->created_at}}</td>
                                            <td>{{$trx->deskripsi_transaksi}}</td>
                                            <td>{{$trx->nama}}</td>
                                            <td>@currency($trx->total_harga*-1)</td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        async function getProduct(){
            await $.getJSON("/produk/get", function(json){
                $('#nama_produk').empty();
                $('#nama_produk').append($('<option disabled selected>').text("--- Pilih Produk ---"));
                $.each(json, function(i, obj){
                    $('#nama_produk').append($('<option>').text(obj.nama_produk).attr({
                        value: obj.id,
                        name: obj.nama_produk
                    }));
                });
            });
            $("#nama_produk").select2('open');
        }

        function getStock(){
            $.ajax({
                type: 'PUT',
                url: '/produk/getStockById',
                data: {
                    "id" : $("#nama_produk").val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Produk tidak ditemukan'
                        });
                        return;
                    }else{
                        $("#last_stock").val(data);
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }

$(document).ready(function() {
    $('#nama_produk').select2();
    getProduct();

    $("#nama_produk").change(async function () {
        await getStock();
        $("#stock_out").focus();
    });

    $('#reservation').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('#save').on( 'click', function () {
        doSave();
    } );

    $('#btnSearch').on( 'click', function () {
        let tgl = $("#reservation").val();
        let tglAwal = tgl.substr(0,10);   
        let tglAkhir = tgl.substr(13);
        searchHistoryStok(tglAwal,tglAkhir);
    });

} );

    function doRefreshTable(){
        $.getJSON("/produk/getHistoryStokOut", function(json){
            const dataSet = json.data.map(value => Object.values(value));
            $('#tableHistStok').DataTable( {
                data: dataSet,
                destroy: true,
                columns: [
                    { title: "Waktu" },
                    { title: "Nama Produk" },
                    { title: "Kurang" },
                    { title: "Before" },
                    { title: "After" },
                    { title: "Deskripsi" }
                ],
                "ordering": false
            } );
        });
    }

    function searchHistoryStok(start,end){
        $.ajax({
            type: 'GET',
            url: '/produk/getHistoryStokOutByDate',
            data: {
                "start" : start,
                "end" : end
            }, // or JSON.stringify ({name: 'jonas'}),
            success: function(data) {
                const dataSet = data.data.map(value => Object.values(value));
                $('#tableHistStok').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "Waktu" },
                        { title: "Nama Produk" },
                        { title: "Kurang" },
                        { title: "Before" },
                        { title: "After" },
                        { title: "Deskripsi" }
                    ],
                    "ordering": false
                } );

            },
            // contentType: "application/json",
            dataType: 'JSON'
        });
    }

    function doSave(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/stock-out/insert',
            data: {
                "id_produk" : $("#nama_produk").val(),
                "stock_out" : $("#stock_out").val(),
                "description" : $("#description").val()
            }, // or JSON.stringify ({name: 'jonas'}),
            success: function(data) {
                if(data.status == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: data.msg
                    });
                    return;
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    doRefreshTable();
                    getProduct();
                    $("#last_stock").val("")
                    $("#stock_out").val("")
                    $("#description").val("")
                }
            },
            // contentType: "application/json",
            dataType: 'JSON'
        });
    }

    doRefreshTable();



    </script>

  </section>
@endsection
