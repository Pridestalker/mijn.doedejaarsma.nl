@extends('layouts.modernized')

@push('head')
    <script src="{{ asset('js/admin.app.js') }}" defer></script>
@endpush

@section('content')
    <main id="admin-app"></main>
@endsection
