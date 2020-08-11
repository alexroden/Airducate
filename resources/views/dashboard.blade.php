@extends('layouts.app')
@section('content')
<user-dashboard :user="{{ $auth->toJson() }}"></user-dashboard>
@endsection
