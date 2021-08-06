@extends('template.master')
@section('title', 'Data Rekening')

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
                            Tambah Rekening
                        </button>
                    </div>
                    <div class="col-sm-12">
                        <table id="tableMember" class="table table-bordered table-hover text-center" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Add Member --}}
    @include('jasatf.modal_add_rekening')

    <script>
        function doSave(){
            $('#modal-lg').modal('hide');
            $.ajax({
                type: 'POST',
                url: '/rekening/insert',
                data: {
                    "an" : $('#add_nama').val(),
                    "norek" : $('#add_norek').val(),
                    "bank" : $('#add_bank').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal input rekening'
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
                        $('#add_nama').val("");
                        $('#add_norek').val("");
                        $('#add_bank').val("");
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
                url: '/rekening/getById',
                data: {
                    "id" : id,
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Rekening tidak ditemukan'
                        });
                        return;
                    }else{
                        $('#tambah_rekening').hide();
                        $('#edit_rekening').show();
                        $('#modal-lg').modal('show');
                        $('#add_id').val(id);
                        $('#add_nama').val(data.data.an);
                        $('#add_norek').val(data.data.norek);
                        $('#add_bank').val(data.data.bank);
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
                    url: '/rekening/delete',
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
                url: '/rekening/update',
                data: {
                    "id" : $('#add_id').val(),
                    "nama" : $('#add_nama').val(),
                    "norek" : $('#add_norek').val(),
                    "bank" : $('#add_bank').val(),
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: data.msg
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
            $.getJSON("/rekening/getAll", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#tableMember').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Nama" },
                        { title: "Rekening" },
                        { title: "Bank" },
                        { title: "Tgl Registrasi" },
                        { 
                            title: "Action",
                            data: "0",
                            render:function (data, type, row) {
                                return `
                                <button class='btn btn-primary' id='btnEdit' onClick='doEdit(${data})' >Edit</button>
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
            $('#add_id').val("");
            $('#add_nama').val("");
            $('#add_norek').val("");
            $('#add_bank').val("");
            $('#tambah_rekening').show();
            $('#edit_rekening').hide();
        }

        $(document).ready(function() {
            $('#btnTambah').on('click', function () {
                doReset();
                $('#modal-lg').modal('show');
            });
            $('#tambah_rekening').on('click', function () {
                doSave();
            });
            $('#edit_rekening').on('click', function () {
                doUpdate();
            });
            
            doReset();
            doRefreshTable();
        });


    </script>

  </section>
@endsection
