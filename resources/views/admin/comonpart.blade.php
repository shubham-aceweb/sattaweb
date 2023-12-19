<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('admin.include.head')
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    @include('admin.include.sidebar')
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content" >

        <div style="min-height: 800px;">
          
          <!-- TopBar -->
          @include('admin.include.topbar')
          <!-- Topbar -->
          @include('admin.include.notification')
          <!-- Container Fluid-->
          @yield('content')
          <!---Container Fluid-->
        </div>

        
      </div>
      <!-- Footer -->
      @include('admin.include.footer')
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  @include('admin.include.script')  
  @include('admin.include.logoutModal')
</body>

</html>