@extends('template.master')
@section('title', 'Kategori Produk')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">
                    <div class="col-md-4 pb-2">
                        <button type="button" class="btn btn-primary" id="btnTambah">
                            Tambah Kategori
                        </button>
                    </div>
                    <div class="col-sm-12">
                        <table id="tableCategory" class="table table-bordered table-hover text-center" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Add Member --}}
    @include('trx-category.modal_add_category')

    <script>
        function doSave(){
            $('#modal-lg').modal('hide');
            $.ajax({
                type: 'POST',
                url: '/trx-category/insert',
                data: {
                    "category_name" : $('#category_name').val(),
                    "description" : $('#description').val(),
                    "type" : $('#type').val(),
                    "status" : $('#status').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal input kategori'
                        });
                        $('#modal-lg').modal('show');
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
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }

        function doEdit(id){
            $.ajax({
                type: 'PUT',
                url: '/trx-category/getById',
                data: {
                    "id" : id,
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Kategori tidak ditemukan'
                        });
                        return;
                    }else{
                        
                        $('#add_category').hide();
                        $('#edit_category').show();
                        $('#modal-lg').modal('show');
                        $('#id').val(id);
                        $('#category_name').val(data.data.category_name);
                        $('#status').val(data.data.status);
                        $('#type').val(data.data.type);
                        $('#description').val(data.data.description);
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }

        function doDelete(id){
            Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data akan dihapus dari database ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya hapus data !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'DELETE',
                    url: '/trx-category/delete',
                    data: {
                        "id" : id
                    }, // or JSON.stringify ({name: 'jonas'}),
                    success: function(data) {
                        if(data.error){
                            Swal.fire({
                                title: 'Error!',
                                text: data.msg,
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                        }else{
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            doRefreshTable();
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
        }

        function doUpdate(){
            $('#modal-lg').modal('hide');
            $.ajax({
                type: 'PUT',
                url: '/trx-category/update',
                data: {
                    "id" : $('#id').val(),
                    "category_name" : $('#category_name').val(),
                    "type" : $('#type').val(),
                    "description" : $('#description').val(),
                    "status" : $('#status').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal update Kategori'
                        });
                        $('#modal-lg').modal('show');
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
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }

        function doRefreshTable(){
            $.getJSON("/trx-category/getAll", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#tableCategory').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Nama Kategori" },
                        { title: "Deskripsi" },
                        { title: "Type" },
                        { title: "Status" },
                        { title: "Tgl Registrasi" },
                        { 
                            title: "Action",
                            data: "0",
                            render:function (data, type, row) {
                                return `
                                <button class='btn btn-primary' id='btnEdit' onClick='doEdit(${data})' >Edit</button>
                                <br/>
                                <button class='btn btn-danger' id='btnDelete' onClick='doDelete(${data})'>Delete</button>
                                `;        
                            }
                        }
                    ],
                });
            });
            doReset();
        }

        function doReset(){
            $('#id').val("");
            $('#category_name').val("");
            $('#status').val(1);
            $('#type').val(1);
            $('#description').val("");
            $('#add_category').show();
            $('#edit_category').hide();
        }

$(document).ready(function() {
    $('#btnTambah').on('click', function () {
        doReset();
        $('#modal-lg').modal('show');
    });
    $('#add_category').on('click', function () {
        doSave();
    });
    $('#edit_category').on('click', function () {
        doUpdate();
    });
    
    doReset();
    doRefreshTable();
});


    </script>

  </section>
@endsection
