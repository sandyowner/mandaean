<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{url('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{url('assets/images/favicon.ico')}}" />

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  </head>
  <body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-scroller">
      <div class="row p-0 m-0 proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-between">
              <a href="#"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="{{url('dashboard')}}">Mandaean<img src="https://mandaean.org.au/wp-content/uploads/2021/07/Mandean-Darfesh-Home-Page.png" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="{{url('dashboard')}}"><img src="https://mandaean.org.au/wp-content/uploads/2021/07/Mandean-Darfesh-Home-Page.png" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-calendar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                    <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                    <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-link-variant"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                    <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <h6 class="p-3 mb-0 text-center">See all notifications</h6>
              </div>
            </li>

            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="{{url('uploads/admin.png')}}" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">@yield('sort_name')</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <!-- <a class="dropdown-item" href="#">
                  <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('logout')}}">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="{{url('uploads/admin.png')}}" alt="profile">
                  <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">@yield('sort_name')</span>
                  <span class="text-secondary text-small">Admin</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='dashboard')?'active':'' }}">
              <a class="nav-link" href="{{url('dashboard')}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='users')?'active':'' }}">
              <a class="nav-link" href="{{url('users')}}">
                <span class="menu-title">User Management</span>
                <i class="mdi mdi-account-group menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='mandanism')?'active':'' }}">
              <a class="nav-link" href="{{url('mandanism')}}">
                <span class="menu-title">Mandanism Management</span>
                <i class="mdi mdi-information menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='ritual')?'active':'' }}">
              <a class="nav-link" href="{{url('ritual')}}">
                <span class="menu-title">Ritual Management</span>
                <i class="mdi mdi-information menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='news')?'active':'' }}">
              <a class="nav-link" href="{{url('news')}}">
                <span class="menu-title">Latest News Management</span>
                <i class="mdi mdi-information menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='prayer')?'active':'' }}">
              <a class="nav-link" href="{{url('prayer')}}">
                <span class="menu-title">Prayer Management</span>
                <i class="mdi mdi-information menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='books')?'active':'' }}">
              <a class="nav-link" href="{{url('books')}}">
                <span class="menu-title">Holy Books Management</span>
                <i class="mdi mdi-book-multiple menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='feedback')?'active':'' }}">
              <a class="nav-link" href="{{url('feedback')}}">
                <span class="menu-title">User Feedback Management</span>
                <i class="mdi mdi-message-alert menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='advertisement')?'active':'' }}">
              <a class="nav-link" href="{{url('advertisement')}}">
                <span class="menu-title">Advertisement Inquiry Management</span>
                <i class="mdi mdi-users menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='product')?'active':'' }}">
              <a class="nav-link" href="{{url('product')}}">
                <span class="menu-title">Product Inventory Management</span>
                <i class="mdi mdi-users menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='calender')?'active':'' }}">
              <a class="nav-link" href="{{url('calender')}}">
                <span class="menu-title">Calender Management</span>
                <i class="mdi mdi-users menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='order')?'active':'' }}">
              <a class="nav-link" href="{{url('order')}}">
                <span class="menu-title">Order Management</span>
                <i class="mdi mdi-users menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='payment')?'active':'' }}">
              <a class="nav-link" href="{{url('payment')}}">
                <span class="menu-title">Donation/Payment Transaction Management</span>
                <i class="mdi mdi-users menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='referral')?'active':'' }}">
              <a class="nav-link" href="{{url('referral')}}">
                <span class="menu-title">Referral Management</span>
                <i class="mdi mdi-users menu-icon"></i>
              </a>
            </li>
            <li class="nav-item {{ (\Request::segment(1)=='notification')?'active':'' }}">
              <a class="nav-link" href="{{url('notification')}}">
                <span class="menu-title">Notification Management</span>
                <i class="mdi mdi-users menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <div class="main-panel">
          @yield('content')
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">2023 © Copyright Mandaean Association of Australia. All rights reserved.</span>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <script src="{{url('assets/js/jquery.min.js')}}"></script>
    <script src="{{url('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{url('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{url('assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{url('assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/off-canvas.js')}}"></script>
    <script src="{{url('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{url('assets/js/misc.js')}}"></script>
    <script src="{{url('assets/js/dashboard.js')}}"></script>
    <script src="{{url('assets/js/todolist.js')}}"></script>
    <script src="{{url('assets/js/file-upload.js')}}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    @yield('scripts')
  </body>
</html>