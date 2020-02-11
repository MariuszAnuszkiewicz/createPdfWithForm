@extends('layouts.app')

@section('title')
   Form
@endsection
@section('content')
   <form-component :rows='{{ json_encode($rows) }}' :length='{{ $length }}'></form-component>
@endsection