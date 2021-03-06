<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Avatar::create($AGENT['name'])->toBase64() }}" class="img-circle"/>
        </div>
        <div class="pull-left info">
          <p>{{ $AGENT['name'] }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HR/GA</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="{{ url('inventory') }}"><i class="fa fa-archive"></i> <span>Inventory</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-th-list" aria-hidden="true"></i> <span>Purchase Order</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('po') }}">Purchase Order</a></li>
            <li><a href="{{ url('po/create') }}">Create Purchase Order</a></li>
            <li><a href="{{ url('po/vendor') }}">Vendor</a></li>
            <li><a href="{{ url('po/vendor/create') }}">Add Vendor</a></li>
          </ul>
        </li>
        @if(in_array($AGENT['role'], array(7)))
        <li class="treeview">
          <a href="#"><i class="fa fa-address-card" aria-hidden="true"></i> <span>Sales</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('sales/revenue') }}">Sales Revenue</a></li>
            <li><a href="{{ url('sales/revenue/create') }}">Create Sales Revenue</a></li>
            <li><a href="{{ url('sales/client-status') }}">Client Status</a></li>
            <li><a href="{{ url('sales/client-status/create') }}">Add Client</a></li>
          </ul>
        </li>
        @endif
        <li class="treeview">
          <a href="#"><i class="fa fa-table" aria-hidden="true"></i> <span>Report</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('report/stock') }}">Stock</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-database" aria-hidden="true"></i> <span>Database</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('airlines') }}">Airlines</a></li>
            <li><a href="{{ url('airlines/create') }}">Add Airlines</a></li>
          </ul>
        </li>
        <!-- <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li> -->
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>