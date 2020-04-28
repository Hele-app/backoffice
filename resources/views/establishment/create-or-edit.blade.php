@extends('layouts.app')

@section('title', $establishment->name ?? __('Nouvel établissement'))

@section('header-buttons')
@isset ($establishment)
<a href="{{ route('establishments.destroy', $establishment) }}" onclick="event.preventDefault(); if (confirm('{{ __('Êtes-vous sûr de vouloir supprimer cet établissement ?') }}')) document.getElementById('destroy-form').submit();" class="btn btn-sm btn-danger">
    {{ __('Supprimer') }}

    <form id="destroy-form" action="{{ route('establishments.destroy', $establishment) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</a>
@endisset
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <form method="POST" action="{{ isset($establishment) ? route('establishments.update', $establishment) : route('establishments.store') }}">
            @csrf
            @method(isset($establishment) ? 'PATCH' : 'POST')
            <div class="card">
                <div class="card-header">{{ $establishment->name ?? __('Nouvel établissement') }}</div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-control-label" for="name">{{ __('Nom') }}</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $establishment->name ?? '') }}" placeholder="{{ __('Nom') }}" />

                        @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="code">{{ __('Code') }}</label>
                        <input class="form-control" type="text" id="code" name="code" readonly value="{{ old('code', $establishment->code ?? '') }}" placeholder="{{ __('Code') }}" />

                        @error('code')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="region_id">{{ __('Region') }}</label>
                        <select class="form-control" id="region_id" name="region_id">
                            @foreach ($regions as $r)
                                <option value="{{ $r->id }}" @if(($establishment->region_id ?? 10) === $r->id) selected @endif>{{ $r->name }}</option>
                            @endforeach
                        </select>

                        @error('region_id')
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
