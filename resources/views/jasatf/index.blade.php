@extends('template.master')
@section('title', 'Data Jasa TF')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-exchange-alt"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Setoran TF</span>
                    <span class="info-box-number">
                        <div class="row">
                            <small>Rp </small>
                            <span id="setoran_tf" class="pl-1"></span>
                        </div>
                    </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Profit TF</span>
                    <span class="info-box-number">
                        <div class="row">
                            <small>Rp </small>
                            <span id="profit_tf" class="pl-1"></span>
                        </div>
                    </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-coins"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Biaya Admin</span>
                    <span class="info-box-number">
                        <div class="row">
                            <small>Rp </small>
                            <span id="admin_tf" class="pl-1"></span>
                        </div>
                    </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card py-3 px-3">
                    <div class="row pb-2">
                        <button type="button" class="btn btn-success" id="btnTambahRekening">
                            Rekening Baru
                        </button>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <label for="inputNorek" class="form-label">Pilih Rekening</label>
                            <select name="norek" height="48" id="search_norek" name="search_norek" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-md-3">
                            <label for="inputNorek" class="form-label">No. Rekening</label>
                            <input type="text" id="norek" name="norek"  class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="inputTF" class="form-label">Bank</label>
                            <input type="text" id="bank" name="bank" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="inputPassword5" class="form-label">Atas Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="inputTF" class="form-label">Total Transfer</label>
                            <input type="text" id="total_tf" name="total_tf" class="form-control numeric">
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="chkBuktiTf" id="chkBuktiTf">
                            <label class="form-check-label" for="chkBuktiTf">
                                Kirim bukti transfer
                            </label>
                        </div>
                        <button type="button" class="btn btn-primary col-12" id="btnTambahJasaTF">
                            Input Jasa TF
                        </button>
                    </div>
                        
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tableJasaTF" class="table table-bordered table-hover text-center" style="width:100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Add Member --}}
    @include('jasatf.modal_add_rekening')

    <script>
        function doAddRek(){
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
                        doLoadRekening();
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }

        function doSave(){
            let dataTfHtml = "Nama : "+$('#nama').val()+"<br/>Norek : "+$('#norek').val()+" ("+$('#bank').val()+")<br/>Jumlah : Rp "+$('#total_tf').val();
            if($("#chkBuktiTf").prop("checked")){
                dataTfHtml += "<br/><br/>*Upload bukti transfer"
            }
            
            Swal.fire({
            title: 'Data Transfer :',
            html: dataTfHtml,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proses Transfer !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '/jasatf/insert',
                    data: {
                        "jumlah" : $('#total_tf').val().replaceAll('.',''),
                        "bank" : $('#bank').val(),
                        "an" : $('#nama').val(),
                        "norek" : $('#norek').val()
                    }, // or JSON.stringify ({name: 'jonas'}),
                    success: function(data) {
                        if(data.status == 'error'){
                            Swal.fire({
                                icon: 'error',
                                title: data.msg
                            });
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
                            sendTelegram(dataTfHtml);
                            
                            
                        }
                    },
                    // contentType: "application/json",
                    dataType: 'JSON'
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Cancel',
                    text: 'Proses Transfer dibatalkan !'
                });
            }
        })
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
                        $('#tambah_member').html('Edit Member')
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
                                // doRefreshTable();
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

        function doRefreshTable(){
            $.getJSON("/jasatf/getAll", function(json){
                let dataSet = json.data.map(value => Object.values(value));
                $('#tableJasaTF').DataTable( {
                    data: dataSet,
                    destroy: true,
                    columns: [
                        { title: "Waktu" },
                        { title: "ID" },
                        { title: "No. Rekening" },
                        { title: "Atas Nama" },
                        { title: "Jumlah TF" },
                        { title: "Biaya Admin" },
                        { title: "Status" }
                    ],
                    "order": [ 0, 'desc' ]
                });
            });
            doReset();
            getSetoranTF();
            getProfitTF();
            getAdminTF();
        }

        function doLoadRekening(){
            $('#search_norek').empty();
            $('#search_norek').append($("<option value='0' disabled selected>").text("--- Pilih Rekening ---"));
            $.getJSON("/rekening/getAll", function(json){
                $.each(json.data, function(i, obj){
                    $('#search_norek').append($('<option>').text(obj.norek +' - '+obj.an).attr({
                        value: obj.norek,
                        name: obj.an
                    }));
                });
            });
        }

        function getSetoranTF(){
            $.getJSON("/jasatf/getSetoranTF", function(json){
                $("#setoran_tf").html(formatNumber(json));
            });
        }

        function getProfitTF(){
            $.getJSON("/jasatf/getProfitTF", function(json){
                $("#profit_tf").html(formatNumber(json));
            });
        }

        function getAdminTF(){
            $.getJSON("/jasatf/getAdminTF", function(json){
                $("#admin_tf").html(formatNumber(json));
            });
        }

        function doReset(){
            $('#add_nama').val("");
            $('#add_norek').val("");
            $('#add_bank').val("");
            $('#norek').val("");
            $('#nama').val("");
            $('#bank').val("");
            $('#total_tf').val("");
            
            $("#norek").prop('disabled' , false);
            $("#nama").prop('disabled' , false);
            $("#bank").prop('disabled' , false);
            $('#edit_rekening').hide();
            doLoadRekening();
        }

        function sendTelegram(msg){
            let message = "<b>=== Jasa Transfer ===</b>\n"+msg.replaceAll("<br/>","\n");
            $.ajax({
                type: 'GET',
                url: 'https://api.telegram.org/bot1641094965:AAG0kjhFWdBWXnygWwantTOtvjNEtvANiFU/sendMessage',
                data: {
                    "chat_id" : "-1001368719479",
                    "parse_mode" : "HTML",
                    "text" : message
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    console.log(data);
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        
        }

$(document).ready(function() {
    $('#search_norek').select2();
    $('#btnTambahRekening').on('click', function () {
        doReset();
        $('#modal-lg').modal('show');
    });
    $('#btnTambahJasaTF').on('click', function () {
        doSave();
    });
    $('#tambah_rekening').on('click', function () {
        doAddRek();
    });

    $("#search_norek").change(function () {
        let norek = $('#search_norek').val();
        $.ajax({
                type: 'PUT',
                url: '/rekening/getByNorek',
                data: {
                    "norek" : norek,
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'success'){
                        $("#norek").val(data.data.norek);
                        $("#nama").val(data.data.an);
                        $("#bank").val(data.data.bank);
                        $("#norek").prop('disabled' , true);
                        $("#nama").prop('disabled' , true);
                        $("#bank").prop('disabled' , true);
                        $("#total_tf").focus();
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        
    });

    $("#total_tf").keyup(function(){
        let total_tf = formatRupiah($("#total_tf").val());
        $("#total_tf").val(total_tf);
    });

    doRefreshTable();
});


    </script>

  </section>
@endsection
