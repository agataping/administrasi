@extends('template.main')
@extends('components.style')

@section('title', 'history_logs')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3">History Logs</h3>
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


                <form method="GET" action="{{ route('historylog') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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

                    <table class="table table-bordered" id="historyTb">
                        <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                            <tr>
                                <th style="vertical-align: middle;">No</th>
                                <th style="vertical-align: middle;">Action </th>
                                <th style="text-align: center;">Old Data</th>
                                <th style="text-align: center;">New Data</th>
                                <th style="text-align: center;">User</th>
                            </tr>


                        </thead>
                        <tbody>
                            @foreach($data as $d)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $d->action }}</td>

                                <td data-toggle="tooltip" title="{{ json_encode(json_decode($d->old_data), JSON_PRETTY_PRINT) }}">
                                    {{ Str::limit(json_encode(json_decode($d->old_data), JSON_PRETTY_PRINT), 50) }}
                                </td>
                                <td data-toggle="tooltip" title="{{ json_encode(json_decode($d->old_data), JSON_PRETTY_PRINT) }}">
                                    {{ Str::limit(json_encode(json_decode($d->new_data), JSON_PRETTY_PRINT), 50) }}
                                </td>
                                <td>{{ $d->username }}</td>



                                @endforeach
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" style="vertical-align: middle; background-color:rgb(244, 244, 244); text-align: end; "></th>

                        </tfoot>

                    </table>




                </div>

            </div>
        </div>
    </div>
</div>







<style>
    .pagination {
        font-size: 0.900rem;
    }

    .pagination .page-link {
        padding: 0.25rem 0.5rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }
</style>


@endsection
@section('scripts')
<script>
    function filterData() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("hisoryInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("historyTb");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) { // Mulai dari 1 jika baris pertama adalah header
            td = tr[i].getElementsByTagName("td");
            var rowContainsFilter = false; // Flag untuk menentukan apakah ada td yang cocok

            for (j = 0; j < td.length; j++) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rowContainsFilter = true; // Jika ada yang cocok, tandai baris
                    break; // Tidak perlu lanjutkan pencarian di baris ini
                }
            }

            if (rowContainsFilter) {
                tr[i].style.display = ""; // Tampilkan baris jika cocok
            } else {
                tr[i].style.display = "none"; // Sembunyikan baris jika tidak cocok
            }
        }
    }



    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection