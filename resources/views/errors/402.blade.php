@extends('errors::layout')

@section('title', __('Payment Required'))
@section('code', '402')
@section('icon')
    <i class='bx bx-money'></i>
@endsection
@section('message', __('Sorry, you must make a payment to continue.'))
