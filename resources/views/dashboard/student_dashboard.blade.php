@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between">
                        <span>Student Details</span>
                        <a class="edit-link"
                            href="{{ url('teacher/edit/'.$user->id) }}"><i
                                class="far fa-edit me-1"></i>Edit</a>
                    </h5>
                    <div class="row">
                        <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
                        <p class="col-sm-9">{{ $user->name }}</p>
                    </div>
                    <div class="row">
                        <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Gender</p>
                        <p class="col-sm-9">{{ $user->genderName() }}</p>
                    </div>
                    <div class="row">
                        <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth</p>
                        <p class="col-sm-9">{{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') }}</p>
                    </div>
                    <div class="row">
                        <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Email</p>
                        <p class="col-sm-9" style="color: blue">{{ $user->email }}</p>
                    </div>
                    <div class="row">
                        <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Mobile</p>
                        <p class="col-sm-9">{{ $user->phone_number }}</p>
                    </div>
                    <div class="row">
                        <p class="col-sm-3 text-muted text-sm-end mb-0">Address</p>
                        <p class="col-sm-9 mb-0">{{ $user->address }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Classes</h6>
                                    <h3>{{ $countClassFinished }}/{{ $countClass }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-01.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Lessons</h6>
                                    <h3>{{ $countLessonFinished }}/{{ $countLesson }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{URL::to('assets/img/icons/teacher-icon-02.svg')}}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Hours</h6>
                                    <h3>{{ $countHourFinished }}/{{ $countHour }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{URL::to('assets/img/icons/student-icon-01.svg')}}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-12 col-xl-8">
                    @foreach($classes as $class) 
                        <div class="card flex-fill comman-shadow">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title">{{ $class->name }}</h5>
                                    </div>
                                    <div class="col-6">
                                        <ul class="chart-list-out">
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="dash-circle">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 dash-widget1">
                                        <div class="circle-bar circle-bar2">
                                            <div class="circle-graph2" data-percent="{{ $class->percentFinished() }}">
                                                <b>{{ $class->percentFinished() }}%</b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="dash-details">
                                            <div class="lesson-activity">
                                                <div class="lesson-imgs">
                                                    <img src="{{URL::to('assets/img/icons/lesson-icon-05.svg')}}" alt="">
                                                </div>
                                                <div class="views-lesson">
                                                    <h5>Teacher</h5>
                                                    <h4>{{ $class->teacher->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="lesson-activity">
                                                <div class="lesson-imgs">
                                                    <img src="{{URL::to('assets/img/icons/lesson-icon-01.svg')}}" alt="">
                                                </div>
                                                <div class="views-lesson">
                                                    <h5>Class</h5>
                                                    <h4>{{ $class->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="lesson-activity">
                                                <div class="lesson-imgs">
                                                    <img src="{{URL::to('assets/img/icons/lesson-icon-02.svg')}}" alt="">
                                                </div>
                                                <div class="views-lesson">
                                                    <h5>Lessons</h5>
                                                    <h4>{{ $class->countFinished() }}/{{ count($class->lessons) }} Lessons</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="dash-details">
                                            <div class="lesson-activity">
                                                <div class="lesson-imgs">
                                                    <img src="{{URL::to('assets/img/icons/lesson-icon-03.svg')}}" alt="">
                                                </div>
                                                <div class="views-lesson">
                                                    <h5>Student</h5>
                                                    <h4>{{ count($class->students)}} Students</h4>
                                                </div>
                                            </div>
                                            <div class="lesson-activity">
                                                <div class="lesson-imgs">
                                                    <img src="{{URL::to('assets/img/icons/lesson-icon-04.svg')}}" alt="">
                                                </div>
                                                <div class="views-lesson">
                                                    <h5>Homework</h5>
                                                    <h4>{{ $class->countHomework() }} Homework</h4>
                                                </div>
                                            </div>
                                            <div class="lesson-activity">
                                                <div class="lesson-imgs">
                                                    <img src="{{URL::to('assets/img/icons/lesson-icon-06.svg')}}" alt="">
                                                </div>
                                                <div class="views-lesson">
                                                    <h5>Document</h5>
                                                    <h4>{{ $class->countDocument() }} Document</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 d-flex align-items-center justify-content-center">
                                        <div class="skip-group">
                                            <button type="submit" style="color: white; background-color: white; border:none;" class="btn btn-info skip-btn" disabled>skip</button>
                                            <button type="submit" style="color: white; background-color: white; border:none;" class="btn btn-info continue-btn" disabled>Continue</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-12 col-lg-12 col-xl-4 d-flex">
                    <div class="card flex-fill comman-shadow">
                        <div class="card-body">
                            <div id="calendar-doctor" class="calendar-container calendar-doctor-student"></div>
                            <div class="calendar-info1">
                                <div class="upcome-event-date">
                                    <h3>{{ $today->format('j M') }}</h3>
                                    <span><i class="fas fa-ellipsis-h"></i></span>
                                </div>
                                @foreach($classrooms as $classroom)
                                    @foreach($classroom->lessons as $lesson)
                                        
                                        <div class="calendar-details">
                                            <p>{{ $lesson->start_time->format('h:i a') }}</p>
                                            <div class="calendar-box normal-bg">
                                                <div class="calandar-event-name">
                                                    <h4>{{ $classroom->name }}</h4>
                                                    <h5>{{ $classroom->room->name }}</h5>
                                                </div>
                                                <span>{{ $lesson->start_time->format('h:i a') }} - {{ $lesson->end_time->format('h:i a') }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection