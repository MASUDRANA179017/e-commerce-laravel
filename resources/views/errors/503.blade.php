@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('icon')
    <i class='bx bxs-wrench'></i>
@endsection
@section('message', __("Sorry, we're down for essential maintenance right now. We'll be back online shortly."))
