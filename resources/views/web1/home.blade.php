@extends('web1.addheaderfooter') @section("title", "Sattamatka") @section("description", "Sattamatka") @section("robots", "index, follow") @section('specific-page-css')

<link rel="stylesheet" href="{{asset('public/css/home.css?version=456')}}" rel="stylesheet" type="text/css" />


@endsection @section('content')

<div>
    <div class="bg1">
        <h1 class="font1">Satttamatka Kalyan Mumbai Fastest Results</h1>

        <br />
        <h2 class="font2">
            <p>
                Get Kalyan Matka Main Mumbai sattta Matka Market Results Fastest Live Update. Get all satta matka fast result. Get All Kalyan,Main Mumbai,Sridevi,Supreme, Rajdhani,Milan,Madhur Matka And Time Bazar Jodi Penal Panel Patti
                Panna Charts For Free . All Matka Guessing.With Best Guessers , Online Old Charts , sattta Matka Number Software Links, Online Charts List Pdf Download And Top Matka Guessing Free Number Provided By satttamatka Professor And
                Master Dr Admin Sir.
            </p>

            <p>
                Other Special Features Include 220 Patti sattta Weekly Matka Jodi Chart With Direct Access To Guessing Form Of Experts Tricks Access Via Website Or Android App. Play matka online for fast result.
            </p>
        </h2>
        <br />
        
                
               <!--    <button class="button1"  onclick="location.href='https://clubsattamatka.com/download-app/com.bestsattamatka.ndrgames';" >
                    DOWNLOAD Ndr Games APP
                </button> -->

                 <button class="button1"  onclick="location.href='https://clubsattamatka.com/download-app/com.bestsattamatka.gsboss';" >
                   DOWNLOAD GS BOSS APP
                </button>

              <!--  <button class="button1"  onclick="location.href='https://clubsattamatka.com/download-app/com.bestsattamatka.famousonline';" >
                   DOWNLOAD FAMOUS ONLINE APP
                </button> -->

               <button class="button1"  onclick="location.href='https://clubsattamatka.com/download-app/com.bestsattamatka.dhanigames';" >
                   DOWNLOAD DHANI GAMES APP
                </button>

                 
        <!-- <div class="row">
            <div class="col-12 col-sm-12  col-md-12 col-lg-4">
               
                <button class="button1"  onclick="location.href='https://www.bestsattamatka.net/public/apk/app.apk';" >
                    DOWNLOAD BESTSATTAMATKA APP
                </button>
            </div>
           
            <div class="col-12 col-sm-12  col-md-12 col-lg-4">
                
                <button class="button1" onclick="location.href='https://www.bestsattamatka.net/public/apk/saionline.apk';" >
                    DOWNLOAD SAIONLINE PLAY APP
                </button>
            </div> 
        </div>  -->
        <br />
    </div>
</div>

<div class="marquee-box">
    <marquee><b> T0 add market contact 8296502700 </b></marquee>
</div>

<div class="live-update-box">
    <h3 class="font3 blink_me">
        <span>
            <i class="fas fa-circle point"></i>
        </span>
        LIVE UPDATE <span> <i class="fas fa-circle point"></i></span>
    </h3>
</div>
<div class="marquee-box"></div>

<div>

    @foreach($live_result as $item)

     <div class="live-game-box">
        <p class="live-game-box-text1">{{ $item['market_name']}}</p>
        
        <p class="live-game-box-text2">{{ $item['result']}}</p>
    
        <button type="submit" class="btn btn-danger btn-sm btn-refresh" style="background: #2c2841 !important; border: 0px; line-height: 1.1;" onclick="window.location.reload()">Refresh</button>
     </div>
    @endforeach
    


   
</div>

