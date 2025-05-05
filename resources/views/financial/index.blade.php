@extends('template.main')
@extends('components.script')
@extends('components.style')
@section('title', 'Balence sheet')
@section('content')


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
<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">Balance sheet</h3>

                <div class="row justify-content-start mb-0">
                    <div class="col-auto">
                        <form action="{{ route('categoryneraca') }}" method="get">
                            <input type="hidden" name="form_type" value="kategori">
                            <button type="submit" class="btn btn-custom">Add Description</button>
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
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..."
                        style="margin-bottom: 10px; padding: 8px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">
                    <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
                        <table id="myTable" class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">

                            <thead style="vertical-align: middle; text-align: center; padding: 2px 5px; line-height: 1; position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center;">
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px;">No</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center; width: 200px;">Description</th>
                                    <th colspan="3" style="vertical-align: middle; text-align: center;">Plan</th>
                                    <th colspan="3" style="vertical-align: middle; text-align: center;">Actual</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center; width: 100px;">Date</th>
                                    <th colspan="2" rowspan="2" style="vertical-align: middle; text-align: center;">Action</th>
                                </tr>
                                <tr>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>File</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data as $jenis_name => $categories)
                                @foreach ($categories as $category => $sub_categories)

                                <tr>
                                    <th style="vertical-align: middle;">{{ $loop->iteration }}</th>
                                    <td colspan="" class=""><strong>{{ $category }}</strong></td>
                                    <td style="text-align: end;"><strong>{{ number_format($categoryTotals[$category]['debit'] ?? 0, 2) }}</strong></td>
                                    <td style="text-align: end;"><strong>{{ number_format($categoryTotals[$category]['credit'] ?? 0, 2) }}</strong></td>
                                    <td></td>
                                    <td style="text-align: end;"><strong>{{ number_format($categoryTotals[$category]['debit_actual'] ?? 0, 2) }}</strong></td>
                                    <td style="text-align: end;"><strong>{{ number_format($categoryTotals[$category]['credit_actual'] ?? 0, 2) }}</strong></td>
                                    <td></td>
                                    <td>
                                        <form action="{{ route('formupdatecatneraca', ['id' => $sub_categories->flatten()->first()->category_id]) }}">

                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>
                                    </td>
                                </tr>

                                @foreach ($sub_categories as $sub_category => $details)
                                <tr data-bs-toggle="collapse" data-bs-target="#detail-{{ Str::slug($details->first()->sub_category, '-') }}" style="cursor: pointer;">

                                    <td>{{ $loop->parent ? $loop->parent->iteration : '0' }}.{{ $loop->iteration }}</td>
                                    <td colspan="">
                                        {{ $sub_category }}

                                    </td>
                                    <td style="text-align: end;">{{ number_format($subCategoryTotals[$sub_category]['debit'] ?? 0, 2) }}</td>
                                    <td style="text-align: end;">{{ number_format($subCategoryTotals[$sub_category]['credit'] ?? 0, 2) }}</td>
                                    <td></td>
                                    <td style="text-align: end;">{{ number_format($subCategoryTotals[$sub_category]['debit_actual'] ?? 0, 2) }}</td>
                                    <td style="text-align: end;">{{ number_format($subCategoryTotals[$sub_category]['credit_actual'] ?? 0, 2) }}</td>
                                    <td></td>
                                    <td>
                                        <form action="{{ route('formupdatesubneraca', ['id' => $details->flatten()->first()->sub_id]) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                        </form>

                                    </td>
                                    <td>
                                        <form action="{{ route('deletesubfinan', ['id' => $details->flatten()->first()->sub_id]) }}" method="POST" onsubmit="return confirmDelete(event)">


                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="detail-{{ Str::slug($details->first()->sub_category, '-') }}" class="d-none">
                                    <td colspan="9">
                                        <table class="table table-bordered">
                                            @foreach ($details as $detail)
                                            <tr>
                                                <td>{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                <td>{{ $detail->name }}</td>
                                                <td style="text-align: end;">{{ number_format($detail->debit,2 ) }}</td>
                                                <td style="text-align: end;">{{ number_format($detail->credit,2 ) }}</td>
                                                <td>
                                                    @if (!empty($detail->fileplan))
                                                    <a href="{{ asset('storage/' . $detail->fileplan) }}" class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fas fa-file"></i> View File
                                                    </a>
                                                    @else
                                                    <span class="text-muted">No File</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: end;">{{ number_format($detail->debit_actual,2 ) }}</td>
                                                <td style="text-align: end;">{{ number_format($detail->credit_actual,2 ) }}</td>
                                                <td>
                                                    @if (!empty($detail->fileactual))
                                                    <a href="{{ asset('storage/' . $detail->fileactual) }}" class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fas fa-file"></i> View File
                                                    </a>
                                                    @else
                                                    <span class="text-muted">No File</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">{{ \Carbon\Carbon::parse($detail->tanggal)->format('d-m-Y') }}</td>
                                                <td>
                                                    <form action="{{ route('formupdatefinancial', ['id' => $detail->id]) }}">
                                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('deletefinancial', ['id' => $detail->id]) }}" method="POST" onsubmit="return confirmDelete(event)">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                                <tr>
                                    <!-- <td colspan="5" class="table-primary"><strong>{{ $jenis_name }}</strong></td> -->
                                    @if ($jenis_name === 'FIX ASSETS')
                                <tr style="color:black; background-color:rgb(244, 244, 244); text-align: end;">
                                    <th style="text-align: start;" colspan="2">Total {{ strtoupper($jenis_name) }}</th>
                                    <th style="color:black; background-color:rgb(244, 244, 244); text-align: end;" colspan="2">{{ number_format($totalplanfixasset, 2) }}</th>
                                    <th></th>
                                    <th colspan="2">{{ number_format($totalactualfixtasset, 2) }}</th>
                                    <th colspan="3"></th>
                                </tr>
                                @elseif ($jenis_name === 'CURRENT ASSETS')
                                <tr style="color:black; background-color:rgb(244, 244, 244); text-align: end;">
                                    <th colspan="2" style="text-align: start;">Total {{ strtoupper($jenis_name) }}</th>
                                    <th colspan="2">{{ number_format($totalplancurrentasset, 2) }}</th>
                                    <th></th>
                                    <th colspan="2">{{ number_format($totalactualcurrentasset, 2) }}</th>
                                    <th colspan="3"></th>
                                </tr>
                                <tr style="color:black; background-color:rgb(244, 244, 244);"">
                                    <th colspan=" 2">Total Assets</th>
                                    <th colspan="2" style="text-align: end;">{{ number_format($totalplanasset, 2) }}</th>
                                    <th></th>
                                    <th colspan="2" style="text-align: end;">{{ number_format($totalactualasset, 2) }}</th>
                                    <th colspan="3"></th>
                                </tr>

                                @elseif ($jenis_name === 'LIABILITIES')
                                <tr style="color:black; background-color:rgb(244, 244, 244); text-align: end;">
                                    <th colspan="2" style="text-align: start;">Total {{ strtoupper($jenis_name) }}</th>
                                    <th colspan="2">{{ number_format($totalplanliabiliti, 2) }}</th>
                                    <th></th>
                                    <th colspan="2">{{ number_format($totalactualliabiliti, 2) }}</th>
                                    <th colspan="3"></th>
                                </tr>
                                @elseif ($jenis_name === 'EQUITY')
                                <tr style="color:black; background-color:rgb(244, 244, 244); text-align: end;">
                                    <th colspan="2" style="text-align: start;">Total {{ strtoupper($jenis_name) }}</th>
                                    <th colspan="2">{{ number_format($totalplanequity, 2) }}</th>
                                    <th></th>
                                    <th colspan="2">{{ number_format($totalactualequity, 2) }}</th>
                                    <th colspan="3"></th>
                                </tr>
                                <tr style="color:black; background-color:rgb(244, 244, 244); text-align: end;">
                                    <th style="text-align: start;" colspan="2">Total LIABILITIES EQUITY</th>
                                    <th colspan="2">{{ number_format($totalplanmodalhutang, 2) }}</th>
                                    <th></th>
                                    <th colspan="2">{{ number_format($totalactualmodalhutang, 2) }}</th>
                                    <th colspan="3"></th>
                                </tr>

                                @endif
                                @endforeach
                                <tr style="color:black; background-color:rgb(244, 244, 244); text-align: end;">
                                    <th style="text-align: start;" colspan="2">Control Actual</th>
                                    <th colspan="2">{{ $noteactual }}</th>
                                    <th colspan="6"></th>
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
        document.querySelectorAll("tr[data-bs-toggle='collapse']").forEach(function(row) {
            row.addEventListener("click", function() {
                let targetId = this.getAttribute("data-bs-target");
                let targetElement = document.querySelector(targetId);

                if (targetElement) {
                    // Toggle visibility
                    targetElement.classList.toggle("d-none");
                }
            });
        });
    });

    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("myTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td");
            let rowVisible = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        rowVisible = true;
                        break;
                    }
                }
            }

            tr[i].style.display = rowVisible ? "" : "none";
        }
    }

    {
        {
            --resources / views / components / script.blade.php--
        }
    }
    console.log("Script file is loaded!");
</script>

@endsection