@extends('template.master')
@section('title', 'List Hutang')

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
                                    <button type="button" class="form-control btn btn-primary" id="btnSearch">Tampilkan Hutang</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="tableHutang" class="table table-bordered table-hover text-center" style="width:100%">
                                    <thead>
                                        <tr>
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
        </form>
    </div>

    <script>

$(document).ready(function() {
    $('#reservation').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('#btnBayar').on( 'click', function () {
        doBayar();
    } );

    $("#jumlah_pemasukan").keyup(function(){
        let jumlah_pemasukan = formatRupiah($("#jumlah_pemasukan").val());
        $("#jumlah_pemasukan").val(jumlah_pemasukan);
    });

} );

    function doRefreshTable(){
        $.getJSON("/hutang/getAll", function(json){
            const dataSet = json.data.map(value => Object.values(value));
            $('#tableHutang').DataTable( {
                data: dataSet,
                destroy: true,
                columns: [
                    { title: "ID" },
                    { title: "Nama" },
                    { title: "Deskripsi" },
                    { title: "Jumlah" },
                    { title: "Status" },
                    { title: "Tanggal" },
                    { 
                            title: "Action",
                            data: "0",
                            render:function (data, type, row) {
                                return `
                                <button class='btn btn-success' id='btnBayar' onClick='doBayar(${data})'>Bayar</button>
                                `;        
                            }
                        }
                ],
                "order": [ 0, 'desc' ]
            } );
        });
    }

    function doBayar(id){
        event.preventDefault();
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/hutang/bayar',
            data: {
                "id" : id
            }, // or JSON.stringify ({name: 'jonas'}),
            success: function(data) {
                if(data.status == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal bayar hutang'
                    });
                    return;
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    doRefreshTable();
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
