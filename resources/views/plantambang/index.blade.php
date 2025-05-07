@extends('template.main')
@extends('components.style')

@section('title', 'mining plan')
@section('content')


<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">mining plan</h2>
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



                <div class="row">
                    <div class="col-sm-">
                        <a href="/formplantambang" class="btn btn-custom">Add Data</a>
                    </div>
                </div>
                <form method="GET" action="{{ route('indexplantambang') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
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


                <table class="table table-bordered" style="border: 2px solid gray; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.51);">
                    <thead style=" position: sticky; top: 0; z-index: 1; background-color:rgba(9, 220, 37, 0.75); text-align: center; vertical-align: middle;">
                        <tr>
                            <th>
                                no
                            </th>
                            <th>flie</th>
                            <th colspan="2">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)

                        <tr>
                            <td style="vertical-align: middle;">{{ $loop->iteration }}</td>

                            <td>
                                @php
                                $fileExtension = $d->file_extension ?? 'unknown';
                                @endphp
                                <a href="{{ asset('storage/' . $d->path) }}" class="text-decoration-none" target="_blank">View File</a>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <a href="{{ route('formupdateplantambang', $d->id) }}" class="btn btn-primary btn-sm">Update</a>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <form action="{{ route('deleteplantambang', $d->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onsubmit="return confirmDelete(event)">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>




            </div>
        </div>
    </div>
</div>


















@endsection
@section('scripts')
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
@endsection