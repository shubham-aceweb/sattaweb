<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('web1.include.head')
    </head>
    <body class="container-fluid" style="padding: 0 ; margin: 0 ;margin-right: auto; margin-left: auto; max-width: 1600px;">
        
        <div class="content-area">
           
            @yield('content')
        </div>
       
        @include('web1.include.script')
        
    </body>
</html>
