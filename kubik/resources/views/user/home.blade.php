@extends('user.layout.mobile')

@section('title', 'Home')

@section('content')
    <h1 class="text-center text-xl mt-20 text-[#2A2A2A]">Welcome, {{ session('user_name') }}</h1>
    <a href="{{ route('user.logout') }}" class="block mt-10 text-center text-blue-500">Logout</a>
@endsection
