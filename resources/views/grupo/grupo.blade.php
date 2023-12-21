@extends('layout.main')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
@endpush


@section('main-content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="container-fluid mt-2">
        <div class="card">
            <div class="card-body">
                LAYOUT CAMANCHACA
            </div> 

        </div>
    </div>
    
</div>
@endsection

@push('Script')
    <script>
        const Home = '{{ route("Home") }}'
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>

@endpush