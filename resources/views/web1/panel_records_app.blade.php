@extends('web1.noheaderfooter') @section("title", "Panel Record") @section("description", "Web1") @section("robots", "index, follow") @section('specific-page-css')

<!-- page lavel css -->
@section('specific-page-css')
<style>
   .box {
        border-style: dotted;
        border-color: #0000ff;
        background-color: #ffffff;
        color: #000000;
        text-align: center;
    }

    .tabel {
        overflow-x:auto;
        padding: 30px;
        margin: 0 auto;
        text-align: center;
        overflow-y: scroll;
        background: white;
        width: 650px;
        max-width: 650px;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }
    th {
        font-weight: 700;
        padding: 5px;
    }

    td {
        font-weight: 700;
        padding: 5px;
    }

    .font1 {
        color: #ff0000;
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 15px;
        font-weight: 900;
        font-style: italic;
    }
    .font2 {
        font-weight: 500;
        line-height: 1.1;
        padding: 20px;
        font-size: 20px;
        font-style: italic;
    }
    
</style>
@endsection @section('content')

<div class="box">
    <p class="font1">{{$gamename}}</p>
    <p class="font2">Sattamatka</p>

    <table class="tabel" border="1" class="table-responsive">
            <tbody>
                <tr>
                    <th>DATE</th>
            @foreach($lottery_week_day as $item)

            <th> {{$item}}</th>

            @endforeach
                    
                </tr>
                @foreach($panel_record_list as $item)
                <tr>
                    <td>
                        {{ $item['range1']}}<br />
                        to <br />
                        {{ $item['range2']}}
                    </td>
                    @foreach($item['panel'] as $data)
                    <td>
                        <table width="30" align="center">
                            <tbody>
                                <tr>
                                    @if(in_array($data['jodi'], $rednumber))

                                       

                                        <td width="5" style="color: red;">
                                            {{ str_split($data['open_pana'])[0] }} {{ str_split($data['open_pana'])[1] }} {{ str_split($data['open_pana'])[2] }}
                                        </td>

                                        <td width="5" style="color: red;">
                                            {{$data['jodi']}}

                                        </td>
                                        <td width="5" style="color: red;">
                                           {{ str_split($data['close_pana'])[0] }} {{ str_split($data['close_pana'])[1] }} {{ str_split($data['close_pana'])[2] }}
                                        </td> 

                                    @else

                                        <td width="5" style="color: black;">
                                            {{ str_split($data['open_pana'])[0] }} {{ str_split($data['open_pana'])[1] }} {{ str_split($data['open_pana'])[2] }}
                                        </td>

                                        <td width="5" style="color: black;">
                                            {{$data['jodi']}}
                                        </td>
                                        <td width="5" style="color: black;">
                                            {{ str_split($data['close_pana'])[0] }} {{ str_split($data['close_pana'])[1] }} {{ str_split($data['close_pana'])[2] }}
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

@endsection @section('specific-page-script') @endsection
