@extends('layouts.app')

@section('title', $user->email ?? __('Nouveau professionel'))

@section('header-buttons')
@isset ($user)
<a href="{{ route('professionals.destroy', $user) }}" onclick="event.preventDefault(); if (confirm('{{ __('Êtes-vous sûr de vouloir supprimer cet utilisateur ?') }}')) document.getElementById('destroy-form').submit();" class="btn btn-sm btn-danger">
    {{ __('Supprimer') }}

    <form id="destroy-form" action="{{ route('professionals.destroy', $user) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</a>
@endisset
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <form method="POST" action="{{ isset($user) ? route('professionals.update', $user) : route('professionals.store') }}">
            @csrf
            @method(isset($user) ? 'PATCH' : 'POST')
            <div class="card">
                <div class="card-header">{{ $user->email ?? __('Nouveau professionel') }}</div>

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
                        <label class="form-control-label" for="profession">{{ __('Profession') }}</label>
                        <input class="form-control" type="text" id="profession" name="profession" value="{{ old('profession', $user->profession ?? '') }}" placeholder="{{ __('Profession') }}" />

                        @error('profession')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="city">{{ __('Ville') }}</label>
                        <input class="form-control" type="text" id="city" name="city" value="{{ old('city', $user->city ?? '') }}" placeholder="{{ __('Ville') }}" />

                        @error('city')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="email">{{ __('eMail Pro') }}</label>
                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="{{ __('eMail Pro') }}" />

                        @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="phone_pro">{{ __('Téléphone Pro') }}</label>
                        <input class="form-control" type="phone" id="phone_pro" name="phone_pro" value="{{ old('phone_pro', $user->phone_pro ?? '') }}" placeholder="{{ __('Téléphone Pro') }}" />

                        @error('phone_pro')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="role">{{ __('Role') }}</label>
                        <select class="form-control" id="role" name="role">
                            @foreach ($roles as $r)
                                <option value="{{ $r }}" @if(($user->role ?? 'PROFESSIONAL') === $r) selected @endif>{{ $r }}</option>
                            @endforeach
                        </select>

                        @error('role')
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
