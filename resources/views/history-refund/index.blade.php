@extends('template.master')
@section('title', 'History Refund')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">
                    <div class="col-sm-12">
                        <table id="tableRefund" class="table table-bordered table-hover text-center" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function doRefreshTable(){
            $.getJSON("/history-refund/getAll", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#tableRefund').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Nama Produk" },
                        { title: "Jumlah" },
                        { title: "Alasan" },
                        { title: "Waktu" },
                    ],
                    "order": [ 0, 'desc' ]
                });
            });
        }

$(document).ready(function() {
    doRefreshTable();
});


    </script>

  </section>
@endsection
