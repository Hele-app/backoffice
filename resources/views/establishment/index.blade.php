@extends('layouts.app')

@section('title', __('Etablissements'))

@section('header-buttons')
<form class="d-inline-flex" action="" method="GET">
    <div class="input-group">
        <input class="form-control form-control-alternative form-control-sm" type="text" name="q" value="{{ request()->input('q') }}" placeholder="{{ __('Recherche') }}" role="searchbox" />
        <div class="input-group-append">
            <button class="btn btn-sm btn-outline-neutral" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
<a href="{{ route('establishments.create') }}" class="btn btn-sm btn-neutral">{{ __('Nouveau') }}</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="mb-0">{{ __('Etablissements') }}</h3>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Nom</th>
                            <th scope="col" class="sort" data-sort="code">Code</th>
                            <th scope="col" class="sort" data-sort="region">Region</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($establishments as $establishment)
                        <tr>
                            <td scope="row" class="name">
                                {{ $establishment->name }}
                            </td>
                            <td scope="row" class="code">
                                {{ $establishment->code }}
                            </td>
                            <td scope="row" class="region">
                                {{ $establishment->region->name }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-warning" href="{{ route('establishments.edit', $establishment) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
