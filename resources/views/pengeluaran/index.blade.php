@extends('template.master')
@section('title', 'Input Pengeluaran')

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
                                <div class="form-group">
                                <label>Deskripsi Pengeluaran</label>
                                <textarea class="form-control" name="deskripsi_pengeluaran" id="deskripsi_pengeluaran"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Jumlah Pengeluaran</label>
                                <input type="number" class="form-control" name="jumlah_pengeluaran" id="jumlah_pengeluaran" >
                                </div>
                            </div>
                        </div>

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
                        <div class="col-sm-12">
                            <table id="tablePengeluaran" class="table table-bordered table-hover text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Deskripsi Pengeluaran</th>
                                        <th>Jumlah Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi as $trx)
                                    <tr>
                                        <td>{{$trx->created_at}}</td>
                                        <td>{{$trx->deskripsi_transaksi}}</td>
                                        <td>@currency($trx->total_harga*-1)</td>
                                    </tr>
                                    @endforeach
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
    let dttable = $('#tablePengeluaran').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "order": [[ 0, "desc" ]]
    });

    $('#save').on( 'click', function () {

        let deskripsi_pengeluaran = $("#deskripsi_pengeluaran").val();
        let jumlah_pengeluaran = $("#jumlah_pengeluaran").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/pengeluaran/insert',
            data: {
                "deskripsi_pengeluaran" : deskripsi_pengeluaran,
                "jumlah_pengeluaran" : jumlah_pengeluaran
            }, // or JSON.stringify ({name: 'jonas'}),
            success: function(data) {
                if(data.status == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal input pengeluaran transaksi'
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

                    var d = new Date,
                        dformat = [
                        d.getFullYear(),
                        d.getMonth()+1,
                        d.getDate()
                        ].join('-')+' '+
                        [d.getHours(),
                        d.getMinutes(),
                        d.getSeconds()].join(':');

                    dttable.row.add( [
                        dformat,
                        deskripsi_pengeluaran,
                        jumlah_pengeluaran
                    ] ).draw( false );

                    $('#deskripsi_pengeluaran').val("");
                    $('#jumlah_pengeluaran').val("");
                }
             },
            // contentType: "application/json",
            dataType: 'JSON'
        });
    } );



} );


    </script>

  </section>
@endsection
