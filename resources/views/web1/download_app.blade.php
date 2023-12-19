@extends('web1.noheaderfooter') @section("title", "$title") @section("description", "Web1") @section("robots", "index, follow") @section('specific-page-css')

<!-- page lavel css -->
@section('specific-page-css')
<style>
    .content-area {
        background: #ffffff !important;
        min-height: 1080px;
    }
    .appname {
        font-size: 38px;
        font-weight: 700;
        color: #000000;
        font-style: normal;
    }

    .font1 {
        font-size: 17px;
        font-weight: 800;
    }
    .line1 {
        border-left: 2px solid #c6c0c0;
        height: 33px;
        position: absolute;
        left: 33%;
    }
    .line2 {
        border-left: 2px solid #c6c0c0;
        height: 33px;
        position: absolute;
        left: 66%;
    }
    .button1 {
        max-width: 206px;
        background-color: #01875f;
        border: none;
        color: white;
        padding: 9px;
        width: 100%;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        border-radius: 10px;
        font-style: normal;
        cursor: pointer;
    }
    .box1 {
        padding-top: 100px;
        padding-left: 100px;
        padding-right: 100px;
    }
    .box2 {
        padding-top: 80px;
        padding-left: 100px;
        padding-right: 100px;
    }
    .thumb {
        float: right;
        width: 240px;
        height: 240px;
        margin-right: 70px;
    }

    .screenshot {
        border-width: 0;
        box-shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.3), 0 1px 3px 1px rgba(60, 64, 67, 0.15);
        border-radius: 8px;
        cursor: pointer;
        height: 100%;
        max-width: 320px;
        margin: 0 auto;
    }
    .panel1 {
        display: block;
    }
    .panel2 {
        display: none;
    }
    .aboutus {
        font-size: 14px;
        font-weight: 500;
        color: #7e7e7e;
        font-style: normal;
        max-width: 70%;
    }

    @media only screen and (max-width: 600px) {
        .appname {
            font-size: 29px;
        }
        .box1 {
            padding-top: 10px;
            padding-left: 10px;
            padding-right: 10px;
        }
        .box2 {
            padding-top: 10px;
            padding-left: 10px;
            padding-right: 10px;
            text-align: center;
        }
        .thumb {
            width: 80px;
            height: 80px;
            margin-right: 30px;
        }

        .panel1 {
            display: none;
        }
        .panel2 {
            display: block;
        }
        .aboutus {
            padding: 10px;
            max-width: 100%;
        }
    }
</style>
@endsection @section('content')
<div class="row" style="padding: 20px;">
    <div class="col-6">
        <div style="font-size: 22px; font-weight: 500; color: #5f6368; font-style: normal;"><img src="{{asset('public/downloadapp/download.png?vr=1')}}" alt="" style="height: auto; width: 27px; padding: 0px;" /> Google Play</div>
    </div>

    <div class="col-6" style="text-align: right;">
        <div style="font-size: 21px; font-weight: 500; color: #5f6368; font-style: normal;">
            <i class="fas fa-search" style="margin-right: 20px;"></i><i class="far fa-question-circle" style="margin-right: 20px;"></i>
            <img
                style="width: 27px; height: 27px;"
                src="https://fonts.gstatic.com/s/i/productlogos/avatar_anonymous/v4/web-32dp/logo_avatar_anonymous_color_1x_web_32dp.png"
                class="VfPpkd-kBDsod WrEZCd"
                aria-hidden="true"
                srcset="
                    https://fonts.gstatic.com/s/i/productlogos/avatar_anonymous/v4/web-32dp/logo_avatar_anonymous_color_1x_web_32dp.png 1x,
                    https://fonts.gstatic.com/s/i/productlogos/avatar_anonymous/v4/web-32dp/logo_avatar_anonymous_color_1x_web_32dp.png 2x
                "
                data-atf="true"
                data-iml="883.5999999977648"
            />
        </div>
    </div>
</div>

