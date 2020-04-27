@extends('layouts.app')

@section('title', __('Professionels'))

@section('header-buttons')
<a href="{{ route('professionals.create') }}" class="btn btn-sm btn-neutral">{{ __('Nouveau') }}</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="mb-0">{{ __('Professionels') }}</h3>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="phone">Téléphone</th>
                            <th scope="col" class="sort" data-sort="username">Pseudonyme</th>
                            <th scope="col" class="sort" data-sort="email">eMail</th>
                            <th scope="col" class="sort" data-sort="profession">Profession</th>
                            <th scope="col" class="sort" data-sort="role">Role</th>
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
                            <td scope="row" class="email">
                                {{ $user->email }}
                            </td>
                            <td scope="row" class="profession">
                                {{ $user->profession }}
                            </td>
                            <td scope="row" class="role">
                                {{ $user->role }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-warning" href="{{ route('professionals.edit', $user) }}">
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
