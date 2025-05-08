@extends('template.main')
@extends('components.style')
@section('title', 'infrastructure Readiness')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">infrastructure Readiness</h3>

                {{-- Success Notification --}}
                @if (session('success'))
                <div id="notif-success" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #28a745;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
                    {{ session('success') }}
                </div>
                @endif

                {{-- Error Notification --}}
                @if ($errors->any())
                <div id="notif-error" style="
                position: fixed;
                top: 60px; /* Biar nggak nabrak success */
                right: 20px;
                background-color: #dc3545;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                {{-- Script untuk menghilangkan notifikasi --}}
                <script>
                    setTimeout(function() {
                        let notifSuccess = document.getElementById("notif-success");
                        let notifError = document.getElementById("notif-error");

                        if (notifSuccess) {
                            notifSuccess.style.opacity = '0';
                            setTimeout(() => notifSuccess.remove(), 500);
                        }

                        if (notifError) {
                            notifError.style.opacity = '0';
                            setTimeout(() => notifError.remove(), 500);
                        }
                    }, 3000);
                </script>


                <div class="row">
                    <div class="col-sm-">
                        <a href="/fromadd" class="btn btn-custom">Add Data</a>
                    </div>
                </div>
                <!-- @if(auth()->user()->role === 'admin')

                <form method="GET" action="{{ route('indexInfrastructureReadiness') }}" id="filterForm">
                    <label for="id_company">Select Company:
                        <br>
                        <small><em>To view company data, please select a company from the list.</em></small></label>
                    <select name="id_company" id="id_company" onchange="document.getElementById('filterForm').submit();">
                        <option value="">-- Select Company --</option>
                        @foreach ($perusahaans as $company)
                        <option value="{{ $company->id }}" {{ request('id_company') == $company->id ? 'selected' : '' }}>
                            {{ $company->nama }}
                        </option>
                        @endforeach
                    </select>
                </form>
                @endif -->
                <div class="" style="overflow-x:auto;">
                    <form method="GET" action="{{ route('indexInfrastructureReadiness') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <div>
                            <label for="start_date" style="margin-right: 5px; font-weight: bold;">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate ? $startDate->toDateString() : '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                        </div>
                        <div>
                            <label for="end_date" style="margin-right: 5px; font-weight: bold;">End Date:</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate ? $endDate->toDateString() : '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                        </div>
                        <button type="submit" style=" padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">
                            Filter
                        </button>
                    </form>

                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                        style="margin-bottom: 10px; padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">

                    <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                        <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                            <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle;">No</th>
                                    <th rowspan="2" style="vertical-align: middle;">Project Name </th>
                                    <th colspan="3" style="text-align: center;">Physical Aspect</th>
                                    <th colspan="3" style="text-align: center;">Quality Aspectt</th>
                                    <th rowspan="2" style="vertical-align: middle;">Total</th>
                                    <th rowspan="2" style="vertical-align: middle;">Notes</th>
                                    <th rowspan="2" colspan="2" style="vertical-align: middle;">Action</th>
                                </tr>
                                <tr>
                                    <th>Preparation</th>
                                    <th>Construction</th>
                                    <th>Commissiong </th>
                                    <th>Building Feasibility</th>
                                    <th>Completeness</th>
                                    <th>Cleanliness </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->ProjectName }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->Preparation }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->Construction }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->Commissiong }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->KelayakanBangunan }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->Kelengakapan }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->Kebersihan }}</td>
                                    <td style="text-align: center; vertical-align: middle;">{{ $d->total }}</td>
                                    <td rowspan="" style="vertical-align: middle; padding: 5px;">
                                        <div style="word-wrap: break-word; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                            {!! nl2br(e($d->note)) !!}
                                        </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('formupdateInfrastructureReadiness', ['id' => $d->id]) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('deleteinfrastruktur', $d->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="11" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; ">Total</th>
                                    <th style="background-color:rgb(244, 244, 244); text-align: center;">
                                        {{ round($averagePerformance, 2) }}%
                                    </th>
                                </tr>
                                </tfoot>
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