@extends('layouts.app')
@section('content')
<register :questions="{{ json_encode($questions) }}" token="{{ $userToken }}"></register>
@endsection
