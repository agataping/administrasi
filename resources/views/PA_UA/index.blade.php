@extends('template.main')
@extends('components.style')

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
                
                <div class="row">
                    <div class="col-sm-">
                        <a href="/unit" class="btn btn-custom">Add unit</a>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-">
                        <a href="/produksi" class="btn btn-custom">Add produksi</a>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-sm-2">
                        
                        <form method="GET" action="{{ url('/') }}">
                            <label for="year">Filter by Year:</label>
                            <select name="year" id="year" onchange="this.form.submit()">
                                <option value="">All Years</option>
                                @foreach ($years as $availableYear)
                                <option value="{{ $availableYear }}" {{ $year == $availableYear ? 'selected' : '' }}>
                                    {{ $availableYear }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div> 
                </div> 


                <table class="table table-bordered">
                    <thead style="background-color:rgb(6, 99, 120)"  class="text-white">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;">No</th>
                            <th  rowspan="2" style="vertical-align: middle;">CODE NUMBER </th>
                            <th colspan="4" style="text-align: center; vertical-align: middle;">Produksi OB</th>
                            <th colspan="4" style="text-align: center; vertical-align: middle;">Produksi Coal</th>
                            <th colspan="4" style="text-align: center; vertical-align: middle;">HOURS</th>
                            <th rowspan="2" style="vertical-align: middle;">MOHH</th>
                            <th rowspan="2" style="vertical-align: middle;">PA</th>
                            <th rowspan="2" style="vertical-align: middle;">UA</th>
                            <th  colspan="4"style="text-align: center;">FUEL CONSUMTION</th>
                            <th  rowspan="2"style="vertical-align: middle;">Total HM</th>
                            <th  colspan="3"style="vertical-align: middle;">FUEL RASIO (LITER)</th>
                            <th  rowspan="2"style="vertical-align: middle;">MA</th>
                            <th  rowspan="2"style="vertical-align: middle;">PA</th>
                            <th  rowspan="2"style="vertical-align: middle;">UA</th>
                            <th  rowspan="2"style="vertical-align: middle;">EU</th>
                            <th  rowspan="2"style="vertical-align: middle;">PA PLAN</th>
                            <th  rowspan="2"style="vertical-align: middle;">UA PLAN</th>

                            
                            <th rowspan="2"style="vertical-align: middle;">created_by</th>
                            <th rowspan="2"  style="vertical-align: middle;">Aksi</th>
                        </tr>
                        
                        <tr>
                        <th>BCM</th>
                            <th>WH OB</th>
                            <th>PTY</th>
                            <th>DISTANCE</th>

                            <th>MT</th>
                            <th>WH Coal</th>
                            <th>PTY</th>
                            <th>DISTANCE</th>

                            <th>GENERAL</th>
                            <th>RENTAL</th>
                            <th>STBY</th>
                            <th>BD</th>

                            <th>TOT. LITER</th>
                            <th>L/WH</th>
                            <th>Liter OB</th>
                            <th> Liter Coal</th>

                            <th>L/HM</th>
                            <th>L/BCM</th>
                            <th>L/MT</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="33"style="text-align: center; background-color:rgb(6, 99, 120)"  class="text-white">{{$hauler->first()->unit ?? 'Unit Tidak Ditemukan'}}</th>
                            
                        </tr>
                        

                        @foreach($hauler as $d)
                        
                        <tr>
                            
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->code_number }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_bcm }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_pty }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_distance }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->coal_mt }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->coal_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->coal_pty }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->coal_distance }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->general_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->rental_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->stby_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->bd_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->mohh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->pa }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ua }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_total }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_coal }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->t_hm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_hm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_bcm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_mt }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_ma }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_pa }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_ua }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->eu }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->pa_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ua_plan }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formupdateProduksi', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>


                            
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="32" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; " >Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        </th>
                    </tr>
                    </tfoot>
                    </tbody>
                    

                    <tbody>
                            <th colspan="33"style="text-align: center; background-color:rgb(6, 99, 120)"  class="text-white">{{ $loader->first()->unit ?? 'Unit Tidak Ditemukan'}}</th>

                        <tr>
                        @foreach($loader as $d)

                        <tr>
                            
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->code_number }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_bcm }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_pty }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_distance }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->coal_mt }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->coal_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->coal_pty }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->coal_distance }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->general_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->rental_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->stby_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->bd_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->mohh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->pa }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ua }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_total }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_coal }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->t_hm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_hm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_bcm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_mt }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_ma }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_pa }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_ua }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->eu }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->pa_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ua_plan }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formupdateProduksi', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>


                            
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="32" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; "  >Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        </th>
                    </tr>
                    </tfoot>
                    </tbody>

                    <tbody>

                            <th colspan="33"style="text-align: center; background-color:rgb(6, 99, 120) " class="text-white">{{ $support->first()->unit ?? '-' }}</th>

                        <tr>
                        @foreach($support as $d)

                        <tr>
                            
                            <th rowspan="" style="vertical-align: middle;">{{ $loop->iteration }}</th>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->code_number }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_bcm }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_pty }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->ob_distance }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->coal_mt }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $d->coal_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->coal_pty }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->coal_distance }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->general_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->rental_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->stby_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->bd_hours }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->mohh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->pa }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ua }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_total }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_wh }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ltr_coal }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->t_hm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_hm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_bcm }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->l_mt }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_ma }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_pa }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->tot_ua }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->eu }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->pa_plan }}</td>
                            <td style="text-align: center; vertical-align: middle;" >{{ $d->ua_plan }}</td>

                            <td style="text-align: center; vertical-align: middle;" >{{ $d->created_by }}</td>
                            <td style="text-align: center; vertical-align: middle;" >
                                <a href="{{ route('formupdateProduksi', ['id' => $d->id]) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>


                            
                            
                        </tr>
                        
                        @endforeach
                        <tr>
                        <th  colspan="32" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; "  >Total</th>
                        <th style="background-color:rgb(244, 244, 244); text-align: center;">
                        </th>
                    </tr>
                    </tfoot>
                    </tbody>


                </table>                        


                




                </div>
            </div>
            
      
        

        
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