<div class="row box1">
    <div class="col-7">
        <p class="appname">{{$title}}</p>
        <p style="font-size: 15px; font-weight: 600; color: #01875f; font-style: normal;">Bestsattamatka</p>

        <div class="panel1">
            <div class="row" style="padding: 20px;">
                <div class="col-4" style="text-align: left;">
                    <p style="font-size: 15px; font-weight: 600; color: #000000; font-style: normal;">4.4 <i class="fas fa-star"></i></p>
                    <p style="font-size: 12px; font-weight: 600; color: #7e7e7e; font-style: normal;">408 reviews</p>
                </div>

                <div class="col-4" style="text-align: left;">
                    <p style="font-size: 15px; font-weight: 600; color: #000000; font-style: normal;">10 K</p>
                    <p style="font-size: 12px; font-weight: 600; color: #7e7e7e; font-style: normal;">Downloads</p>
                </div>

                <div class="col-4" style="text-align: left;">
                    <img
                        src="https://play-lh.googleusercontent.com/EbEX3AN4FC4pu3lsElAHCiksluOVU8OgkgtWC43-wmm_aHVq2D65FmEM97bPexilUAvlAY5_4ARH8Tb3RxQ=w48-h16"
                        srcset="https://play-lh.googleusercontent.com/EbEX3AN4FC4pu3lsElAHCiksluOVU8OgkgtWC43-wmm_aHVq2D65FmEM97bPexilUAvlAY5_4ARH8Tb3RxQ=w96-h32 2x"
                        class="T75of xGa6dd"
                        alt="Content rating"
                        itemprop="image"
                        data-iml="318.30000000074506"
                        data-atf="true"
                    />
                    <p style="font-size: 12px; font-weight: 600; color: #7e7e7e; font-style: normal;">Rated for 3+</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <button class="button1" onclick="location.href='{{$downloadlink}}';">Install</button>
                </div>

                <div class="col-7" style="text-align: left;">
                    <p style="font-size: 15px; font-weight: 600; color: #01875f; font-style: normal; margin-top: 10px;">Add to wishlist</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-5" style="text-align: center;">
        <img src="{{asset('public/downloadapp/'.$thumicon)}}" alt="" class="thumb" />
    </div>
</div>

<div class="panel2">
    <div class="row" style="padding: 20px;">
        <div class="col-4" style="text-align: center;">
            <p style="font-size: 15px; font-weight: 600; color: #000000; font-style: normal;">4.4 <i class="fas fa-star"></i></p>
            <p style="font-size: 12px; font-weight: 600; color: #7e7e7e; font-style: normal;">408 reviews</p>
        </div>

        <div class="col-4" style="text-align: center;">
            <p style="font-size: 15px; font-weight: 600; color: #000000; font-style: normal;">10 K</p>
            <p style="font-size: 12px; font-weight: 600; color: #7e7e7e; font-style: normal;">Downloads</p>
        </div>

        <div class="col-4" style="text-align: center;">
            <img
                src="https://play-lh.googleusercontent.com/EbEX3AN4FC4pu3lsElAHCiksluOVU8OgkgtWC43-wmm_aHVq2D65FmEM97bPexilUAvlAY5_4ARH8Tb3RxQ=w48-h16"
                srcset="https://play-lh.googleusercontent.com/EbEX3AN4FC4pu3lsElAHCiksluOVU8OgkgtWC43-wmm_aHVq2D65FmEM97bPexilUAvlAY5_4ARH8Tb3RxQ=w96-h32 2x"
                class="T75of xGa6dd"
                alt="Content rating"
                itemprop="image"
                data-iml="318.30000000074506"
                data-atf="true"
            />
            <p style="font-size: 12px; font-weight: 600; color: #7e7e7e; font-style: normal;">Rated for 3+</p>
        </div>
    </div>
    <div class="row" style="padding: 20px;">
        <div class="col-12">
            <button class="button1" style="max-width: 100%;" onclick="location.href='{{$downloadlink}}';">Install</button>
        </div>

        <div class="col-12" style="text-align: center;">
            <p style="font-size: 15px; font-weight: 600; color: #01875f; font-style: normal; margin-top: 10px;">Add to wishlist</p>
        </div>
    </div>
</div>

<div class="box2">
    <img src="{{asset('public/downloadapp/'.$screen1)}}" alt="" class="screenshot" />
</div>
<div class="box2">
    <div style="font-size: 24px; font-weight: 500; color: #000000; font-style: normal;">About this app <i class="fas fa-arrow-right"></i></div>

    <p class="aboutus">
        {{$aboutus}}
    </p>
</div>

@endsection @section('specific-page-script') @endsection
