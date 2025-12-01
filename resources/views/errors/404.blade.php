@extends('errors::layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('icon')
    <i class='bx bx-error'></i>
@endsection
@section('message', __('Sorry, the page you are looking for could not be found.'))
