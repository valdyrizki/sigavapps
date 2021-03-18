@extends('template.master')
@section('title', 'Data Produk')

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
                            Tambah Produk
                        </button>
                    </div>
                    <div class="col-sm-12">
                        <table id="table_produk" class="table table-bordered table-hover text-center" style="width:100%">
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Add Produk --}}
    @include('produk.modal_add_produk')

    <script>
        function doSave(){
            $('#modal-lg').modal('hide');
            $.ajax({
                type: 'POST',
                url: '/produk/insert',
                data: {
                    "nama_produk" : $('#nama_produk').val(),
                    "id_kategori" : $('#id_kategori').val(),
                    "stok" : $('#stok').val(),
                    "bank" : $('#add_bank').val(),
                    "harga_modal" : $('#harga_modal').val().replaceAll('.',''),
                    "harga_jual" : $('#harga_jual').val().replaceAll('.',''),
                    "diskon" : $('#diskon').val(),
                    "distributor" : $('#distributor').val(),
                    "status" : $('#status').val(),
                    "deskripsi" : $('#deskripsi').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal input produk'
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
                url: '/produk/getById',
                data: {
                    "id" : id,
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Produk tidak ditemukan'
                        });
                        return;
                    }else{
                        $('#tambah_produk').hide();
                        $('#edit_produk').show();
                        $('#modal-lg').modal('show');
                        $('#id').val(data.id);
                        $('#nama_produk').val(data.nama_produk);
                        $('#id_kategori').val(data.id_kategori);
                        $('#id_kategori').trigger('change');
                        $('#stok').val(data.stok);
                        $('#stok').prop("disabled",true);
                        $('#add_bank').val(data.add_bank);
                        $('#harga_modal').val(formatRupiah(data.harga_modal));
                        $('#harga_jual').val(formatRupiah(data.harga_jual));
                        $('#diskon').val(data.diskon);
                        $('#distributor').val(data.distributor);
                        $('#status').val(data.status);
                        $('#deskripsi').val(data.deskripsi);
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
                    url: '/produk/delete',
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
                return
            }
        })
        }

        function doUpdate(){
            $('#modal-lg').modal('hide');
            $.ajax({
                type: 'PUT',
                url: '/produk/update',
                data: {
                    "id" : $('#id').val(),
                    "nama_produk" : $('#nama_produk').val(),
                    "id_kategori" : $('#id_kategori').val(),
                    "harga_modal" : $('#harga_modal').val().replaceAll('.',''),
                    "harga_jual" : $('#harga_jual').val().replaceAll('.',''),
                    "diskon" : $('#diskon').val(),
                    "distributor" : $('#distributor').val(),
                    "status" : $('#status').val(),
                    "deskripsi" : $('#deskripsi').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal update produk'
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
            $.getJSON("/produk/getAll", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#table_produk').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "ID" },
                        { title: "Nama" },
                        { title: "Kategori" },
                        { title: "Stok" },
                        { title: "Modal" },
                        { title: "Jual" },
                        { title: "Distributor" },
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
            $('#id').val("");
            $('#tambah_produk').show();
            $('#edit_produk').hide();
            $('#nama_produk').val("");
            $('#id_kategori').val(0);
            $('#id_kategori').trigger("change");
            $('#stok').val("");
            $('#stok').prop("disabled",false);
            $('#add_bank').val("");
            $('#harga_modal').val("");
            $('#harga_jual').val("");
            $('#diskon').val("");
            $('#distributor').val("");
            $('#status').val(1);
            $('#deskripsi').val("");
        }

        function doLoadKategori(){
            $('#id_kategori').empty();
            $('#id_kategori').append($("<option value='0' disabled selected>").text("--- Pilih Kategori ---"));
            $.getJSON("/product-category/getAll", function(json){
                $.each(json.data, function(i, obj){
                    $('#id_kategori').append($('<option>').text(obj.id +' - '+obj.category_name).attr({
                        value: obj.id,
                        name: obj.category_name
                    }));
                });
            });
        }

$(document).ready(function() {
    $('#id_kategori').select2();
    $('#btnTambah').on('click', function () {
        doReset();
        $('#modal-lg').modal('show');
    });
    $('#tambah_produk').on('click', function () {
        doSave();
    });
    $('#edit_produk').on('click', function () {
        doUpdate();
    });

    $("#harga_modal").keyup(function(){
        let harga_modal = formatRupiah($("#harga_modal").val());
        $("#harga_modal").val(harga_modal);
    });

    $("#harga_jual").keyup(function(){
        let harga_jual = formatRupiah($("#harga_jual").val());
        $("#harga_jual").val(harga_jual);
    });
    
    doReset();
    doRefreshTable();
    doLoadKategori();
});


    </script>

  </section>
@endsection
