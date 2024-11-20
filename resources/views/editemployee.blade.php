@extends('layouts.app')

@section('title', 'Administrative menu')

@section('content')
    <editemployee-component :id="{{  $id  }}"></editemployee-component>
@endsection