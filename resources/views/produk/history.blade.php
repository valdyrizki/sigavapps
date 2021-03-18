@extends('template.master')
@section('title', 'History Produk')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">
                    <div class="col-sm-12">
                        <table id="tableProduk" class="table table-bordered table-hover text-center" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function doRefreshTable(){
            $.getJSON("/history-produk/getAllHistory", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#tableProduk').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Nama Produk" },
                        { title: "Harga Modal Before" },
                        { title: "Harga Modal After" },
                        { title: "Harga Jual Before" },
                        { title: "Harga Jual After" },
                        { title: "Waktu" }
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
