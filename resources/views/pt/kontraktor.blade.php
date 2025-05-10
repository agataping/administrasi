@extends('template.mainmenu')
@section('title', '')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="card mb-3" style="background:  no-repeat center center/cover; border-radius: 12px; overflow: hidden; margin: 2rem auto; height: 80vh;">
    <div class="card-img-overlay d-flex align-items-center justify-content-center" style="background: color: white; text-align: center; ">
        <div class="card-body">

            <div class="col-12">

                <h2 class="mb-3"></h2>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div style="position: relative;" style="width: auto; height: auto; object-fit: cover;">

                    <div class="cardcostum">
                        <div class="cardcost">
                            <a href="/dashboard" class="cardcost text-decoration-none">

                                <h3 style="color:white;"><b>KONTRAKTOR</b></h3>
                                <div class="percentage-box" style="font-size: 2em; 
                                            @if ($totalResultIndukPerInduk <= 75)
                                                background-color: black; color: white;
                                            @elseif ($totalResultIndukPerInduk > 75 && $totalResultIndukPerInduk <= 90)
                                                background-color: rgb(206, 24, 24); color: white;
                                            @elseif ($totalResultIndukPerInduk > 90 && $totalResultIndukPerInduk <= 100)
                                                background-color: yellow; color: black;
                                            @elseif ($totalResultIndukPerInduk > 100 && $totalResultIndukPerInduk <= 190)
                                                background-color: green; color: white;
                                            @elseif ($totalResultIndukPerInduk > 190)
                                                background-color: blue; color: white;
                                            @endif
                                        ">
                                    <h3 style="color: white;">
                                        {{ number_format($totalResultIndukPerInduk, 2) }}%
                                    </h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    @if(auth()->user()->role === 'staff')
                    <div class="grid-container justify-content-center">
                        @foreach($data as $item)
                        <div class="grid-item">
                            <div class="cardcostum">
                                <div class="cardcost">
                                    @if ($item->id == auth()->user()->id_company)
                                    <a href="/reportkpi" class="cardcost text-decoration-none">
                                        @else
                                        <a class="cardcost text-decoration-none disabled-link">
                                            @endif
                                            <h4><b>{{ $loop->iteration }}. {{ $item->nama }}</b></h4>
                                            <div class="percentage-box" style="font-size: 2em; 
                                                @if ($datas[$item->id]['totalresultcompany'] <= 75)
                                                    background-color: black; color: white;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 75 && $datas[$item->id]['totalresultcompany'] <= 90)
                                                    background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 90 && $datas[$item->id]['totalresultcompany'] <= 100)
                                                    background-color: yellow; color: black;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 100 && $datas[$item->id]['totalresultcompany'] <= 190)
                                                    background-color: green; color: white;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 190)
                                                    background-color: blue; color: white;
                                                @endif
                                            ">
                                                {{ number_format($datas[$item->id]['totalresultcompany'], 2) }}%
                                            </div>
                                        </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                    @elseif(auth()->user()->role === 'admin')
                    <div class="grid-container  justify-content-center">

                        @foreach($data as $item)
                        <div class="grid-item">
                            <div class="cardcostum">
                                <div class="cardcost">
                                    @if($item->id == auth()->user()->id_company)
                                    <a href="/reportkpi" class="cardcost text-decoration-none">
                                        @else
                                        <a class="cardcost text-decoration-none disabled-link">
                                            @endif
                                            <h4><b>
                                                    <h4><b>{{ $loop->iteration }}. {{ $item->nama }}</b></h4>

                                                </b></h4>
                                            <div class="percentage-box" style="font-size: 2em; 
                                                @if ($datas[$item->id]['totalresultcompany'] <= 75)
                                                    background-color: black; color: white;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 75 && $datas[$item->id]['totalresultcompany'] <= 90)
                                                    background-color: rgb(206, 24, 24); color: white;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 90 && $datas[$item->id]['totalresultcompany'] <= 100)
                                                    background-color: yellow; color: black;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 100 && $datas[$item->id]['totalresultcompany'] <= 190)
                                                    background-color: green; color: white;
                                                @elseif ($datas[$item->id]['totalresultcompany'] > 190)
                                                    background-color: blue; color: white;
                                                @endif
                                            ">
                                                {{ number_format($datas[$item->id]['totalresultcompany'], 2) }}%
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif


            </div>
        </div>
    </div>
</div>







@endsection

@section('scripts')

@endsection