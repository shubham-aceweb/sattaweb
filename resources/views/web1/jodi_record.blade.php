@extends('web1.addheaderfooter') @section("title", "Jodi Record") @section("description", "Web1") @section("robots", "index, follow") @section('specific-page-css')

<!-- page lavel css -->
@section('specific-page-css')

<style>

    .market-name {
            max-width: 300px;
            border-radius: 25px;
            box-shadow: 0 0 2px #461300;
            background-color: #3c9705;
            margin: 20px auto;
            color: #ffffff;
            text-align: center;
            border: #FFB80C solid 2px;
            font-size: 15px;
            font-weight: 900;
            padding: 5px;
    }

   .box {
        border-style: dotted;
        border-color: #0000ff;
        background-color: #ffffff;
        color: #000000;
        text-align: center;
    }

    .tabel {
        
        margin: 20px auto;
        text-align: center;
        overflow-y: scroll;
        background: white;
        width: 320px;
        max-width: 650px;
        text-align: center;
    }

    

    table {
        border-collapse: collapse;
        width: 100%;
    }
    th {
        text-align: center;
        padding: 0px;
    }

    td {
        
        padding: 1px;
    }

    .date-font
    {
        font-size: 14px;
        font-weight: 400;
    }

    .pana-font
    {
        font-size: 14px;
        font-weight: 400;
    }
    .jodi-font
    {
        
        font-size: 18px;
        font-weight: 700;
    }

    

    @media (min-width: 320px) and (max-width: 479px) {
    .date-font
        {
            font-size: 10px;
            font-weight: 400;
        }

        .pana-font
        {
            font-size: 10px;
            font-weight: 400;
        }
        .jodi-font
        {
            
            font-size: 14px;
            font-weight: 700;
        }
        th {
        padding: 0px;
        }

        td {
            
            padding: 0px;
        }
    }

    
</style>
@endsection @section('content')

<div class="box">
    <p class="market-name">{{$gamename}}</p>
    <p style="margin: 10px;">Sattamatka</p>


   <div style="overflow-x:auto; padding: 10px;">
        <table class="tabel" border="1" cellpadding="2">
            <tbody>
                <tr>
                   
            @foreach($lottery_week_day as $item)

            <th> {{$item}}</th>

            @endforeach
                    
                </tr>
                @foreach($panel_record_list as $item)
                <tr>
                   
                    @foreach($item['panel'] as $data)
                    <td>
                        <table width="30" align="center">
                            <tbody>
                                <tr>
                                    @if(in_array($data['jodi'], $rednumber))

                                       

                                       

                                        <td width="5" style="color: red;" class="jodi-font">
                                            {{$data['jodi']}}

                                        </td>
                                       

                                    @else

                                        

                                        <td width="5" style="color: black;" class="jodi-font">
                                            {{$data['jodi']}}
                                        </td>
                                        

                                    @endif

                                    
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    @endforeach
                </tr>

                @endforeach
            </tbody>
        </table>
   </div>
   
</div>

@endsection @section('specific-page-script') @endsection
