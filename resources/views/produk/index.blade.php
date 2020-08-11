@extends('template.master')
@section('title', 'Tambah Produk')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card py-3 px-3">
            <form action="/produk/insert" method="POST">
                @csrf
        <!-- Info boxes -->
                <div class="row">
                    <div class="col-sm-3">
                        <!-- select -->
                        <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" placeholder="Nama Produk" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <!-- select -->
                        <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="id_kategori">
                            <option selected disabled>--- Pilih Kategori ---</option>
                            @foreach ($kategori as $k)
                                <option value="{{$k->id}}">{{$k->id}} - {{$k->nama_kategori}}</option>
                            @endforeach

                        </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Distributor</label>
                            <input type="text" class="form-control" name="distributor" placeholder="URL atau Nama Distributor">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" class="form-control" name="stok" placeholder="Stok">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Harga Modal</label>
                            <input type="number" class="form-control" name="harga_modal" placeholder="Harga Modal">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" class="form-control" name="harga_jual" placeholder="Harga Jual">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Diskon</label>
                            <input type="number" class="form-control" name="diskon" placeholder="Diskon dalam %">
                        </div>
                    </div>
                    <div class="col-sm-3">
                            <div class="form-group">
                                <label>Status</label>
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
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" placeholder="Deskripsi Produk"></textarea>
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
            </form>
        </div>


        <div class="card py-3 px-3">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">List Produk</h2>
                </div>
            </div>

            <div class="col-sm-12">
                    <table id="example2" class="table table-bordered table-hover text-center" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Modal</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Distributor</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $p)
                        <tr>
                            <td>{{$p->id}}</td>
                            <td>{{$p->nama_produk}}</td>
                            <td>{{$p->id_kategori}}</td>
                            <td>{{$p->stok}}</td>
                            <td>{{$p->harga_modal}}</td>
                            <td>{{$p->harga_jual}}</td>
                            <td>{{$p->diskon}}</td>
                            <td>{{$p->distributor}}</td>
                            <td>{{$p->deskripsi}}</td>
                            <td>{{$p->status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
