@extends('layouts.admin.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- /.col-xs-12 -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h1 class="font-18 m-0">Timedoor Challenge - Level 9</h1>
                    </div>
                    <div class="box-body">
                        <div class="bordered-box mb-20">
                            <form class="form" role="form" method="POST">
                                @csrf
                                <table class="table table-no-border mb-0">
                                    <tbody>
                                        <tr>
                                            <td width="80"><b>Title</b></td>
                                            <td>
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="title">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Body</b></td>
                                            <td>
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="message">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-search">
                                    <tbody>
                                        <tr>
                                            <td width="80"><b>Image</b></td>
                                            <td width="60">
                                                <label class="radio-inline">
                                                    <input type="radio" name="imageOption" id="inlineRadio1" value="with"> with
                                                </label>
                                            </td>
                                            <td width="80">
                                                <label class="radio-inline">
                                                    <input type="radio" name="imageOption" id="inlineRadio2" value="without"> without
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="imageOption" id="inlineRadio3" value="unspecified" checked> unspecified
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="80"><b>Status</b></td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="statusOption" id="inlineRadio1" value="on"> on
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="statusOption" id="inlineRadio2" value="delete"> delete
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="statusOption" id="inlineRadio3" value="unspecified" checked> unspecified
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><button class="btn btn-default mt-10" formaction="{{ route('dashboard') }}"><i class="fa fa-search"></i> Search</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        @if (! $messages->isEmpty())
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAllRecord"></th>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th width="200">Image</th>
                                        <th>Date</th>
                                        <th width="50">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <form action="{{ route('dashboard.deleteMultiply') }}" method="POST" id="deleteMultiplyForm">
                                    @csrf
                                    @foreach ($messages as $bulletin)
                                        @if ($bulletin->trashed())
                                            <tr class="bg-gray-light">
                                                <td>&nbsp;</td>
                                                <td>{{ $bulletin->id }}</td>
                                                <td>{{ $bulletin->title }}</td>
                                                <td>{{ $bulletin->message }}</td>
                                                <td>  @if (empty($bulletin->image))
                                                        <img class="img-prev" src="{{ asset('storage/images/messages/default.png') }}">
                                                    @else
                                                        <img class="img-prev" src="{{ asset('storage/images/messages/' . $bulletin->image) }}">
                                                        <input type="hidden" name="id" value="{{ $bulletin->id }}">
                                                        <button class="btn btn-danger ml-10 btn-img btn-delete-image" rel="tooltip" title="Delete Image"><i class="fa fa-trash"></i></button>
                                                    @endif</td>
                                                <td>{{ $bulletin->created_at->format('Y/m/d') }}<br><span class="small">{{ $bulletin->created_at->format('H:i:s') }}</span></td>
                                                <td>
                                                    <input type="hidden" name="id" value="{{ $bulletin->id }}">
                                                    <button class="btn btn-default btn-restore" rel="tooltip" title="Recover"><i class="fa fa-repeat"></i></button>
                                                </td>
                                            </tr>
                                        @else 
                                            <tr>
                                                <td><input type="checkbox" value="{{ $bulletin->id }}" name="ids[]"></td>
                                                <td>{{ $bulletin->id }}</td>
                                                <td>{{ $bulletin->title }}</td>
                                                <td>{!! nl2br($bulletin->message) !!}</td>
                                                <td>
                                                    @if (empty($bulletin->image))
                                                        <img class="img-prev" src="{{ asset('storage/images/messages/default.jpg') }}">
                                                    @else
                                                        <img class="img-prev" src="{{ asset('storage/images/messages/' . $bulletin->image) }}">
                                                        <input type="hidden" name="id" value="{{ $bulletin->id }}">
                                                        <button class="btn btn-danger ml-10 btn-img btn-delete-image" rel="tooltip" title="Delete Image"><i class="fa fa-trash"></i></button>
                                                    @endif
                                                </td>
                                                <td>{{ $bulletin->created_at->format('Y/m/d') }}<br><span class="small">{{ $bulletin->created_at->format('H:i:s') }}</span></td>
                                                <td>
                                                    <input type="hidden" name="id" value="{{ $bulletin->id }}">
                                                    <button class="btn btn-danger btn-delete" rel="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </form>
                                </tbody>
                            </table>
                            <a class="btn btn-default mt-5 btn-delete-all" data-toggle="modal" data-target="#deleteMultiplyModal">Delete Checked Items</a>
                                <div class="text-center">
                                {{ $messages->links() }}
                            </div>
                        @else 
                            <p class="text-center h2">No data found</p>
                        @endif
                    </div>
                </div>
            </div><!-- /.col-xs-12 -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
                </div>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to delete this item(s)?</p>
            </div>
            <div class="modal-footer">
                <form id="submitDelete" action="" method="POST">
                    @csrf
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">Delete Image</h4>
                </div>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to delete this image ?</p>
            </div>
            <div class="modal-footer">
                <form id="submitDeleteImage" action="" method="POST">
                    @csrf
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteMultiplyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
                </div>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to delete this item(s)?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger" onclick="event.preventDefault();document.getElementById('deleteMultiplyForm').submit();">Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">Restore Data</h4>
                </div>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to restore this item(s)?</p>
            </div>
            <div class="modal-footer">
                <form id="submitRestore" action="" method="POST">
                    @csrf
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Restore</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // BOOTSTRAP TOOLTIPS
    if ($(window).width() > 767) {
        $(function() {
            $('[rel="tooltip"]').tooltip()
        });
    };

    $(document).ready(function() {
        $(".btn-delete").click(function(e) {
            e.preventDefault();

            var id = $(this).parent().find("input[name='id']").val();

            $('#deleteModal').modal();
            $('#submitDelete').attr('action', '{{ Url("/dashboard/delete") }}/' + id);
        });

        $(".btn-restore").click(function(e) {
            e.preventDefault();

            var id = $(this).parent().find("input[name='id']").val();

            $('#restoreModal').modal();
            $('#submitRestore').attr('action', '{{ Url("/dashboard/restore") }}/' + id);
        });

        $(".btn-delete-image").click(function(e) {
            e.preventDefault();

            var id = $(this).parent().find("input[name='id']").val();

            $('#deleteImageModal').modal();
            $('#submitDeleteImage').attr('action', '{{ Url("/dashboard/delete-image") }}/' + id);
        });

        $("#checkAllRecord").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
</script>
@endsection