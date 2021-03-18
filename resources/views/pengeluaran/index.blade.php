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
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Deskripsi Pengeluaran</label>
                                <textarea class="form-control" name="deskripsi_pengeluaran" id="deskripsi_pengeluaran"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" name="id_trx_category" id="id_trx_category">
                                    <option value="0" disabled selected>--- Pilih Kategori ---</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{$k->id}}">{{$k->category_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Jumlah Pengeluaran</label>
                                <input type="text" class="form-control" name="jumlah_pengeluaran" id="jumlah_pengeluaran">
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
                                    <button type="button" class="form-control btn btn-primary" id="btnSearch">Tampilkan Pengeluaran</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="tablePengeluaran" class="table table-bordered table-hover text-center" style="width:100%">
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

$(document).ready(function() {
    $('#reservation').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('#save').on( 'click', function () {
        doSave();
    } );

    $("#id_trx_category").change(function () {
        getDescCategory();
        $("#jumlah_pengeluaran").focus();
    });

    $('#btnSearch').on( 'click', function () {
        let tgl = $("#reservation").val();
        let tglAwal = tgl.substr(0,10);   
        let tglAkhir = tgl.substr(13);
        searchPengeluaran(tglAwal,tglAkhir);
    });

    $("#jumlah_pengeluaran").keyup(function(){
        let jumlah_pengeluaran = formatRupiah($("#jumlah_pengeluaran").val());
        $("#jumlah_pengeluaran").val(jumlah_pengeluaran);
    });

} );

    function getDescCategory(){
        let id_trx_category = <?php echo json_encode($kategori); ?>;
        id_trx_category.forEach(element => {
            if(element.id == $('#id_trx_category').val()){
                $('#desc_kategori').html('* '+element.description); 
            }
        });
    }

    function doRefreshTable(){
        $.getJSON("/pengeluaran/getAll", function(json){
            const dataSet = json.data.map(value => Object.values(value));
            $('#tablePengeluaran').DataTable( {
                data: dataSet,
                destroy: true,
                columns: [
                    { title: "ID" },
                    { title: "Tanggal" },
                    { title: "Deskripsi" },
                    { title: "Kategori" },
                    { title: "Jumlah" }
                ],
                "order": [ 0, 'desc' ]
            } );
        });
    }

    function searchPengeluaran(start,end){
        $.ajax({
            type: 'GET',
            url: '/pengeluaran/getByDate',
            data: {
                "start" : start,
                "end" : end
            }, // or JSON.stringify ({name: 'jonas'}),
            success: function(data) {
                const dataSet = data.data.map(value => Object.values(value));
                $('#tablePengeluaran').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Tanggal" },
                        { title: "Deskripsi" },
                        { title: "Kategori" },
                        { title: "Jumlah" }
                    ],
                    "order": [ 0, 'desc' ]
                } );

            },
            // contentType: "application/json",
            dataType: 'JSON'
        });
    }

    function doSave(){
        let deskripsi_pengeluaran = $("#deskripsi_pengeluaran").val();
        let jumlah_pengeluaran = $("#jumlah_pengeluaran").val().replaceAll('.','');
        let id_trx_category = $("#id_trx_category").val();

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
                "jumlah_pengeluaran" : jumlah_pengeluaran,
                "id_trx_category" : id_trx_category
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
                    $('#deskripsi_pengeluaran').val("");
                    $('#jumlah_pengeluaran').val("");
                    $('#id_trx_category').val(0);
                    doRefreshTable();
                }
             },
            // contentType: "application/json",
            dataType: 'JSON'
        });
    }

    getDescCategory();
    doRefreshTable();



    </script>

  </section>
@endsection
