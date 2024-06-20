
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('lesson/list/' . $class->id) }}">Class Detail</a></li>
                                <li class="breadcrumb-item active">All Classes</li>
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
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Class Detail</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ url('lesson/add/page/' . $class->id) }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

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
                                            <th>Lesson Name</th>
                                            <th>Time</th>
                                            <th>Homework</th>
                                            <th>Document</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lessons as $key=>$list )
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>{{ ++$key }}</td>
                                            <td hidden class="id">{{ $list->id }}</td>
                                            <td hidden class="avatar">{{ $list->upload }}</td>
                                            <td>{{ $list->lesson_name }}</td>
                                            <td>{{ $list->start_time }}</td>
                                            <td>
                                                @if (count($list->homeworks) > 0)
                                                    @foreach ($list->homeworks as $homework)
                                                        {{ $homework->homework_name }} <br>
                                                    @endforeach
                                                @else
                                                    No homeworks found
                                                @endif
                                            </td>
                                            <td>
                                                @if (count($list->documents) > 0)
                                                    @foreach ($list->documents as $document)
                                                        {{ $document->document_name }} <br>
                                                    @endforeach
                                                @else
                                                    No documents found
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ url('lesson/homework/'.$list->id) }}" class="btn btn-sm bg-danger-light {{ $list->is_finished ? 'disabled-link' : '' }}" title="Homework">
                                                        <i class="fas fa-book me-2"></i>
                                                    </a>
                                                    <a href="{{ url('lesson/attendance/'.$list->id) }}" class="btn btn-sm bg-danger-light {{ $list->is_finished ? 'disabled-link' : '' }}" title="Attendance">
                                                        <i class="fas fa-clipboard-list me-2"></i>
                                                    </a>
                                                    <a href="{{ url('lesson/edit/'.$list->id . '/class/' . $class->id) }}" class="btn btn-sm bg-danger-light {{ $list->is_finished ? 'disabled-link' : '' }}" title="Edit">
                                                        <i class="fas fa-edit me-2"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light lesson_delete {{ $list->is_finished ? 'disabled-link' : '' }}" data-bs-toggle="modal" data-bs-target="#lessonUser" title="Delete">
                                                        <i class="far fa-trash-alt me-2"></i>
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
                            <input type="hidden" class="form-control" name="class_id" value="{{ $class->id }}" readonly>
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
