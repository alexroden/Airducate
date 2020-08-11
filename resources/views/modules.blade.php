@extends('layouts.app')
@section('content')
<user-modules :user="{{ $auth->toJson() }}"></user-modules>
@endsection
