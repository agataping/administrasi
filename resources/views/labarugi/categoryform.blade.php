@extends('template.main')
@section('title', 'Description ')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-2">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <a href="/labarugi" class=" text-decoration-none " style="color: black;">
                    <h3 class="mb-3">Description</h3>
                </a>

                {{-- Success Notification --}}
                @if (session('success'))
                <div id="notif-success" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #28a745;
                
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                transition: opacity 0.5s ease;
                ">
                    {{ session('success') }}
                </div>
                @endif

                {{-- Error Notification --}}
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


                {{-- Script untuk menghilangkan notifikasi --}}
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


                <form action="{{ route('createkatlabarugi') }}" method="post">
                    @csrf
                    <input type="hidden" name="created_by_name" value="{{ Auth::user()->username }}">
                    <div style="margin-bottom: 1rem;">
                        <label for="kategori" style="font-weight: bold; font-size: 1rem;">Select Category:</label>
                        <select id="kategori" name="jenis_id" style="width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                            <option value="" disabled selected>-- Select Category --</option>
                            @foreach($kat as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori" class="form-label">Description</label>
                            <input type="text" class="form-control" id="kategori" placeholder="e.g.  Revenue, Cost of Goods Sold (COGS), Salary Etc." value="" required name="namecategory">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="">
                            <label for="kategori[]" class="form-label">Order Number</label>
                            <input type="number" class="form-control" id="kategori" placeholder="" value="" required name="ordernumber ">
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