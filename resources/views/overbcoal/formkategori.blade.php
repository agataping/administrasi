@extends('template.main')
@section('title', 'Description Over Burden & Coal')
@section('content')
@extends('components.style')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
            <h2 class="mb-3" onclick="window.history.back()" style="cursor: pointer;">Add Data Description Over Burden & Coal</h2>

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
                <form action="{{ route('createkatgeoriobc') }}" method="post">
                @csrf
                <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                <div style="margin-bottom: 1rem;">
                        <label for="name" style="font-weight: bold; font-size: 1rem;">Description:</label>
                        <input type="text" class="form-control" id="plan" name="nominalplan">
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
