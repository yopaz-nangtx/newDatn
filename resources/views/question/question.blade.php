
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('question/list') }}">Question</a></li>
                                <li class="breadcrumb-item active">All Questions</li>
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
                                        <h3 class="page-title">Questions</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('question/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="question-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questions as $key=>$list )
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>{{ ++$key }}</td>
                                            <td hidden class="id">{{ $list->id }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="">{{ $list->question }}</a>
                                                </h2>
                                            </td>
                                            <td>
                                                <li style="list-style-type: none; {{ $list->answer == 'option_1' ? 'font-weight: bold; color: #3d5ee1;' : '' }}">A. {{ $list->option_1 }}</li>
                                                <li style="list-style-type: none; {{ $list->answer == 'option_2' ? 'font-weight: bold; color: #3d5ee1;' : '' }}">B. {{ $list->option_2 }}</li>
                                                <li style="list-style-type: none; {{ $list->answer == 'option_3' ? 'font-weight: bold; color: #3d5ee1;' : '' }}">C. {{ $list->option_3 }}</li>
                                                <li style="list-style-type: none; {{ $list->answer == 'option_4' ? 'font-weight: bold; color: #3d5ee1;' : '' }}">D. {{ $list->option_4 }}</li>
                                            </td>
                                            {{-- <td>{{ $list->option_1 }}</td>
                                            <td>{{ $list->option_2 }}</td>
                                            <td>{{ $list->option_3 }}</td>
                                            <td>{{ $list->option_4 }}</td> --}}
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ url('question/edit/'.$list->id) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-edit me-2"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light question_delete" data-bs-toggle="modal" data-bs-target="#questionUser">
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

    {{-- model question delete --}}
    <div class="modal custom-modal fade" id="questionUser" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Question</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('question/delete') }}" method="POST">
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
        $(document).on('click','.question_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>
    @endsection

@endsection
