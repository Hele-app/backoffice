@extends('layouts.app')

@section('title', $poi->name ?? __('Nouveau point d\'intérêt'))

@section('header-buttons')
@isset ($poi)
<a href="{{ route('map.destroy', $poi) }}" onclick="event.preventDefault(); if (confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce point d\'intérêt ?') }}')) document.getElementById('destroy-form').submit();" class="btn btn-sm btn-danger">
    {{ __('Supprimer') }}

    <form id="destroy-form" action="{{ route('map.destroy', $poi) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</a>
@endisset
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <form method="POST" action="{{ isset($poi) ? route('map.update', $poi) : route('map.store') }}">
            @csrf
            @method(isset($poi) ? 'PATCH' : 'POST')
            <div class="card">
                <div class="card-header">{{ $poi->name ?? __('Nouveau point d\'intérêt') }}</div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-control-label" for="name">{{ __('Nom') }}</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $poi->name ?? '') }}" placeholder="{{ __('Nom') }}" />

                        @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{--
                        $poi->hour = $data['hour'];
                        $poi->phone = $data['phone'];
                        $poi->site = $data['site'];
                        $poi->latitude = $data['latitude'];
                        $poi->longitude = $data['longitude'];
                    --}}

                    <div class="form-group">
                        <label class="form-control-label" for="description">{{ __('Description') }}</label>
                        <textarea class="form-control" id="description" name="description" placeholder="{{ __('Description') }}">{{ old('description', $poi->description ?? '') }}</textarea>

                        @error('description')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="address">{{ __('Adresse') }}</label>
                        <input class="form-control" type="text" id="address" name="address" value="{{ old('address', $poi->address ?? '') }}" placeholder="{{ __('Adresse') }}" />

                        @error('address')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="zipcode">{{ __('Code Postal') }}</label>
                        <input class="form-control" type="text" id="zipcode" name="zipcode" value="{{ old('zipcode', $poi->zipcode ?? '') }}" placeholder="{{ __('Code Postal') }}" />

                        @error('zipcode')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="city">{{ __('Ville') }}</label>
                        <input class="form-control" type="text" id="city" name="city" value="{{ old('city', $poi->city ?? '') }}" placeholder="{{ __('Ville') }}" />

                        @error('city')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="hour">{{ __('Horaires') }}</label>
                        <input class="form-control" type="text" id="hour" name="hour" value="{{ old('hour', $poi->hour ?? '') }}" placeholder="{{ __('Horaires') }}" />

                        @error('hour')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="phone">{{ __('Téléphone') }}</label>
                        <input class="form-control" type="text" id="phone" name="phone" value="{{ old('phone', $poi->phone ?? '') }}" placeholder="{{ __('Téléphone') }}" />

                        @error('phone')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="site">{{ __('Site Web') }}</label>
                        <input class="form-control" type="text" id="site" name="site" value="{{ old('site', $poi->site ?? '') }}" placeholder="{{ __('Site Web') }}" />

                        @error('site')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="latitude">{{ __('Latitude') }}</label>
                        <input class="form-control" type="number" step="0.0000000001" id="latitude" name="latitude" value="{{ old('latitude', $poi->latitude ?? '') }}" placeholder="{{ __('Latitude') }}" />

                        @error('latitude')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="longitude">{{ __('Longitude') }}</label>
                        <input class="form-control" type="number" step="0.0000000001" id="longitude" name="longitude" value="{{ old('longitude', $poi->longitude ?? '') }}" placeholder="{{ __('Longitude') }}" />

                        @error('longitude')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="region_id">{{ __('Region') }}</label>
                        <select class="form-control" id="region_id" name="region_id">
                            @foreach ($regions as $r)
                                <option value="{{ $r->id }}" @if(($poi->region_id ?? 10) === $r->id) selected @endif>{{ $r->name }}</option>
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
