@extends('template.main')
@section('title', 'Unit')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
            <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
            <h2 class="mb-3" onclick="window.history.back()" style="cursor: pointer;">Add Data Unit</h2>
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
                <form action="{{ route('createunit') }}" method="post">
                @csrf
                <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
                <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">

                <div id="">
                    <div class="row g-3">

                        <div class="">
                            <label for="" class="form-label">Unit Name</label>
                            <input type="text" class="form-control" id="" placeholder="e.g. Hauler Etc." value="" required name="unit">
                        </div>

                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" name="action" class="button btn-block btn-lg gradient-custom-4  me-2">Add</button>
                    <button type="submit" name="action" value="save" class="button btn-block btn-lg gradient-custom-4 ">Save</button>
                </div>
                
                
                </form>
                    
                </div>
            </div>
            
      
        

        
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
