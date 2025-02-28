@extends('template.main')
@section('title', 'Description OverBurden & Coal getting')
@section('content')
@extends('components.style')

<div class="background-full" style="background: url('{{ asset('img/tambang-batubara.jpg') }}') no-repeat center center/cover; height: 100vh; width: 100vw; position: fixed; top: 0; left: 0; z-index: -1;">
</div>
<div class="container-fluid mt-4">
    <div class="card w-100" style="background-color:rgba(255, 255, 255, 0.96);">
        <div class="card-body">
            <div class="col-12">
                <h3 class="mb-3" onclick="window.history.back()" style="cursor: pointer;">Add Data Description Overburden & Coal getting</h3>

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