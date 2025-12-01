@extends('errors::layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('icon')
    <i class='bx bxs-shield-x'></i>
@endsection
@section('message', __('Sorry, you are not authorized to access this page.'))
