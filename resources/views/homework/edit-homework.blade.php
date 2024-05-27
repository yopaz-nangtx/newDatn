
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Questions</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('question/add/page') }}">Question</a></li>
                                <li class="breadcrumb-item active">Edit Questions</li>
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
                            <form action="{{ route('question/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{ $questionEdit->id }}" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title room-info">Question Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Question <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" placeholder="Enter Question" value="{{ $questionEdit->question }}">
                                            @error('question')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>A. <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('option_1') is-invalid @enderror" name="option_1" placeholder="Enter Option" value="{{ $questionEdit->option_1 }}">
                                            @error('option_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>B. <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('option_2') is-invalid @enderror" name="option_2" placeholder="Enter Option" value="{{ $questionEdit->option_2 }}">
                                            @error('option_2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>C. <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('option_3') is-invalid @enderror" name="option_3" placeholder="Enter Option" value="{{ $questionEdit->option_3 }}">
                                            @error('option_3')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>D. <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('option_4') is-invalid @enderror" name="option_4" placeholder="Enter Option" value="{{ $questionEdit->option_4 }}">
                                            @error('option_4')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Answer <span class="login-danger">*</span></label>
                                            <select id="answer" class="form-control @error('answer') is-invalid @enderror" name="answer">
                                                <option value="">--- Select Answer ---</option>
                                                <option value="option_1" @if($questionEdit->answer == 'option_1') selected @endif>A</option>
                                                <option value="option_2" @if($questionEdit->answer == 'option_2') selected @endif>B</option>
                                                <option value="option_3" @if($questionEdit->answer == 'option_3') selected @endif>C</option>
                                                <option value="option_4" @if($questionEdit->answer == 'option_4') selected @endif>D</option>
                                            </select>
                                            @error('answer')
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
@endsection
