@extends('template.master')
@section('title', 'Tambah Kategori Produk')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="/produk/insertkategori" method="POST">
            @csrf
      <!-- Info boxes -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- select -->
                                <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" name="nama_kategori" placeholder="Nama Kategori" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <!-- select -->
                                <div class="form-group">
                                <label>Status Kategori</label>
                                <select class="form-control" name="status">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card py-3 px-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="text-center">List Kategori</h2>
                            </div>

                            <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-hover text-center" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategori as $k)
                                        <tr>
                                        <td>{{$k->id}}</td>
                                        <td>{{$k->nama_kategori}}</td>
                                        </tr>
                                        @endforeach
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
        $(function () {
            $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
            });
            $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            });
        });
    </script>

  </section>
@endsection
