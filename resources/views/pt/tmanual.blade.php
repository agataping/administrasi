@extends('template.main')
@section('title', '')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style=" background-color:rgba(134, 247, 138, 0.98); ">
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
                
                <h2 class="text-center">
                    <strong>TOTAL PERFORMANCE (YEAR TO DATE)</strong>
                </h2>
                <p class="text-center">
                    <strong> LEVEL: JTN SITE </strong>
                </p>
                
                <div class="container mt-2" >
                    <div class="card"  style="border: 4px solid black; border-radius: 5px;">
                        <div class="card-body">
                            <div class="row" style="background-color: #f4e2cd; vertical-align: middle;">
                                <div class="col" style="text-align-end">
                                    <h2 class="mb-3">TOTAL PERFORMANCE (YEAR TO DATE)</h2>
                                </div>
                                <div class="col text-end">
                                    WEIGHT: 15%
                                </div>
                            </div>
                            <div class="row" style="border: 1px solid black; ">
                                <div class="col" style="text-align-end" style="background-color: #f4e2cd; font-size: 2em; text- font-weight: bold;"> 
                                </div>
                                <div class="col text-start">
                                    LEVEL: JTN SITE                   
                                </div>
                            </div>
                            <h5 class="text-right" style="color: #000;"></h5>
                            <div class="row" style="border: 1px solid black;">
                                <div class="col" style="text-align-end">
                                    FINANCIAL PERSPECTIVE
                                </div>
                                <div class="col text-end">
                                    WEIGHT: 15%
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 d-flex justify-content-center align-items-center" style="background-color: #f4e2cd; font-size: 2em; text- font-weight: bold;">
                                    <!-- 59% -->
                                </div>
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 16rem;" > 
                                            <thead style="background-color:rgb(107, 255, 149);">
                                                <tr>
                                                    <th colspan="3" style="text-align: center; vertical-align: middle;">Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="text-align: start; vertical-align: middle;"> Plan</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: start; vertical-align: middle;">actual</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: start; vertical-align: middle;">index</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: start; vertical-align: middle;">weight</td>
                                                    <td class="text-end" style="background-color:rgb(18, 17, 17); vertical-align: middle; color: white;">75%
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 16rem;"> 
                                                <thead style="background-color:rgb(107, 255, 149);">
                                                    <tr>
                                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Gross Profit (GP) Margin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Plan</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Actual</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Index</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: ; vertical-align: middle;">Weight</td>
                                                        <td class="text-end" style="background-color:rgb(206, 24, 24); vertical-align: middle; color: white;">90%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                                    <div class="card-body">
                                        <div class="row" style="border: 1px solid black;">
                                            <div class="col" style="text-align-end">
                                                CUSTOMER PERSPECTIVE
                                            </div>
                                            <div class="col text-end">
                                                WEIGHT: 15%
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2 d-flex justify-content-center align-items-center" style="background-color: #f4e2cd; font-size: 2em; text- font-weight: bold;">
                                                59%
                                            </div>
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <!-- Coal Mine (MT) -->
                                                    <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;" class="table table-bordered">
                                                        <thead style="background-color:rgb(107, 255, 149);">
                                                            <tr>
                                                                <th colspan="3" style="text-align: center; vertical-align: middle;">Coal Mine (MT)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Plan</td>
                                                                <td>35.376</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Actual</td>
                                                                <td>17.479</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Index</td>
                                                                <td>49,4%</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Weight</td>
                                                                <td class="text-end" style="background-color:rgb(246, 255, 0); vertical-align: middle; color: white;">90,1%</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <!-- Overburden Removal (BCM) -->
                                                    <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;" class="table table-bordered">
                                                        <thead style="background-color:rgb(107, 255, 149);">
                                                            <tr>
                                                                <th colspan="3" style="text-align: center; vertical-align: middle;" class="small">Overburden Removal (BCM)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Plan</td>
                                                                <td>245.306</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Actual</td>
                                                                <td>165.645</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Index</td>
                                                                <td>67,5%</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Weight</td>
                                                                <td class="text-end" style="background-color:rgb(0, 255, 17); vertical-align: middle; color: white;">100%</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row" style="border: 1px solid black;">
                                                    <div class="col" style="text-align">
                                                        INTERNAL PROCESS PERSPECTIVE
                                                    </div>
                                                    <div class="col text-end">
                                                        WEIGHT: 30%
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-2 d-flex justify-content-center align-items-center" style="background-color: #f4e2cd; font-size: 2em; text- font-weight: bold;">
                                                        71,8%
                                                    </div>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <!-- Fleet Productivity (Coal) -->
                                                            <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;" class="table table-bordered">
                                                                <thead style="background-color:rgb(107, 255, 149);">
                                                                    <tr>
                                                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Fleet Productivity (Coal)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Plan</td>
                                                                        <td>22.176</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Actual</td>
                                                                        <td>10.095</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Index</td>
                                                                        <td>45,5%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Weight</td>
                                                                        <td class="text-end">3,00%</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <!-- Fleet Productivity (OB) -->
                                                            <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;" class="table table-bordered">
                                                                <thead style="background-color:rgb(107, 255, 149);">
                                                                    <tr>
                                                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Fleet Productivity (OB)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Plan</td>
                                                                        <td>113.010</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Actual</td>
                                                                        <td>55.221</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Index</td>
                                                                        <td>48,9%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Weight</td>
                                                                        <td class="text-end">3,00%</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row" style="border: 1px solid black;">
                                                            <div class="col" style="text-align-end">
                                                                LEARNING & GROWTH PERSPECTIVE
                                                            </div>
                                                            <div class="col text-end">
                                                                WEIGHT: 20%
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-2 d-flex justify-content-center align-items-center" style="background-color: #f4e2cd; font-size: 2em; text- font-weight: bold;">
                                                                75%
                                                            </div>
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <!-- People Readiness -->
                                                                    <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                                                        <thead style="background-color:rgb(107, 255, 149);">
                                                                            <tr>
                                                                                <th colspan="3" style="text-align: center; vertical-align: middle;">People Readiness</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Plan</td>
                                                                                <td>100%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Actual</td>
                                                                                <td>74%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Index</td>
                                                                                <td>74,0%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Weight</td>
                                                                                <td class="text-end">10,00%</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <!-- Infrastructure Readiness -->
                                                                    <table class="table table-bordered" style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                                                        <thead style="background-color:rgb(107, 255, 149);">
                                                                            <tr>
                                                                                <th colspan="3" style="text-align: center; vertical-align: middle;">Infrastructure Readiness</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Plan</td>
                                                                                <td>100%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Actual</td>
                                                                                <td>75%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Index</td>
                                                                                <td>75,5%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Weight</td>
                                                                                <td class="text-end">10,00%</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                                @endsection
@section('scripts')

@endsection


