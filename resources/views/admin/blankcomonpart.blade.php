<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('admin.include.head')
    </head>
    <body id="page-top">
    	
        @yield('content')
        @include('admin.include.script')
     	
    </body>
</html>
