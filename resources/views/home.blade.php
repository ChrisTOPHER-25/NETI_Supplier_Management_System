 @extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('Admin Links') }}</div>

                <div class="card-body">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}
                    <div class="row p-3">
                        <div class="list-group w-auto">
                            <a href="{{route('admin.boms')}}" class="list-group-item list-group-item-action fw-bold">BOM List</a>
                            <a href="#" class="list-group-item list-group-item-action fw-bold">Test 1</a>
                            <a href="#" class="list-group-item list-group-item-action fw-bold">Test 2</a>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Dropdown button
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#">Action</a></li>
                              <li><a class="dropdown-item" href="#">Another action</a></li>
                              <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                          </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
