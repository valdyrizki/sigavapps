<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset("assets/dist/img/AdminLTELogo.png")}}" alt="SIGAV Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SIGAV APPS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset("assets/dist/img/user2-160x160.jpg")}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <p class="d-block">{{auth()->user()->name}}</p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            @foreach (generateMenu() as $m)
                @if ($m['child'] != 0)
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon {{$m['icon']}}"></i>
                      <p>{{$m['name']}}
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($m['child'] as $c)
                        <li class="nav-item">
                            <a href="{{$c->url}}" class="nav-link">
                                <i class="far fa-product nav-icon"></i>
                                <p>{{$c->name}}</p>
                            </a>
                        </li>
                      @endforeach
                    </ul>
                  </li>
                @else
                    <li class="nav-item">
                        <a href="{{$m['url']}}" class="nav-link">
                        <i class="nav-icon {{$m['icon']}}"></i>
                            <p>{{$m['name']}}</p>
                        </a>
                    </li>
                @endif
            @endforeach
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
