@extends('user.layout.mobile')

@section('title', 'Home')

@section('content')
    <h1 class="text-center text-xl mt-20 text-[#2A2A2A]">Welcome, {{ session('user_name') }}</h1>
@endsection
