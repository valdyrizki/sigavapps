@extends('template.master')
@section('title', 'Laporan Penjualan')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">

                    <form action="/laporan/penjualan" method="POST">
                        @csrf
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
                                    <button type="submit" class="form-control btn btn-primary" id="tambahStok">Tampilkan Laporan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="report" class="table table-bordered table-hover text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Action</th>
                                    <th>Tanggal</th>
                                    <th>Nama Produk</th>
                                    <th>Total Jual</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $omset = 0;
                                    $no = 1;
                                @endphp
                                @foreach ($report as $rpt)
                                <tr>
                                    <td>{{$no}}</td>
                                    <td>
                                    @if ($rpt->id_eod == 0)
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-sm" onclick="showModal({{$rpt->id}})">
                                            Refund
                                        </button>
                                    @endif
                                    </td>
                                    <td>{{$rpt->created_at}}</td>
                                    <td>{{$rpt->id_trx_category != 1 ? $rpt->deskripsi_transaksi : $rpt->nama_produk}}</td>
                                    <td>{{$rpt->jumlah}}</td>

                                <td class="{{$rpt->total_harga > 0 ? 'bg-success' : 'bg-danger'}}">@currency($rpt->total_harga)</td>
                                </tr>
                                @php
                                    $no++;
                                    $omset += $rpt->total_harga;
                                @endphp
                                @endforeach
                                <tr>
                                    @if ($omset == 0)
                                    <td colspan="5">TIDAK ADA TRANSAKSI</td>
                                    @else
                                    <td colspan="4">Total</td>
                                    <td>@currency($omset)</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
    </div>
    @include('laporan.modal_refund')


    <script>

            function showModal(id){
                $('#id_detailtransaksi').val(id);
            }

        $(document).ready(function(){

            $('#reservation').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            let dttable = $('#report').DataTable({
                "paging": true,
                "lengthChange": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
             });

             $('.parent #refund').on( 'click', function () {
                alert('SUKSES');
                let deskripsi_refund = $("#deskripsi_refund").val();

                $.ajax({
                    type: 'POST',
                    url: '/pengeluaran/insert',
                    data: {
                        "deskripsi_refund" : deskripsi_pengeluaran,
                        "jumlah_pengeluaran" : jumlah_pengeluaran
                    }, // or JSON.stringify ({name: 'jonas'}),
                    success: function(data) {
                        alert('data: ' + data.message);

                        dttable.row.add( [
                            deskripsi_pengeluaran,
                            jumlah_pengeluaran*-1
                        ] ).draw( false );

                        afterGenerate();
                    },
                    // contentType: "application/json",
                    dataType: 'JSON'
                });
            } );

    });

        </script>

  </section>
@endsection
