@extends('layouts.error')
@section('content')
    <div class="main-wrapper">
        <div class="error-box">
            <h1>419</h1>
            <h3 class="h2 mb-3"><i class="fas fa-exclamation-triangle"></i> Expired Error</h3>
            <p class="h4 font-weight-normal">The page you requested was not found.</p>
            @if(Session::get('role') == 1) 
                <a href="{{route('home')}}" class="btn btn-primary">Back to Home</a>
            @else 
                <a href="{{ route('teacher/dashboard', ['id' => Session::get('id')]) }}" class="btn btn-primary">Back to Home</a>
            @endif
        </div>
    </div>
@endsection
