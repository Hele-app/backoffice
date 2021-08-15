@extends('layouts.app')

@section('title', $article->title ?? __('Nouvel article'))

@section('header-buttons')
@isset ($article)
<a href="{{ route('articles.destroy', $article) }}" onclick="event.preventDefault(); if (confirm('{{ __('Êtes-vous sûr de vouloir supprimer cet article ?') }}')) document.getElementById('destroy-form').submit();" class="btn btn-sm btn-danger">
    {{ __('Supprimer') }}

    <form id="destroy-form" action="{{ route('articles.destroy', $article) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</a>
@endisset
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <form method="POST" enctype="{{ isset($article) ? 'application/json' : 'multipart/form-data' }}" action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}">
            @csrf
            @method(isset($article) ? 'PATCH' : 'POST')
            <div class="card">
                <div class="card-header">{{ $article->title ?? __('Nouvel article') }}</div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-control-label" for="title">{{ __('Titre') }}</label>
                        <input class="form-control" type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" placeholder="{{ __('Titre') }}" required/>

                        @error('title')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @if(!isset($article))
                    <div class="form-group">
                        
                        <label for="file" class="btn btn-primary form-control-label"><input type="file" id="file" name="file" required/>
                        </label>

                        @error('file')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    @else
                        <div class="form-group">
                        <label class="form-control-label" for="file">Télécharger le PDF</label>
                        <a class="btn btn-primary form-control" href="{{ config('app.hele_api_base_url') . $article->filepath }}" target="_blank">PDF</a>
                        </div>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
