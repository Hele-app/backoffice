@extends('layouts.app')

@section('title', $advice->name ?? __('Nouveau conseil'))

@section('header-buttons')
@isset ($advice)
<a href="{{ route('advices.destroy', $advice) }}" onclick="event.preventDefault(); if (confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce conseil ?') }}')) document.getElementById('destroy-form').submit();" class="btn btn-sm btn-danger">
    {{ __('Supprimer') }}

    <form id="destroy-form" action="{{ route('advices.destroy', $advice) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</a>
@endisset
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <form method="POST" action="{{ isset($advice) ? route('advices.update', $advice) : route('advices.store') }}">
            @csrf
            @method(isset($advice) ? 'PATCH' : 'POST')
            <div class="card">
                <div class="card-header">{{ $advice->quote ?? __('Nouveau conseil') }}</div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-control-label" for="quote">{{ __('Conseil/citation') }}</label>
                        <input class="form-control" type="text" id="quote" name="quote" value="{{ old('quote', $advice->quote ?? '') }}" placeholder="{{ __('Conseil') }}" required/>

                        @error('quote')
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
