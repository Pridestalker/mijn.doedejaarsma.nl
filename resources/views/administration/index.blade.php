@extends('layouts.app')

@push('head')
    <script src="{{ asset('js/admin.app.js') }}" defer></script>
@endpush

@section('content')

<main id="admin-app"></main>

{{--    <div class="card">--}}
{{--        <div class="card-header">--}}
{{--            Trackthis--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--            <admin-track-view></admin-track-view>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
