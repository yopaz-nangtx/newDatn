
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Homework Result</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('class/list') }}">Class</a></li>
                                <li class="breadcrumb-item active">Homework Result</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-class table-hover table-center mb-0 datatable table-striped">
                                    <thead class="class-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Homework Name</th>
                                            <th>Total Question</th>
                                            <th>Correct Answer</th>
                                            <th>Score</th>
                                            <th>Finished at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentRenders as $key=>$list )
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>{{ ++$key }}</td>
                                            <td hidden class="avatar">{{ $list->upload }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ $list->image_url ? asset($list->image_url) :
                                                            asset('../images/photo_defaults.jpg') }}" alt="User Image">
                                                    </a>
                                                    <a href="student-details.html">{{ $list->name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $list->homeworkResult?->homework?->homework_name }}</td>
                                            <td>{{ count($list->homeworkResult?->homework?->questions) }}</td>
                                            <td>{{ floor(count($list->homeworkResult?->homework?->questions) * $list->homeworkResult?->score / 100) }}</td>
                                            <td>{{ $list->homeworkResult?->score ?? '0' }}</td>
                                            <td>{{ $list->homeworkResult?->created_at ?? '' }}</td>
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

    {{-- model lesson delete --}}
    <div class="modal custom-modal fade" id="lessonUser" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Lesson</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('lesson/delete') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" class="e_id" value="">
                                <input type="hidden" name="avatar" class="e_avatar" value="">
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


    <script>
        $(document).on('click','.lesson_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>
    @endsection

@endsection
