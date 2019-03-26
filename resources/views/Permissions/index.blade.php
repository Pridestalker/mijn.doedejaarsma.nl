@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            Rechten
            @can('create-permissions')
                <a class="btn ml-auto btn-outline-primary" href="{{ route('permissions.create') }}" style="-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;">+</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">slug</th>
                    <th scope="col">Titel</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <th scope="row">
                            {{ $permission->id }}
                        </th>
                        <td>
                            {{ $permission->name }}
                        </td>
                        <td>
                            {{ $permission->title }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
