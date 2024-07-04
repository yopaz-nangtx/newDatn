
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Class</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('class/add/page') }}">Class</a></li>
                                <li class="breadcrumb-item active">Edit Class</li>
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
                            <form action="{{ route('class/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{ $class->id }}" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title class-info">Class Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Name Class <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter Name" value="{{ $class->name }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Teacher <span class="login-danger">*</span></label>
                                            <select class="form-control  @error('teacher_id') is-invalid @enderror" name="teacher_id">
                                                <option selected disabled>Select Teacher</option>
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher?->id }}" @if($class->teacher?->name == $teacher?->name ) selected @endif>{{ $teacher?->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('teacher_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Gender <span class="login-danger">*</span></label>
                                            <select class="form-control  @error('room_id') is-invalid @enderror" name="room_id">
                                                <option selected disabled>Select Room</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room?->id }}" @if($class->room?->name == $room?->name ) selected @endif>{{ $room?->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('teacher_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Students <span class="login-danger">*</span></label>
                                            <select class="form-control multi-student @error('students') is-invalid @enderror" name="students[]" multiple="multiple">
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}" {{ $studentIds->contains($student->id) ? 'selected' : ''}}>
                                                        <span style="font-size: bold">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('students')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                                            
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Fee (VND) <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="fee" placeholder="Enter Fee" value="{{ $class->fee }}">
                                            @error('fee')
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
            $('.multi-student').select2();
        });
    </script>
@endsection