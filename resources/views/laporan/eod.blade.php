@extends('template.master')
@section('title', 'Laporan EOD')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">

                    <form action="/laporan/eod" method="POST">
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
                                    <th>Omset</th>
                                    <th>Pengeluaran</th>
                                    <th>Profit</th>
                                    <th>Saldo Akhir</th>
                                    <th>Setoran TF</th>
                                    <th>Admin TF</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report as $rpt)
                                <tr>
                                    <td>{{$rpt->id}}</td>
                                    <td>@currency($rpt->omset)</td>
                                    <td>@currency($rpt->expense)</td>
                                    <td>@currency($rpt->profit)</td>
                                    <td>@currency($rpt->saldo_akhir)</td>
                                    <td>@currency($rpt->total_tf)</td>
                                    <td>@currency($rpt->admin_tf)</td>
                                    <td>{{$rpt->created_at}}</td>
                               </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

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
    });

        </script>

  </section>
@endsection
