
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Add Classes</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('class/add/page') }}">Class</a></li>
                                <li class="breadcrumb-item active">Add Classes</li>
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
                            <form action="{{ route('lesson/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="class_id" value="{{ $class->id }}" readonly>
                                <input type="hidden" class="form-control" name="lesson_id" value="{{ $lesson->id }}" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title class-info">Lesson Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Name Lesson <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('lesson_name') is-invalid @enderror" name="lesson_name" placeholder="Enter Name" value="{{ $lesson->lesson_name }}">
                                            @error('lesson_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Start Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" placeholder="Enter Homework" value="{{ $startDate }}">
                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Start Time <span class="login-danger">*</span></label>
                                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" placeholder="Enter Homework" value="{{ $startTime }}">
                                            @error('start_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Homeworks <span class="login-danger">*</span></label>
                                            <select class="multi-homework form-control @error('homeworks') is-invalid @enderror" name="homeworks[]" multiple="multiple">
                                                @foreach ($homeworks as $homework)
                                                <option value="{{ $homework->id }}" {{ $homeworkIds->contains($homework->id) ? 'selected' : ''}}>
                                                    {{ $homework->homework_name }}
                                                </option>
                                            @endforeach
                                            </select>
                                            @error('homeworks')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                                            
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="class-submit">
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
            $('.multi-homework').select2();
        });
    </script>
@endsection