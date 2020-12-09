@extends('template.master')
@section('title', 'User')

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
                            <input type="hidden" id="idUser" name="idUser" />
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Nama User</label>
                                <input type="text" class="form-control" name="name" id="name" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" id="email" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="0" disabled selected>--- Pilih Role User ---</option>
                                        <option value="1">Kasir</option>
                                        <option value="2">Admin</option>
                                        <option value="99">Super User</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4" id='c_password_old'>
                                <div class="form-group">
                                <label>Password Old</label>
                                <input type="password" class="form-control" name="password_old" id="password_old" >
                                <div class="invalid-tooltip">
                                    Katasandi lama tidak sesuai.
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-control " name="password" id="password" >
                                    <div class="invalid-tooltip">
                                        Katasandi tidak sesuai.
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4" id='c_password_confirmation'>
                                <div class="form-group">
                                    <label>Password Confirmation</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" >
                                    <div class="invalid-tooltip">
                                        Katasandi tidak sesuai.
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="form-control btn btn-primary" id="save">Simpan</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="form-control btn btn-danger" id="reset">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card py-3 px-3">
                        <div class="col-sm-12">
                            <table id="tablePengeluaran" class="table table-bordered table-hover text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($users as $u)
                                    <tr>
                                        <td>{{$u->id}}</td>
                                        <td>{{$u->name}}</td>
                                        <td>{{$u->email}}</td>
                                        <td>{{getRole($u->level)}}</td>
                                    </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
            // $('#c_password_confirmation').hide();
        $('#c_password_old').hide();

        function passwordConfirmation(){
            if ($('#password').val() != $('#password_confirmation').val()) {
                $('#password_confirmation').removeClass('is-valid');
                $('#password_confirmation').addClass('is-invalid');
                $('#password').removeClass('is-valid');
                $('#password').addClass('is-invalid');
                isPasswordValid = false;
            } else{
                if($('#password').val().length > 7 && $('#password_confirmation').val().length > 7){
                    $('#password_confirmation').removeClass('is-invalid');
                    $('#password_confirmation').addClass('is-valid');
                    $('#password').removeClass('is-invalid');
                    $('#password').addClass('is-valid');
                    isPasswordValid = true;
                }
            }
        }

        function doReset(){
            $('#c_password_old').hide();
            isUpdate = false;
            isPasswordValid = false;
            isPasswordOldValid = false;
            $('#save').html('Simpan');

            $('#name').val('');
            $('#email').val('');
            $('#role').val(0);
            $('#password_old').val('');
            $('#password').val('');
            $('#password_confirmation').val('');
            $('idUser').val(0);

            $('#password').removeClass('is-invalid');
            $('#password').removeClass('is-valid');
            $('#password_confirmation').removeClass('is-invalid');
            $('#password_confirmation').removeClass('is-valid');
            $('#password_old').removeClass('is-invalid');
            $('#password_old').removeClass('is-valid');

            doRefreshTable();
        }

        function doSave(){
            $.ajax({
                type: 'POST',
                url: '/user/insert',
                data: {
                    "name" : $('#name').val(),
                    "email" : $('#email').val(),
                    "level" : $('#role').val(),
                    "password" : $('#password').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal input User'
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
                        doReset();
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }

        function doUpdate(){
            $.ajax({
                type: 'POST',
                url: '/user/update',
                data: {
                    "id" : $('#idUser').val(),
                    "name" : $('#name').val(),
                    "email" : $('#email').val(),
                    "level" : $('#role').val(),
                    "password" : $('#password').val()
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal update User'
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
                        doReset();
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
        }

        function getRole(expression){
            let result = 'Kasir';
            switch (expression){
                case 1:
                result = 'Kasir';
                break;
                case 2:
                result = 'Admin';
                break;
                case 99:
                result = "Super Admin";
                break;
                default:
                result = "Kasir";
            }
            return result;
        }

        function doRefreshTable(){
            let dttable = $('#tablePengeluaran').DataTable();
            dttable.clear().draw();
            $.getJSON("/user/getuser", function(json){
                $.each(json, function(i, obj){
                    dttable.row.add( [
                        obj.id,
                        obj.name,
                        obj.email,
                        getRole(obj.level)
                    ] ).draw( false );
                });
            });
        }

$(document).ready(function() {
    let dttable = $('#tablePengeluaran').DataTable({
        "paging": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "order": [[ 0, "desc" ]]
    });

    doRefreshTable();
    isUpdate = false;
    isPasswordValid = false;
    isPasswordOldValid = false;

    $('#password_confirmation').on('keyup', function () {
        passwordConfirmation();
    });

    $('#password').on('keyup', function () {
        passwordConfirmation();
    });

    $('#tablePengeluaran tbody').on('dblclick', 'tr', function () {
        $('#c_password_old').show();
        isUpdate = true;
        $('#save').html('Update');

        var data = dttable.row( this ).data();
        $('#idUser').val(data[0]);

        //retrieve data to column
        $.getJSON("/user/getbyid/"+data[0], function(json){
            $('#name').val(json.name);
            $('#email').val(json.email);
            $('#role').val(json.level);
        });
    } );

    $('#reset').on('click', function () {
        doReset();
    });

    $( "#password_old" ).change(function() {
        $.ajax({
                type: 'POST',
                url: '/user/checkpass',
                data: {
                    "id" : $('#idUser').val(),
                    "password" : $('#password_old').val(),
                }, // or JSON.stringify ({name: 'jonas'}),
                success: function(data) {
                    if(data.status == 'error'){
                        isPasswordOldValid = false;
                        $('#password_old').removeClass('is-valid');
                        $('#password_old').addClass('is-invalid');
                    }else{
                        isPasswordOldValid = true;
                        $('#password_old').removeClass('is-invalid');
                        $('#password_old').addClass('is-valid');
                    }
                },
                // contentType: "application/json",
                dataType: 'JSON'
            });
    });

    $('#save').on( 'click', function () {
        if(isUpdate){ //update
            if(isPasswordValid && isPasswordOldValid){
                Swal.fire({
                    title: 'Apakah kamu yakin ?',
                    text: "Apakah kamu yakin mengubah data User ini ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update data !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        doUpdate();
                    }
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Password tidak sesuai'
                });
            }
        }else{ //save
            if(isPasswordValid){
                Swal.fire({
                title: 'Apakah kamu yakin ?',
                text: "Apakah kamu yakin menyimpan data User ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan data !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        doSave();
                    }
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Password tidak sesuai'
                });
            }

        }
    });

} );


    </script>

  </section>
@endsection
