
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Add Homeworks</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('homework/add/page') }}">Homework</a></li>
                                <li class="breadcrumb-item active">Add Homeworks</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form action="{{ route('homework/add/save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title room-info">Homework Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('homework_name') is-invalid @enderror" name="homework_name" placeholder="Enter Name" value="{{ old('homework_name') }}">
                                            @error('homework_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Time (Minutes) <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('time') is-invalid @enderror" name="time" placeholder="Enter Time" value="{{ old('time') }}">
                                            @error('time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Questions <span class="login-danger">*</span></label>
                                            <select class="form-control multi-question @error('questions') is-invalid @enderror" name="questions[]" multiple="multiple">
                                                @foreach ($questions as $question)
                                                    <option value="{{ $question->id }}"><span style="font-size: bold">Question {{ $question->id }}: </span>{{ $question->question }}</option>
                                                @endforeach
                                            </select>
                                            @error('questions')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                                            
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>End Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" placeholder="Enter Homework" value="{{ old('end_date') }}">
                                            @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>End Time <span class="login-danger">*</span></label>
                                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" placeholder="Enter Homework" value="{{ old('end_time') }}">
                                            @error('end_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="room-submit">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.multi-question').select2();
        });
    </script>
@endsection
