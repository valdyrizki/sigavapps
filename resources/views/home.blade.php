@extends('template.master')
@section('title', 'Home')

@section('content')



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row pb-2">
        <div class="col-12">
            <button type="button" class="btn btn-danger" id="eod">Tutup Toko</button>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Omset</span>
              <span class="info-box-number">
                @currency($sellDay->total_omset)
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-coins"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Admin TF</span>
              <span class="info-box-number">@currency($admin_tf)</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Profit</span>
              <span class="info-box-number">@currency($profit)</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cash-register"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Saldo</span>
              <span class="info-box-number">@currency($finance->balance)</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-exchange-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Uang TF</span>
              <div class="row">
                <b class="pr-1 pt-1 pl-1">@currency($uang_tf) </b>
                <span class="info-box-number mb-2" id='setoran_tf'>
                </span>
              </div>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-minus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Uang Minus</span>
              <span class="info-box-number">@currency($uang_minus)</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Uang Plus /Bulan</span>
              <span class="info-box-number">@currency($uang_plus)</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-check-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Asset</span>
              <span class="info-box-number">@currency($total_asset)</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      {{-- <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Monthly Recap Report</h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-wrench"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="#" class="dropdown-item">Action</a>
                    <a href="#" class="dropdown-item">Another action</a>
                    <a href="#" class="dropdown-item">Something else here</a>
                    <a class="dropdown-divider"></a>
                    <a href="#" class="dropdown-item">Separated link</a>
                  </div>
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Sales: 1 Juli, 2020 - 30 Desember, 2020</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Target Penjualan / Bulan</strong>
                  </p>

                  <div class="progress-group">
                    Kuota
                    <span class="float-right"><b>160</b>/200</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->

                  <div class="progress-group">
                    Pulsa
                    <span class="float-right"><b>310</b>/400</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: 75%"></div>
                    </div>
                  </div>

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Headset</span>
                    <span class="float-right"><b>3</b>/10</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: 30%"></div>
                    </div>
                  </div>

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    Tentang Kita
                    <span class="float-right"><b>100</b>/500</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-warning" style="width: 20%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./card-body -->
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">TOTAL OMSET</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">TOTAL BELANJA</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                    <h5 class="description-header">$24,813.53</h5>
                    <span class="description-text">TOTAL PROFIT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                    <h5 class="description-header">1200</h5>
                    <span class="description-text">TARGET PENJUALAN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row --> --}}

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-6">
          <!-- MAP & BOX PANE -->


          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Orders</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>TRX ID</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($lastTrx as $lt)
                        <tr>
                            <td><span class="badge {{$lt->total_harga>0?'badge-success':'badge-danger'}}">{{$lt->id}}</span></td>
                            <td>
                              @if ($lt->id_trx_category != 1)
                                {{$lt->deskripsi_transaksi}}
                              @else
                                {{$lt->nama_produk}}
                              @endif
                            </td>
                            <td>{{$lt->jumlah}}</td>
                            <td>@currency($lt->total_harga)</td>
                            <td>{{$lt->created_at}}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <a href="/transaksi" class="btn btn-sm btn-info float-left">Transaksi Baru</a>
              <a href="/laporan/penjualan" class="btn btn-sm btn-secondary float-right">Lihat Riwayat Transaksi</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <!-- TABLE: HISTORY REFUND -->

        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-transparent">
                <h3 class="card-title">History Refund</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Alasan</th>
                        <th>Tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($refund as $rf)
                            <tr>
                                <td>{{$rf->deskripsi_transaksi}}</td>
                                <td>{{$rf->deskripsi_refund}}</td>
                                <td>{{$rf->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                <a href="/transaksi" class="btn btn-sm btn-info float-left">Transaksi Baru</a>
                <a href="/laporan/penjualan" class="btn btn-sm btn-secondary float-right">Lihat Riwayat Transaksi</a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
      </div>

        <div class="col-md-12">
          <!-- PRODUCT LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Stok Menipis</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table id="tableStok" class="table table-bordered table-hover text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Distributor</th>
                            <th>Stok Wajar</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $p)
                        <tr>
                            <td>{{$p->nama_produk}}</td>
                            <td>{{$p->distributor}}</td>
                            <td>{{$p->stok_wajar}}</td>
                            <td>
                                @if ($p->stok < ($p->stok_wajar/2))
                                    <span class="badge badge-danger float-center">{{$p->stok}}</span>
                                @else
                                    <span class="badge badge-warning float-center">{{$p->stok}}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="/produk" class="uppercase">View All Products</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>

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
        });
      });
      $('#eod').on('click',function (){

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "transaksi setelah tutup toko akan masuk ke hari selanjutnya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya proses EOD !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '/eod',
                    data: {
                    }, // or JSON.stringify ({name: 'jonas'}),
                    success: function(data) {
                        if(data.error){
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                        }else{
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload();
                        }


                    },
                    // contentType: "application/json",
                    dataType: 'JSON'
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Cancel',
                    text: 'Proses EOD dibatalkan !'
                });
            }
        })

        });
  </script>
  <!-- /.content -->
@endsection