<div class="bg2">
    <p class="bg2-text1">mainmumbai.com</p>
    <p class="bg2-text1">sattamatka.com</p>
    <p class="bg2-text1">bestsattamatka.com</p>
    <p class="bg2-text1">bestsattamatka.net</p>
    <p class="bg2-text1">GUESSING</p>
    <p class="bg2-text1">RESULT SITE</p>
    <p class="bg2-text1">!! PROFESSOR !!</p>
    <p class="bg2-text1">!!ADMIN SIR!!</p>
    <p class="bg2-text1">***</p>
</div> 

<div class="live-result-box">
    <h3 class="font3 blink_me">
        !! MATKA RESULTS LIVE !!
    </h3>
</div>

<div>
@if(isset($old_new_record))
   @foreach($old_new_record as $item)
    <div class="result-live-box">
      <h4 class="result-live-box-text1">{{$item['lottery_name']}}</h4>
      <div style="margin-left: 10px;">
            <a class="button2" style="float: left;" href="{{url('/jodi-records/'.$item['slug'])}}"><strong>Jodi</strong></a>
        </div>
        <div style="margin-right: 10px;">
            <a class="button2" style="float: right;color" href="{{url('/panel-records/'.$item['slug'])}}"><strong>Panel</strong></a>
        </div>

        <p class="result-live-box-text2">{{$item['open_pana']}}-{{$item['jodi']}}-{{$item['close_pana']}}</p>
        <p class="result-live-box-text3">{{$item['open_time']}} &emsp;&emsp;{{$item['close_time']}}</p>
        
    </div>
     
    @endforeach

  @endif

     
   

</div>

<div class="lucky-number-box-1">
    <h3 class="font3">
        !! TODAY LUCKY NUMBER !!
    </h3>
</div>

<div>
    @foreach($today_lucky_number as $item)
    <div class="lucky-number-box-2">
        <h4 class="lucky-number-box-3">{{$item->lottery_name}}</h4>
        <div style="margin-left: 10px;">
            <p  style="float: left; color : green; font-size: 20px; font-weight: 800;"  ><strong>{{$item->open_time}}</strong></p>
        </div>
        <div style="margin-right: 10px;">
            <p  style="float: right;color : green; font-size: 20px; font-weight: 800;" ><strong>{{$item->close_time}}</strong></p>
        </div>

        @if($item->lucky_number_otc =='NA')
            <p class="lucky-number-box-4"> OTC: - <strong></strong></p>
        @else
            <p class="lucky-number-box-4"> OTC: - <strong>{{$item->lucky_number_otc}}</strong></p>
        @endif

        @if($item->lucky_number_jodi =='NA')
            <p class="lucky-number-box-4"> Jodi: - <strong></strong></p>
        @else
            <p class="lucky-number-box-4"> Jodi: - <strong>{{$item->lucky_number_jodi}}</strong></p>
        @endif

        @if($item->lucky_number_patti =='NA')
            <p class="lucky-number-box-4"> Patti: - <strong></strong></p>
        @else
            <p class="lucky-number-box-4"> Patti: - <strong>{{$item->lucky_number_patti}}</strong></p>
        @endif

        @if($item->lucky_number_passing =='NA')
            <p class="lucky-number-box-4"> Passing: - <strong></strong></p>
        @else
            <p class="lucky-number-box-4"> Passing: - <strong>{{$item->lucky_number_passing}}</strong></p>
        @endif
       
      
    </div>
    @endforeach
</div>

<div class="online-matka-play">
    <h1 class="online-matka-play-text1">
        Online Matka Play<br />
        Play Matka Online For Fast Result
    </h1>
</div>

<div class="bg3">
    <div>
        <h1 class="online-matka-play-text2">Time Table</h1>
    </div>
    <table class="table">
        <tbody>
            <tr>
                <th>MARKET</th>
                <th>OPEN</th>
                <th>CLOSE</th>
            </tr>

            @foreach($lottery_market as $item)

            <tr>
                <td>{{$item->lottery_name}}</td>
                <td>{{$item->open_time}}</td>
                <td>{{$item->close_time}}</td>
            </tr>
       
            @endforeach


            
            
        </tbody>
    </table>
</div>

@endsection @section('specific-page-script') @endsection
