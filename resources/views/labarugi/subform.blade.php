@extends('template.main')
@section('title', 'Description ')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
        <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.81);">
        <div class="card-body">
            <div class="col-12">
            <a href="/labarugi" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">Description</h2>
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
                <form action="{{ route('createsub') }}" method="post">
                @csrf
                <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Caregory:</label>
                        <select id="kategori" name="kategori_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Caregory --</option>
                            @foreach($kat as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->namecategory }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori" class="form-label">Description</label>
                            <input type="text" class="form-control" id="kategori" placeholder="e.g.  Over Burden,  Penjualan Batu Bara, Demurrage Cost Etc. " value="" required name="namesub">
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
