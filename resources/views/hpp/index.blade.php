@extends('template.main')
@extends('components.style')
@section('title', 'Kategori HPP')
@section('content')
<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">HPP</h2>
                
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
                <div class="row">
                    <div class="col-sm-2 ms-3">
                        <a href="/hpp" class="btn btn-custom">Add Monthly Production</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        
                        <tr>
                            <th>No</th>
                            <th>Uraian</th>
                            <th colspan="2" class="text-center"></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Rencana</th>
                            <th>Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><strong>HPP</strong></td>
                            <td class="text-end">{{ number_format($data['HPP']['rencana'], 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($data['HPP']['realisasi'], 0, ',', '.') }}</td>
                        </tr>
                        @php $no = 1; @endphp
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><strong>{{ $category->uraian }}</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($category->children as $child)
                        <tr>
                            <td></td>
                            <td>  - {{ $child->uraian }}</td>
                            <td class="text-end">{{ number_format($child->nominal ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end">0</td>
                        </tr>
                        @endforeach
                        @endforeach
                        <tr>
                            <td colspan="2"><strong>Total HPP</strong></td>
                            <td class="text-end"><strong>{{ number_format($data['HPP']['rencana'], 0, ',', '.') }}</strong></td>
                            <td class="text-end"><strong>{{ number_format($data['HPP']['realisasi'], 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>

                
            </div>
            
        </div>
    </div>
</div>
    

@endsection

@section('scripts')
@endsection

