@extends('template.main')

@section('title', 'Barging')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Barging</h2>
                
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

                    
                        <form action="{{ route('updatePlan') }}" method="post">
                            @csrf
                            
                            <div class="form-group">
                                <label for="tanggal">Plan</label>
                                <input type="number" class="form-control" id="tanggal" name="nominal" value="{{ $nominal }}"  required>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                
                                <button type="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            @endsection
            
            @section('scripts')
            @endsection
            