@extends('layouts.app')

@section('title', 'Home - ' . config('app.name'))

@section('content')
    <x-hero />

    <x-category-buttons :categories="$categories" />
@endsection
