@extends('admin.blankcomonpart') 
@section("title", "Login") 
@section("description", "Description put here") 
@section("keyword", "Keword put here")

<!-- page lavel css -->
@section('specific-page-css')
<style type="text/css">
    
    .text1 {
    
    margin-top: 20px;
    margin-bottom: 15px;
    font-weight: 50;
    color: #bb0259;
    font-family: "Oswald", sans-serif;
    /* text-transform: uppercase; */
   }
   .text2 {
    
    margin-top: 0;
    margin-bottom: 15px;
    font-weight: 50;
    color: #bb0259;
    font-family: "Oswald", sans-serif;
    /* text-transform: uppercase; */
   }


   .button1 {
   background-image: linear-gradient(to right, #c0392b 0%, #c0392b  51%, #8e44ad  100%);

    color: #fff;

    -webkit-box-shadow: 0 .125rem .25rem 0 rgba(58,59,69,.2)!important;
    box-shadow: 0 .125rem .25rem 0 rgba(58,59,69,.2)!important;
    border-radius: 0.25rem;
    }
</style>

@endsection 
@section('content')

<div class="bg-gradient-login">
    <div class="container-login" style="min-height: 568px;">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-4 col-md-9">
                <div class="my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">

                                        <div style="text-align: center;">
                                        <img src="{{asset('public/assets/img/cmslogo.png')}}"  alt="logo" style="width: 100px; height: 100px;">
                                </div>

                                        <h1 class="text1">Admin Login</h1>
                                    </div>
                                    @if($errors->any())
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="alert alert-danger alert-dismissible show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>    
                                    @endif
                                    <form class="user" method="POST" action="{{ route('login-request') }}">
                                      @csrf
                                        <div class="form-group">
                                            <input type="text" placeholder="Email" id="email" class="form-control" name="email" required autofocus />
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="password" placeholder="Password" id="password" class="form-control" name="password" required />
                                            @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" />
                                                <label class="custom-control-label text2" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--     <a href="index.html" class="btn btn-primary btn-block">Login</a> -->
                                            <button type="submit" class="btn button1 btn-block">Signin</button>
                                        </div>
                                        <hr />
                                        
                                    </form>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- page lavel javascript -->
@section('specific-page-script')

@endsection
