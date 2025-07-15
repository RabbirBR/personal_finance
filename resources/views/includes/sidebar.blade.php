<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      {{-- @if(config('app.code_verified')) --}}
      <li class="header">MAIN NAVIGATION</li>
      
      <li><a href="{{ url('/') }}/"><i class="fa fa-th"></i> <span> Dashboard</span></a></li>
      <li><a href="{{ url('/accounting/accountHeads') }}"><i class="fa fa-list"></i> <span>Chart Of Accounts</span></a></li>
      <li><a href="{{ url('/accounting/transactions') }}"><i class="fa fa-exchange"></i> <span>Transactions</span></a></li>
      <li><a href="{{ url('/accounting/ledgers') }}"><i class="fa fa-book"></i> <span>Ledgers</span></a></li>
      <li><a href="{{ url('/accounting/reports') }}"><i class="fa fa-clipboard"></i> <span>Reports</span></a></li>
      {{-- @endif --}}

      @if(Auth::user()->role['admin'])
      <li class="header">ADMINISTRATION</li>
      
      {{-- @if(config('app.code_verified')) --}}
      <li><a  href="{{ url('/admin/companies') }}"><i class="fa fa-building"></i> <span>Companies</span></a></li>
      <li><a  href="{{ url('/admin/users') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a  href="{{ url('/admin/roles') }}"><i class="fa fa-users"></i> <span>User Roles</span></a></li>      
      <li><a  href="{{ url('/admin/currencies') }}"><i class="fa fa-money"></i> <span>Currencies</span></a></li>
      {{-- @endif --}}
      
      <li><a  href="{{ url('/admin/settings') }}"><i class="fa fa-cogs"></i> <span>Settings</span></a></li>
      <li class="header">ACTIVITY</li>
      <li><a  href="{{ url('/admin/activity') }}"><i class="fa fa-history"></i> <span>Activity Log</span></a></li>
      @endif
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>