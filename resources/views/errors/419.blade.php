@extends('errors::layout')

@section('title', __('Page Expired'))
@section('code', '419')
@section('icon')
    <i class='bx bx-time-five'></i>
@endsection
@section('message', __('Sorry, your session has expired. Please refresh and try again.'))
