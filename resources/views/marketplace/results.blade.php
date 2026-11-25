@extends('layouts.app')
@section('content')
<h1 class="h3 mb-4">{{ $heading }}</h1>
@include('marketplace.partials.cards', ['listings' => $listings])
@endsection
