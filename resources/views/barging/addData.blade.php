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
                @if (session('errors'))
                <div class="alert alert-success">
                    {{ session('errors') }}
                </div>
                @endif

                    
                        <form action="{{ route('createbarging') }}" method="post">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Data</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label for="kuota" style="font-weight: bold; font-size: 1rem;">Pilih Kategori:</label>
                                <select id="kuota" name="kuota" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="Ekspor">Ekspor</option>
                                    <option value="Domestik">Domestik</option>
                                </select>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="nomor">Laycan</label>
                                <input type="text" class="form-control" id="nomor" name="laycan" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Name Of Barge</label>
                                <input type="text" class="form-control" id="description" name="namebarge" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="nomor_legalitas">Surveyor</label>
                                <input type="text" class="form-control" id="nomor_legalitas" name="surveyor" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="Status">Port Loading</label>
                                <input type="text" class="form-control" id="Status" name="portloading" required>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="tanggal_berlaku">Port Of Discharging</label>
                                <input type="text" class="form-control" id="" name="portdishcharging" required>
                            </div>

                            
                            <div class="form-group">
                                <label for="tanggal_berlaku">Notify Addres</label>
                                <input type="text" class="form-control" id="" name="notifyaddres" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_berlaku">Initial Survey</label>
                                <input type="date" class="form-control" id="" name="initialsurvei" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_berlaku">Final Survey</label>
                                <input type="date" class="form-control" id="" name="finalsurvey" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_berlaku">Quantity</label>
                                <input type="text" class="form-control" id="" name="quantity" required>
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