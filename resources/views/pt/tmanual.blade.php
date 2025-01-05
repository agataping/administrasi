@extends('template.main')
@section('title', '')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
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
                            <h2 class="text-center">TOTAL PERFORMANCE (YEAR TO DATE)</h2>
            <p class="text-center">LEVEL: JTN SITE</p>


                <div class="container mt-2">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-3" style="background-color: #f4e2cd; ">TOTAL PERFORMANCE (YEAR TO DATE)</h2>
            
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
                            <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;"> 
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Revenue</th>
                                        <th colspan="2" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tr></tr>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>Plan</td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td>actual</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>index</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>weight</td>
                                        <td class="text-end">5,00%
                                            </td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                        
                        
                        
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;"> 
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Gross Profit (GP) Margin</th>
                                            <th colspan="2" class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>Plan</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Actual</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Index</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Weight</td>
                                            <td class="text-end">4,00%</td>
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
                                        <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Coal Mine (MT)</th>
                                                    <th colspan="2" class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td>Plan</td>
                                                    <td>35.376</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Actual</td>
                                                    <td>17.479</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Index</td>
                                                    <td>49,4%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Weight</td>
                                                    <td class="text-end">3,00%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <!-- Overburden Removal (BCM) -->
                                        <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                            <thead>
                                                
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="small">Overburden Removal (BCM)</th>
                                                    <th colspan="2" class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td>Plan</td>
                                                    <td>245.306</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Actual</td>
                                                    <td>165.645</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Index</td>
                                                    <td>67,5%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Weight</td>
                                                    <td class="text-end">3,00%</td>
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
                                                <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Fleet Productivity (Coal)</th>
                                                            <th colspan="2" class="text-center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td>Plan</td>
                                                            <td>22.176</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Actual</td>
                                                            <td>10.095</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Index</td>
                                                            <td>45,5%</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
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
                                                <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Fleet Productivity (OB)</th>
                                                            <th colspan="2" class="text-center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td>Plan</td>
                                                            <td>113.010</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Actual</td>
                                                            <td>55.221</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Index</td>
                                                            <td>48,9%</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
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
                                                        <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th>People Readiness</th>
                                                                    <th colspan="2" class="text-center"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Plan</td>
                                                                    <td>100%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Actual</td>
                                                                    <td>74%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Index</td>
                                                                    <td>74,0%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
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
                                                        <table style="border: 1px solid black; border-collapse: collapse; width: 16rem;">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th>Infrastructure Readiness</th>
                                                                    <th colspan="2" class="text-center"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Plan</td>
                                                                    <td>100%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Actual</td>
                                                                    <td>75%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Index</td>
                                                                    <td>75,5%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
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


