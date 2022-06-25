<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> @yield('title')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

  @yield('style')
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <script src="{{ asset('js/jquery.min.js')}}"></script>
      <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
      <script>
          Pusher.logToConsole = true;
          var pusher = new Pusher('304e1526249863289cb1', {cluster: 'eu'});
          var channel = pusher.subscribe('store-channel');
            channel.bind('notifications', function(data) {
              setTimeout(function(){  
                  $( "#notifications" ).load(window.location.href + " #notifications" );
                }, 1000)
            });
      </script>
<style>
  .dropdown-item-desc, .dropdown-header{
    text-align: center;
  }
        input[type='text'], input[type='password'], h4, .invalid-feedback, select, option, .section-header, .select2, .select2-results__option, .card-header{
          text-align: center;
      }
      .card .card-header{
        display: block !important;
      }
        .section-header{
        display: block !important;
      }
      .alert.alert-success{
      background-color: #0d751e !important;
        text-align: center;
      }
</style>
@yield('afterStyle')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
      
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">
                      الاشعارات
              </div>
              <div class="dropdown-list-content dropdown-list-icons" id="notifications">
                @foreach ($notifications as $notification)
                    <a href="{{ $notification->url }}" class="dropdown-item">
                  <div class="dropdown-item-icon  text-white rounded-circle mr-1">
                        <img alt="image"  src="{{ asset( $notification->user->image) }}" width="50">
                </div>
                  <div class="dropdown-item-desc text-center">
                    <h6>{{ $notification->user->name }}</h6>
                    {{ $notification->title }}
                    <div class="time">{{ $notification->created_at }}</div>
                  </div>
                </a>
                @endforeach
                
              </div>
              <div class="dropdown-footer text-center">
                @canView('notifications','read')
                <a href="/notifications">أظهر الكل <i class="fas fa-chevron-right"></i></a>
                @endcanView
              </div>
            </div>
          </li>

          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user" >
            <span id="profile1">
            <img alt="image"  src="{{ asset(auth()->user()->image) }}" class="rounded-circle mr-1">
            </span>
            <div class="d-sm-none d-lg-inline-block"  id="profile3">{{ auth()->user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title"></div>
              @if ( auth()->user()->type == 'admin')
              <a href="/users/create" class="dropdown-item has-icon">
                <i class="fas fa-plus"></i> إنشاء حساب جديد 
              </a> 
              @endif
              <a href="/users/{{ auth()->user()->id }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> الحساب الشخصي
              </a>
              <div class="dropdown-divider"></div>
              <a href="/logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="/">Marine Company</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">Marine</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Data</li>
            @canView('items','read')
                <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>الأصناف</span></a>
              <ul class="dropdown-menu">
                @canView('items','write')
                <li class=active><a class="nav-link" href="/items/create">إضافة صنف</a></li>
                @endcanView
                <li><a class="nav-link" href="/items">تقرير الأصناف</a></li>
              </ul>
            </li>
            @endcanView
            @canView('suppliers','read')
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>الموردين</span></a>
              <ul class="dropdown-menu">
                @canView('suppliers','write')
                <li class=active><a class="nav-link" href="/suppliers/create">إضافة مورد</a></li>
                @endcanView
                <li><a class="nav-link" href="/suppliers">تقرير الموردين</a></li>
              </ul>
            </li>
            @endcanView
            <li class="menu-header">Operations</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>حركة المخزن</span></a>
              <ul class="dropdown-menu">
                @canView('in','write')
                <li><a class="nav-link" href="/in/create">اذن دخول صنف او اصناف</a></li>
                @endcanView
                @canView('out','write')
                <li><a class="nav-link" href="/out/create"> اذن خروج  صنف او اصناف</a></li>
                @endcanView
              </ul>
            </li>
            @canView('external','read')
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>صيانة خارجية</span></a>
              <ul class="dropdown-menu">
                @canView('external','write')
                <li><a class="nav-link" href="/externals/create">اذن صيانة خارجية </a></li>
                @endcanView
              </ul>
            </li>
            @endcanView
            <li class="menu-header">Reports</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Components</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="components-article.html">Article</a></li>                <li><a class="nav-link beep beep-sidebar" href="components-avatar.html">Avatar</a></li>                <li><a class="nav-link" href="components-chat-box.html">Chat Box</a></li>                <li><a class="nav-link beep beep-sidebar" href="components-empty-state.html">Empty State</a></li>                <li><a class="nav-link" href="components-gallery.html">Gallery</a></li>
                <li><a class="nav-link beep beep-sidebar" href="components-hero.html">Hero</a></li>                <li><a class="nav-link" href="components-multiple-upload.html">Multiple Upload</a></li>
                <li><a class="nav-link beep beep-sidebar" href="components-pricing.html">Pricing</a></li>                <li><a class="nav-link" href="components-statistic.html">Statistic</a></li>                <li><a class="nav-link" href="components-tab.html">Tab</a></li>
                <li><a class="nav-link" href="components-table.html">Table</a></li>
                <li><a class="nav-link" href="components-user.html">User</a></li>                <li><a class="nav-link beep beep-sidebar" href="components-wizard.html">Wizard</a></li>              </ul>
            </li>
          </ul>

           </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
      @yield('body')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
            &copy; IT DEPARTMENT  @php  echo date("Y"); @endphp 
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('js/popper.js')}}"></script>
  <script src="{{ asset('js/tooltip.js')}}"></script>
  <script src="{{ asset('js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('js/moment.min.js')}}"></script>
  <script src="{{ asset('js/stisla.js')}}"></script>
    
  <!-- Template JS File -->
  
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="{{ asset('/js/custom.js')}}"></script>
   <script>
  

  
  </script>
  @yield('script')
</body>
</html>