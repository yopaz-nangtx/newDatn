
@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between">
                        <span>Teacher Details</span>
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
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Classes</h6>
                                    <h3>{{ $countClass }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-01.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Students</h6>
                                    <h3>{{ $countStudent }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/dash-icon-01.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Lessons</h6>
                                    <h3>{{ $countLesson }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-02.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total Hours</h6>
                                    <h3>{{ $countHour }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ URL::to('assets/img/icons/teacher-icon-03.svg') }}" alt="Dashboard Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-lg-12 col-xl-8">
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12 d-flex">
                            <div class="card flex-fill comman-shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="card-title">Overview Monthly</h5>
                                        </div>
                                        <div class="col-6">
                                            <ul class="chart-list-out">
                                                <li><span class="circle-blue"></span>Classes</li>
                                                <li><span class="circle-green"></span>Students</li>
                                                <li class="star-menus"><a href="javascript:;"><i
                                                            class="fas fa-ellipsis-v"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="teacher-monthly-area"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-xl-12 d-flex">
                            <div class="card flex-fill comman-shadow">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h5 class="card-title">Overview Yearly</h5>
                                        </div>
                                        <div class="col-6">
                                            <ul class="chart-list-out">
                                                <li><span class="circle-blue"></span>Classes</li>
                                                <li><span class="circle-green"></span>Students</li>
                                                <li class="star-menus"><a href="javascript:;"><i
                                                            class="fas fa-ellipsis-v"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="teacher-yearly-area"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-4 d-flex">
                    <div class="card flex-fill comman-shadow">
                        <div class="card-body">
                            <div id="calendar-doctor" class="calendar-container calendar-doctor-teacher"></div>
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
