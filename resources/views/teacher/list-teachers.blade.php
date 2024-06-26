
@extends('layouts.master')
@section('content')
{{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Teachers</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Teachers</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('teacher/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="DataList" class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread"> 
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>DOB</th>
                                            <th>Mobile Number</th>
                                            <th>Address</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listTeacher as $key => $list)
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="something">
                                                </div>
                                            </td>
                                            <td>{{ ++$key }}</td>
                                            <td hidden class="id
                                            ">{{ $list->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="teacher-details.html" class="avatar avatar-sm me-2">
                                                        @if (!empty($list->avatar))
                                                            <img class="avatar-img rounded-circle" src="{{ URL::to('images/'.$list->avatar) }}" alt="{{ $list->name }}">
                                                        @else
                                                            <img class="avatar-img rounded-circle" src="{{ URL::to('images/photo_defaults.jpg') }}" alt="{{ $list->name }}">
                                                        @endif
                                                    </a>
                                                    <a href="teacher-details.html">{{ $list->name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($list->birthday)->format('d/m/Y') }}</td>
                                            <td>{{ $list->phone_number }}</td>
                                            <td>{{ $list->address }}</td>
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ url('teacher/dashboard/'.$list->id) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-eye me-2" title="Overview"></i>
                                                    </a>
                                                    <a href="{{ url('teacher/edit/'.$list->id) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-edit me-2" title="Edit"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light teacher_delete" data-bs-toggle="modal" data-bs-target="#teacherDelete">
                                                        <i class="far fa-trash-alt me-2" title="Delete"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- model teacher delete --}}
    <div class="modal custom-modal fade" id="teacherDelete" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Student</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('teacher/delete') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" class="e_user_id" value="">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn" style="border-radius: 5px !important;">Delete</button>
                                </div>
                                <div class="col-6">
                                    <a href="#" data-bs-dismiss="modal"class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        {{-- delete js --}}
        <script>
            $(document).on('click','.teacher_delete',function()
            {
                var _this = $(this).parents('tr');
                $('.e_user_id').val(_this.find('.id').text());
            });
        </script>
    @endsection

@endsection
