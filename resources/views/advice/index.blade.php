@extends('layouts.app')

@section('title', __('Conseils'))

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
<a href="{{ route('advices.create') }}" class="btn btn-sm btn-neutral">{{ __('Nouveau') }}</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="mb-0">{{ __('Conseils') }}</h3>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Conseil</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($advices as $advice)
                        <tr>
                            <td scope="row" class="name">
                                {{ $advice->quote }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-warning" href="{{ route('advices.edit', $advice) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {{ $advices->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
