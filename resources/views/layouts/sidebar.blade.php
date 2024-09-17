<!-- Sidebar -->
<div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('home') }}" class="nav-link {{ request()->is('home*') ? 'active' : '' }}">
              
              <p>
                Dashboard
                <i class="right fas"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('barang') }}" class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
              
              <p>
                barang
                <i class="right fas"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('penjualan') }}" class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
              
              <p>
                penjualan
                <i class="right fas"></i>
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ url('prediksi') }}" class="nav-link {{ request()->is('prediksi*') ? 'active' : '' }}">
              
              <p>
                prediksi
                <i class="right fas"></i>
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->