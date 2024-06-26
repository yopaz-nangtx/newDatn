
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('document/list') }}">Document</a></li>
                                <li class="breadcrumb-item active">All Documents</li>
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
                                        <h3 class="page-title">Documents</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('document/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-document table-hover table-center mb-0 datatable table-striped">
                                    <thead class="document-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Upload Time</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documentList as $key=>$list )
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>{{ ++$key }}</td>
                                            <td hidden class="id">{{ $list->id }}</td>
                                            <td hidden class="avatar">{{ $list->upload }}</td>
                                            <td>{{ $list->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ $list->link_url }}" class="btn btn-sm bg-danger-light" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light document_delete" data-bs-toggle="modal" data-bs-target="#documentUser">
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

    {{-- model document delete --}}
    <div class="modal custom-modal fade" id="documentUser" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Document</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('document/delete') }}" method="POST">
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
        $(document).on('click','.document_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("fileUpload").addEventListener("change", handleFileSelect);
        });

        function handleFileSelect(event) {
            document.getElementById("submitBtn").click();
        }
    </script>
    @endsection

@endsection
