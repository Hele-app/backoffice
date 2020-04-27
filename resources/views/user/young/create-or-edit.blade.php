@extends('layouts.app')

@section('title', $user->email ?? __('Nouveau jeune'))

@section('header-buttons')
@isset ($user)
<a href="{{ route('youngs.destroy', $user) }}" onclick="event.preventDefault(); if (confirm('{{ __('Êtes-vous sûr de vouloir supprimer cet utilisateur ?') }}')) document.getElementById('destroy-form').submit();" class="btn btn-sm btn-danger">
    {{ __('Supprimer') }}

    <form id="destroy-form" action="{{ route('youngs.destroy', $user) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</a>
@endisset
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <form method="POST" action="{{ isset($user) ? route('youngs.update', $user) : route('youngs.store') }}">
            @csrf
            @method(isset($user) ? 'PATCH' : 'POST')
            <div class="card">
                <div class="card-header">{{ $user->email ?? __('Nouveau jeune') }}</div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-control-label" for="phone">{{ __('Téléphone') }}</label>
                        <input class="form-control" type="phone" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="{{ __('Téléphone') }}" />

                        @error('phone')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="username">{{ __('Pseudonyme') }}</label>
                        <input class="form-control" type="text" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" placeholder="{{ __('Pseudonyme') }}" />

                        @error('username')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="birthyear">{{ __('Année de naissance') }}</label>
                        <input class="form-control" type="number" id="birthyear" name="birthyear" value="{{ old('birthyear', $user->birthyear ?? '') }}" placeholder="{{ __('Année de naissance') }}" />

                        @error('birthyear')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="role">{{ __('Role') }}</label>
                        <select class="form-control" id="role" name="role">
                            @foreach ($roles as $r)
                                <option value="{{ $r }}" @if(($user->role ?? 'YOUNG') === $r) selected @endif>{{ $r }}</option>
                            @endforeach
                        </select>

                        @error('role')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="establishment_code">{{ __('Etablissement') }}</label>
                        <select class="form-control" id="establishment_code" name="establishment_code">
                            {{-- TODO: establishment select --}}
                            @foreach ($establishments ?? [] as $e)
                                <option value="{{ $e->code }}" @if(($user->establishment_id ?? null) === $e->id) selected @endif>{{ $e->name }} [{{$e->code}}]</option>
                            @endforeach
                        </select>

                        @error('establishment_code')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
