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
                                    <!-- Input untuk Plan YTD -->
                                    <div class="col-md-4">
                                        <label for="planYtd_{{ $description['id'] }}" class="form-label">Plan YTD</label>
                                        <input type="number" id="planYtd_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][PlaYtd]" 
                                            value="{{ old('values.' . $description['id'] . '.PlaYtd') }}"
                                            >
                                    </div>

                                    <!-- Input untuk Vertical Analysis 1 -->
                                    <div class="col-md-4">
                                        <label for="verticalAnalisys1_{{ $description['id'] }}" class="form-label">Vertical Analysis</label>
                                        <input type="number" id="verticalAnalisys1_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][VerticalAnalisys1]" 
                                            value="{{ old('values.' . $description['id'] . '.VerticalAnalisys1') }}">
                                    </div>

                                    <!-- Input untuk Actual YTD -->
                                    <div class="col-md-4">
                                        <label for="actualYtd_{{ $description['id'] }}" class="form-label">Actual YTD</label>
                                        <input type="number" id="actualYtd_{{ $description['id'] }}" 
                                            class="form-control actual-ytd" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][Actualytd]" 
                                            value="{{ old('values.' . $description['id'] . '.Actualytd', 0) }}">
                                    </div>

                                    <!-- Input untuk Vertical Analysis 2 -->
                                    <div class="col-md-4">
                                        <label for="verticalAnalisys2_{{ $description['id'] }}" class="form-label">Vertical Analysis</label>
                                        <input type="number" id="verticalAnalisys2_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][VerticalAnalisys]" 
                                            value="{{ old('values.' . $description['id'] . '.VerticalAnalisys') }}">
                                    </div>

                                    <!-- Input untuk Deviation -->
                                    <div class="col-md-4">
                                        <label for="deviation_{{ $description['id'] }}" class="form-label">Deviation</label>
                                        <input type="number" id="deviation_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][Deviation]" 
                                            value="{{ old('values.' . $description['id'] . '.Deviation') }}">
                                    </div>

                                    <!-- Input untuk Percentage -->
                                    <div class="col-md-4">
                                        <label for="percentage_{{ $description['id'] }}" class="form-label">Percentage</label>
                                        <input type="number" id="percentage_{{ $description['id'] }}" class="form-control" 
                                            data-parent-id="{{ $description['parent_id'] }}" 
                                            name="values[{{ $description['id'] }}][Percentage]" 
                                            value="{{ old('values.' . $description['id'] . '.Percentage') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="form-group mb-4">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" id="year" class="form-control" name="year">
                    </div>
                    
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
