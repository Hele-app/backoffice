@extends('layouts.app')

@section('title', __('Jeunes'))

@section('header-buttons')
<a href="{{ route('youngs.create') }}" class="btn btn-sm btn-neutral">{{ __('Nouveau') }}</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="mb-0">{{ __('Jeunes') }}</h3>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="phone">Téléphone</th>
                            <th scope="col" class="sort" data-sort="username">Pseudonyme</th>
                            <th scope="col" class="sort" data-sort="establishment">Etablissement</th>
                            <th scope="col" class="sort" data-sort="birthyear">Année de naissance</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($users as $user)
                        <tr>
                            <td scope="row" class="phone">
                                {{ $user->phone }}
                            </td>
                            <td scope="row" class="username">
                                {{ $user->username }}
                            </td>
                            <td scope="row" class="establishment">
                                {{ $user->establishment }}
                            </td>
                            <td scope="row" class="birthyear">
                                {{ $user->birthyear }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-warning" href="{{ route('youngs.edit', $user) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
