@extends('template.main')

@section('title', 'HSE ')

@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
            <a href="/indexhse" class=" text-decoration-none " style="color: black;">
                <h2 class="mb-3">UPDATE DATA HSE</h2>
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

                        <form action="{{ route('updatehse', $hse->id) }}" method="post">
                            @csrf
                            
                            <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">
                            <div style="margin-bottom: 1rem;">
                                <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                                <select id="kategori" name="kategori_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                                    <option value="" disabled selected>-- Select Category --</option>
                                    @foreach($kategori as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $hse->kategori_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div style="margin-bottom: 1rem;">
                                <label for="tanggal" style="font-weight: bold; font-size: 1rem;">Date</label>
                                <input 
                                type="date" 
                                id="tanggal" 
                                name="date" 
                                value="{{$hse->date}}" 
                                style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <label for="nameindikator">Indicator</label>
                                <input type="text" class="form-control" value="{{ $hse->nameindikator }}" id="nameindikator" name="nameindikator" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="target">Target</label>
                                <input type="text" class="form-control" value="{{ $hse->target }}" id="target" name="target" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="nilai">value</label>
                                <input type="text" class="form-control" value="{{ $hse->nilai }}" id="nilai" name="nilai" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="indikator">Indicator</label>
                                <input type="text" class="form-control" value="{{ $hse->indikator }}" id="indikator" name="indikator" required>
                            </div>


                            <div class="form-group">
                                <label for="keterangan">Description</label>
                                <input type="text" class="form-control" value="{{ $hse->keterangan }}" id="keterangan" name="keterangan" >
                            </div>
                            

                    
                    <div class="d-flex justify-content-end mt-3">
                        
                                               <button type="submit" class="btn-block btn-lg gradient-custom-4"
                        style=" background-color: rgb(0, 255, 42); color: white; border: none;padding: 10px 20px;font-size: 16px;cursor: pointer; 
                            border-radius: 5px; font-weight: bold;"">Update</button>
                    </div>
                </form>
            </div>
        </div>
</div>

@endsection

@section('scripts')
@endsection