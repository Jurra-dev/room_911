@extends('layouts.app')

@section('title', 'Administrative menu')

@section('content')
    <listattempts-component :id="{{  $id  }}"></listattempts-component>
@endsection