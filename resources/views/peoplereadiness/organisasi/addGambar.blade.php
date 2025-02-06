@extends('template.main')
@section('title', 'Organisational Structure')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
            <a href="/struktur" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Add Data Organisational Structure</h2>
                </a>                
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
                <form action="{{ route('createbagan') }}" method="POST" enctype="multipart/form-data">

                
                    @csrf

                    <div class="row g-3">
                        <div class="col-sm-2">
                            <label for="firstName" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="firstName" placeholder="" value="" required name="gambar" >
                        </div>
  
                            <div class="d-flex justify-content-end  mt-3">
                                <button type="submit"
                                
                                class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Save</button>
                            </div>
                            

                            
                        </div>
                    </form>
                    
                </div>
            </div>
            
      
        

        
    </div>
</div>
        
        
        







@endsection
@section('scripts')

@endsection
