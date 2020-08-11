@extends('layouts.app')
@section('content')
<user-module :module="{{ $module->toJson() }}" :user="{{ $auth->toJson() }}"></user-module>
@endsection
