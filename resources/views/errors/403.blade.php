@extends('errors::layout')

@section('title', __('Forbidden'))
@section('code', '403')
@section('icon')
    <i class='bx bx-block'></i>
@endsection
@section('message', __($exception->getMessage() ?: 'Sorry, you are forbidden from accessing this page.'))
