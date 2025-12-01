@extends('errors::layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('icon')
    <i class='bx bx-server'></i>
@endsection
@section('message', __('Sorry, something went wrong on our servers. Our team has been notified.'))
