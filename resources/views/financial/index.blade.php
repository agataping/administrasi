@extends('template.main')
@extends('components.style')
@section('title', 'Balence sheet')
@section('content')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">Balance sheet</h3>
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
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <form action="{{ route('categoryneraca') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Deskripsi</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('subneraca') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Sub.</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('formfinanc') }}" method="get">
                            <input type="hidden" name="form_type" value="subkategori">
                            <button type="submit" class="btn btn-custom">Add Detail</button>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-start ">
                    <div class="col-auto">
                        <a href="/indexcategoryneraca">View Description Data
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="/indexsubneraca">View Sub-description Data</a>
                    </div>
                </div>


                <!-- @if(auth()->user()->role === 'admin')    
                    
                    <form method="GET" action="{{ route('indexfinancial') }}" id="filterForm">
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
                <div style="overflow-x:auto;">
                    <form method="GET" action="{{ route('indexfinancial') }}" style="text-transform: uppercase;display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <div>
                            <label for="start_date" style="margin-right: 5px; font-weight: bold;">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                        </div>
                        <div>
                            <label for="end_date" style="margin-right: 5px; font-weight: bold;">End Date:</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}"
                                style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;" />
                        </div>
                        <button type="submit" style=" padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s ease;">
                            Filter
                        </button>
                    </form>

                    <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                        <table class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">

                            <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">No</th>
                                    <th rowspan="2" style="vertical-align: middle;  text-align: center;">Description</th>
                                    <th colspan="3" style="vertical-align: middle; text-align: center;">plan</th>
                                    <th colspan="3" style="vertical-align: middle; text-align: center;">actual</th>
                                    <th rowspan="2" style="vertical-align: middle;  text-align: center;">Date</th>
                                    <th colspan="2" rowspan="2" style="vertical-align: middle; text-align: center;">Action</th>
                                </tr>

                                <tr>
                                    <th rowspan="" style="vertical-align: middle; text-align: center;">Debit</th>
                                    <th rowspan="" style="vertical-align: middle;  text-align: center;">credit</th>
                                    <th rowspan="" style="vertical-align: middle;  text-align: center;">file</th>

                                    <th rowspan="" style="vertical-align: middle; text-align: center;">Debit</th>
                                    <th rowspan="" style="vertical-align: middle;  text-align: center;">credit</th>
                                    <th rowspan="" style="vertical-align: middle;  text-align: center;">file</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedData as $total)
                                {{-- Tampilkan Kategori --}}
                                <tr>
                                    <td style="vertical-align: middle;">{{ $loop->iteration }}</td>
                                    <td colspan=""><strong>{{ $total['category_name'] }}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td></td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('formupdatecatneraca', ['id' => $total['category_id']]) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- Tampilkan Sub-Kategori --}}
                                @foreach ($total['sub_categories'] as $subIndex => $subCategory)
                                <tr data-toggle="collapse" data-target="#detail-{{ Str::slug($subCategory['sub_category'], '-') }}" style="cursor: pointer;">

                                    <td style="vertical-align: middle;">{{ $loop->parent ? $loop->parent->iteration : '0' }}.{{ $loop->iteration }}</td>
                                    <td>{{ $subCategory['sub_category'] }}</td>
                                    <td  style=" text-align: end;">{{ number_format($subCategory['sub_total_debit']) }}</td>
                                    <td   style=" text-align: end;">{{ number_format ($subCategory['sub_total_credit']) }}</td>
                                    <td></td>
                                    <td   style=" text-align: end;">{{ number_format($subCategory['sub_total_debitactual']) }}</td>
                                    <td   style=" text-align: end;">{{ number_format ($subCategory['sub_total_creditactual']) }}</td>

                                    <td></td>
                                    <td></td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('formupdatesubneraca', ['id' => $subCategory['sub_id']]) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                        <form action="{{ route('deletesubfinan', ['id' => $subCategory['sub_id']]) }}" method="POST" onsubmit="return confirmDelete(event)"> @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="detail-{{ Str::slug($subCategory['sub_category'], '-') }}" class="d-none">
                                    <td colspan="7">
                                        <table class="table table-bordered" style=" width: 100%; border-collapse: collapse;">
                                            <tbody>

                                                @foreach ($subCategory['details'] as $detailIndex => $detail)
                                                <tr>
                                                    <td>{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                    <td>{{ $detail['name'] }}</td>
                                                    <td style=" text-align: end;"  >{{ number_format($detail['debit'],2 ) }}</td>
                                                    <td style="text-align: end;"  >{{ number_format($detail['credit'], ) }}</td>
                                                    <td>
                                                        @if (!empty($detail['fileplan']))
                                                        <a href="{{ asset('storage/' . $detail['fileplan']) }}" class="text-decoration-none" target="_blank">View File</a>
                                                        @else
                                                        <span class="text-muted">No File</span>
                                                        @endif
                                                    </td>
                                                    <td style=" text-align: end;"  >{{ number_format($detail['debit_actual'], 2) }}</td>
                                                    <td style="text-align: end;"  >{{ number_format($detail['credit_actual'],2 ) }}</td>
                                                    <td>
                                                        @if (!empty($detail['fileactual']))
                                                        <a href="{{ asset('storage/' . $detail['fileactual']) }}" class="text-decoration-none" target="_blank">View File</a>
                                                        @else
                                                        <span class="text-muted">No File</span>
                                                        @endif
                                                    </td>

                                                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($detail['tanggal'])->format('d-m-Y') }}</td>
                                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                                        <form action="{{ route('formupdatefinancial', ['id' => $detail['id']]) }}">
                                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                                        </form>
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;" rowspan="">
                                                        <form action="{{ route('deletefinancial', $detail['id']) }}" method="POST" onsubmit="return confirmDelete(event)"> @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </td>
                                </tr>

                                @endforeach
                                <tr>
                                    @if (in_array($total['category_name'], ['CURRENT ASSETS', 'FIX ASSETS']))
                                    <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">Total {{ $total['category_name'] }}</th>
                                    <td  colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  >
                                        {{ number_format($total['subTotalplanasset'], 2) }}
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>

                                    <td colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  > {{ number_format($total['subTotalSaldoActualasset'], 2) }}</td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    @endif

                                </tr>
                                @if (in_array($total['category_name'], ['LIABILITIES', 'EQUITY']))
                                <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;"  >Total {{ $total['category_name'] }}</th>
                                <td  colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  >
                                    {{ number_format($total['subTotalplanmodalhutang'], 2) }}
                                <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>

                                <td colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  > {{ number_format($total['subTotalSaldoActualmodalhutang'], 2) }}</td>
                                <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                @endif

                                </tr>

                                <tr>
                                    @if ($total['category_name'] == 'CURRENT ASSETS')
                                    <th colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">TOTAL ASSETS :</th>
                                    <td colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  > {{ number_format($totalplanasset, 2) }}</td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <td colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  > {{ number_format($totalactualasset, 2) }}</td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    @endif
                                </tr>
                                <tr>
                                    @if ($total['category_name'] == 'EQUITY')
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <th colspan="" style="background-color:rgb(244, 244, 244); text-align: end;">TOTAL LIABILITIES AND EQUITY </th>
                                    <td colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  > {{ number_format($modalhutangplan, 2) }}</td>
                                    <td colspan="2" style="background-color:rgb(244, 244, 244); text-align: end;"  > {{ number_format($modalhutangactual, 2) }}</td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"  ></td>
                                    @endif
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" style="text-align: end; background-color:rgb(244, 244, 244); text-align: end;">Control :</td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
                                    <td colspan="" style="background-color:rgb(244, 244, 244); text-align: end;"></td>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("tr[data-toggle='collapse']").forEach(function(row) {
            row.addEventListener("click", function() {
                let targetId = this.getAttribute("data-target");
                let targetElement = document.querySelector(targetId);

                if (targetElement) {
                    // Toggle visibility
                    targetElement.classList.toggle("d-none");
                }
            });
        });
    });


</script>

@endsection