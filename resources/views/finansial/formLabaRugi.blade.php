@extends('template.main')

@section('title', 'Laba Rugi')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-4">Laba Rugi</h2>

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

                <form action="{{ route('createLabarugi') }}" method="post">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                    @foreach($numberedDescriptions as $description) 

                        <div class="form-group mb-4">
                            <div class="form-group mb-4 {{ $description['parent_id'] ? 'ms-4' : '' }}">
                                <!-- Menampilkan nama kategori/subkategori -->
                                <label for="description_{{ $description['id'] }}" class="form-label">
                                    <strong>{{ $description['name'] }}</strong>
                                </label>

                                <input type="hidden" name="values[{{ $description['id'] }}][description_DescriptionName]" value="{{ $description['name'] }}">
                            </div>

                            <div class="container-fluid mt-3 p-3" style="border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
                                <div class="row g-3">
                                    <!-- Kolom untuk Revenue -->
                                    @if ($description['id'] == '3') 
                                    <div class="col-md-4">
                                        <label for="planYtd_{{ $description['id'] }}" class="form-label">Revenue Plan YTD</label>
                                        <input type="number" id="planYtd_{{ $description['id'] }}" class="form-control"
                                        name="values[{{ $description['id'] }}][PlaYtd]" 
                                        value="{{ old('values.' . $description['id'] . '.PlaYtd') }}" 
                                        oninput="calculateVerticalAnalysis({{ $description['id'] }}); 
                                        HitungDev({{ $description['id'] }});
                                        calculatePercentage({{ $description['id'] }})">
                                    </div>
                                    @endif
                                    
                                    
                                   <!-- buat masukin nilai plan ytd kategori + ini tidak muncul di sub karena sub gak nilai nya plannya  -->
                                    @if ($description['id'] != 3 && !$description['parent_id']) 
                                       
                                    <div class="col-md-4">
                                        <label for="planYtd_{{ $description['id'] }}" class="form-label">Plan YTD</label>
                                        <input type="number" id="planYtd_{{ $description['id'] }}" class="form-control" 
                                        data-parent-id="{{ $description['parent_id'] }}" 
                                        name="values[{{ $description['id'] }}][PlaYtd]" 
                                        value="{{ old('values.' . $description['id'] . '.PlaYtd') }}"
                                        oninput="calculateVerticalAnalysis({{ $description['id'] }}); HitungDev({{ $description['id'] }});
                                        calculatePercentage({{ $description['id'] }})">
                                    </div>
                                    @endif
                                    
                                    <!-- vertikal analisi + ini tidak muncul di sub karena sub gak nilai nya vertikal nya -->
                                    @if (in_array($description['id'], [6, 15, 22]))                                    
                                    <div class="col-md-4">
                                        <label for="verticalAnalisys1_{{ $description['id'] }}" class="form-label">Vertical Analysis</label>
                                        <input type="text" id="verticalAnalisys1_{{ $description['id'] }}" class="form-control" 
                                        data-parent-id="{{ $description['parent_id'] }}" 
                                        name="values[{{ $description['id'] }}][VerticalAnalisys1]" 
                                        value="{{ old('values.' . $description['id'] . '.VerticalAnalisys1') }}"
                                        readonly>
                                    </div>
                                    @endif
                                    


                
                                <!-- Input untuk Actual YTD -->
                                    @if (!$description['parent_id'])
                                    <div class="col-md-4">
                                        <label for="categoryTotal_{{ $description['id'] }}" class="form-label">Actual YTD</label>
                                        <input type="number" id="categoryTotal_{{ $description['id'] }}" 
                                        class="form-control" 
                                        name="values[{{ $description['id'] }}][Actualytd]" 
                                        value="{{ old('values.' . $description['id'] . '.categoryTotal', 0) }}" readonly
                                        placeholder="Total"
                                        oninput="HitungDev({{ $description['id'] }})">
                                    </div>
                                    
                                    @else
                                    <div class="col-md-4">
                                    <label for="categoryTotal_{{ $description['id'] }}" class="form-label">Actual YTD</label>

                                        <input type="number" id="actualYtd_{{ $description['id'] }}" 
                                        class="form-control actual-ytd" 
                                        data-parent-id="{{ $description['parent_id'] }}" 
                                        name="values[{{ $description['id'] }}][Actualytd]" 
                                        value="{{ old('values.' . $description['id'] . '.Actualytd', 0) }}">
                                    </div>
                                    @endif
                                    
                                    @if (!$description['parent_id'])
                                    <!-- Input untuk Vertical Analysis 2 -->
                                    <div class="col-md-4">
                                        <label for="verticalAnalisys2_{{ $description['id'] }}" class="form-label">Vertical Analysis</label>
                                        <input type="number" id="verticalAnalisys2_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][VerticalAnalisys]" 
                                            value="{{ old('values.' . $description['id'] . '.VerticalAnalisys') }}">
                                    </div>
                                    @endif

                                    @if (!$description['parent_id'])

                                    <!-- Input untuk Deviation -->
                                    <div class="col-md-4">
                                        <label for="deviation_{{ $description['id'] }}" class="form-label">Deviation</label>
                                        <input type="number" id="deviation_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][Deviation]" 
                                            value="{{ old('values.' . $description['id'] . '.Deviation') }}"
                                            oninput="calculatePercentage({{ $description['id'] }})"
                                            readonly>
                                    </div>
                                    @endif
                                    @if (!$description['parent_id'])

                                    <!-- Input untuk Percentage -->
                                    <div class="col-md-4">
                                        <label for="percentage_{{ $description['id'] }}" class="form-label">Percentage</label>
                                        <input type="text" id="percentage_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][Percentage]" 
                                            value="{{ old('values.' . $description['id'] . '.Percentage') }}"
                                            readonly>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection
