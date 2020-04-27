@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <x-widgets.professionals-widget />
    <x-widgets.youngs-widget />
    {{-- <x-widgets.messages-widget /><x-widgets.reports-widget /> --}}
</div>
@endsection
