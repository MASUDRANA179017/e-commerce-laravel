@extends('errors::layout')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('icon')
    <i class='bx bx-traffic-cone'></i>
@endsection
@section('message', __('Sorry, you are making too many requests to our servers. Please wait a moment and try again.'))
