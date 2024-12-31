@extends('template.main')
@section('title', '')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3"></h2>
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
                <ul class="list-group list-group-flush">
                @foreach($data as $item)
                

                    <a class="list-group-item" href="/dummy"> {{ $loop->iteration }}. {{ $item->nama}}</a>
                    @endforeach
                </ul>


                
            </div>
        </div>
        
            
      
        

        
    </div>
</div>
        
        
        




                                            
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                
 @endsection
                                
@section('scripts')

@endsection
