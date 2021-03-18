@extends('template.master')
@section('title', 'Data Member')

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
                            Tambah Member
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
    @include('member.modal_add_member')

    <script>
        function doSave(){
            $('#modal-lg').modal('hide');
            $.ajax({
                type: 'POST',
                url: '/member/insert',
                data: {
                    "nama" : $('#add_nama').val(),
                    "no_hp" : $('#add_nohp').val(),
                    "norek" : $('#add_norek').val(),
                    "bank" : $('#add_bank').val(),
                    "deskripsi" : $('#add_deskripsi').val(),
                    "status" : $('#add_status').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal input member'
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
                url: '/member/getById',
                data: {
                    "id" : id,
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Member tidak ditemukan'
                        });
                        return;
                    }else{
                        
                        $('#tambah_member').hide();
                        $('#edit_member').show();
                        $('#modal-lg').modal('show');
                        $('#add_id').val(id);
                        $('#add_nama').val(data.data.nama);
                        $('#add_nohp').val(data.data.no_hp);
                        $('#add_norek').val(data.data.norek);
                        $('#add_bank').val(data.data.bank);
                        $('#add_status').val(data.data.status);
                        $('#add_deskripsi').val(data.data.deskripsi);
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
                    url: '/member/delete',
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
                url: '/member/update',
                data: {
                    "id" : $('#add_id').val(),
                    "nama" : $('#add_nama').val(),
                    "no_hp" : $('#add_nohp').val(),
                    "norek" : $('#add_norek').val(),
                    "bank" : $('#add_bank').val(),
                    "deskripsi" : $('#add_deskripsi').val(),
                    "status" : $('#add_status').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal update member'
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
            $.getJSON("/member/getAll", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#tableMember').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Nama" },
                        { title: "No HP" },
                        { title: "Rekening" },
                        { title: "Bank" },
                        { title: "Deskripsi" },
                        { title: "Status" },
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
            $('#add_nohp').val("");
            $('#add_norek').val("");
            $('#add_bank').val("");
            $('#add_status').val(1);
            $('#add_deskripsi').val("");
            $('#tambah_member').show();
            $('#edit_member').hide();
        }

$(document).ready(function() {
    $('#btnTambah').on('click', function () {
        doReset();
        $('#modal-lg').modal('show');
    });
    $('#tambah_member').on('click', function () {
        doSave();
    });
    $('#edit_member').on('click', function () {
        doUpdate();
    });
    
    doReset();
    doRefreshTable();
});


    </script>

  </section>
@endsection
