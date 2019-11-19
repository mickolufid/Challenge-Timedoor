@extends('layouts.user.layout')

@section('content')

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 bg-white p-30 box">
                <div class="text-center">
                    <h1 class="text-green mb-30"><b>Level 8 Challenge</b></h1>
                </div>
                <form action="{{ route('home.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? null }}">
                    <div class="form-group">
                        <label>Name</label>
                        @guest
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @else
                            <input type="text" name="name" class="form-control" value="{{ old('name') ?? Auth::user()->name }}">
                        @endguest

                        @if ($errors->has('name'))
                            <p class="small text-danger mt-5">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <p class="small text-danger mt-5">{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea rows="5" name="body" class="form-control">{{ old('body') }}</textarea>
                        @if ($errors->has('body'))
                            <p class="small text-danger mt-5">{{ $errors->first('body') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Choose image from your computer :</label>
                        <div class="input-group">
                            <input type="text" class="form-control upload-form" value="No file chosen" readonly>
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    <i class="fa fa-folder-open"></i>&nbsp;Browse <input type="file" name="image" multiple>
                                </span>
                            </span>
                        </div>
                        @if ($errors->has('image'))
                            <p class="small text-danger mt-5">{{ $errors->first('image') }}</p>
                        @endif
                    </div>
                    @guest
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            @if ($errors->has('password'))
                                <p class="small text-danger mt-5">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                    @else
                        <input type="hidden" name="password" class="form-control" value="">
                    @endguest
                    <div class="text-center mt-30 mb-30">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <hr>
                @foreach ($messages as $bulletin)
                <div class="post">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h2 class="mb-5 text-green">{{ $bulletin->title }}</h2>
                        </div>
                        <div class="pull-right text-right">
                            <p class="text-lgray">{{ $bulletin->created_at->format('d/m/Y') }}<br /><span class="small">{{ $bulletin->created_at->format('H:i') }}</span></p>
                        </div>
                    </div>
                    <h4 class="mb-20">
                        {{ empty($bulletin->name) ? 'No name' : $bulletin->name }} 
                        @if(!is_null($bulletin->user_id))
                           <span class="text-id">[ID:{{ $bulletin->id_account }}]</span>
                        @endif
                    </h4>
                    <p>{!! nl2br(e($bulletin->body)) !!}</p>
                    <div class="img-box my-10">
                        @if (empty($bulletin->image))
                            <img class="img-responsive img-post" src="{{ asset('storage/images/messages/default.png') }}" alt="image">
                        @else
                            <img class="img-responsive img-post" src="{{ asset('storage/images/messages/' . $bulletin->image) }}" alt="image">
                        @endif
                    </div>
                    @guest
                        @if(is_null($bulletin->id_account))
                            <form action="" class="form-inline mt-50" method="post">
                                @csrf
                                <div class="form-group mx-sm-3 mb-2">
                                    <label class="sr-only">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <input type="hidden" name="id" value="{{ $bulletin->id }}">
                                <button type="submit" class="btn btn-default mb-2" formaction="{{ route('home.edit') }}"><i class="fa fa-pencil p-3"></i></button>
                                <button type="submit" class="btn btn-danger mb-2" formaction="{{ route('home.delete') }}"><i class="fa fa-trash p-3"></i></button>
                            </form>
                        @endif
                    @else
                        @if ($bulletin->id_account === Auth::user()->id)
                            <form action="" class="form-inline mt-50" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="id" value="{{ $bulletin->id }}">
                                <input type="hidden" name="password" value="">
                                <button type="submit" class="btn btn-default mb-2" formaction="{{ route('home.edit') }}"><i class="fa fa-pencil p-3"></i></button>
                                <button type="submit" class="btn btn-danger mb-2" formaction="{{ route('home.delete') }}"><i class="fa fa-trash p-3"></i></button>
                            </form>
                        @endif
                    @endguest
                </div>
                @endforeach
                <div class="text-center mt-30">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>
            </div>
            <form action="{{ route('home.update', session('record.id') ?? 0) }}" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? session('record.name') }}">
                        @if ($errors->has('name'))
                            <p class="small text-danger mt-5">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ?? session('record.title') }}">
                        @if ($errors->has('title'))
                            <p class="small text-danger mt-5">{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea rows="5" id="body" name="body" class="form-control">{{ old('body') ?? session('record.body') }}</textarea>
                        @if ($errors->has('body'))
                            <p class="small text-danger mt-5">{{ $errors->first('body') }}</p>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            @if (empty(session('record.image')))
                                <img class="img-responsive" src="{{ asset('storage/images/messages/default.jpg') }}" alt="image">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/images/messages/' . session('record.image')) }}" alt="image">
                            @endif
                        </div>
                        <div class="col-md-8 pl-0">
                            <label>Choose image from your computer :</label>
                            <div class="input-group">
                                <input type="text" class="form-control upload-form" value="No file chosen" readonly>
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        <i class="fa fa-folder-open"></i>&nbsp;Browse <input type="file" id="newImage" name="image" multiple>
                                    </span>
                                </span>
                            </div>
                            @if ($errors->has('image'))
                                <p class="small text-danger mt-5">{{ $errors->first('image') }}</p>
                            @endif
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="deleteImage">Delete image
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="password" value="{{ old('password') }}">
                    <input type="hidden" name="user_id" value="{{ old('user_id') }}">
                    
                    <button type="submit" id="edit_button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
            </div>
            <form action="{{ route('home.destroy', session('record.id') ?? 0) }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ session('record.name') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" value="{{ session('record.title') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea rows="5" class="form-control" readonly>{{ session('record.body') }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            @if (empty(session('record.image')))
                                <img class="img-responsive" src="{{ asset('storage/images/messages/default.jpg') }}" alt="image">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/images/messages/' . session('record.image')) }}" alt="image">
                            @endif
                        </div>
                    </div>
                    @if (session('passwordField'))
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <p class="text-center">Are you sure want to delete this item?</p>
                    <input type="hidden" name="password" value="{{ old('password') }}">
                    <input type="hidden" name="user_id" value="{{ old('user_id') }}">
                    
                    <button type="submit" class="btn btn-danger btn-check btn-wrong-modal">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editWrongModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>
            </div>
            <form action="{{ route('home.edit') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ session('record.name') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" value="{{ session('record.title') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea rows="5" class="form-control" readonly>{{ session('record.body') }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            @if (empty(session('record.image')))
                                <img class="img-responsive" src="{{ asset('storage/images/messages/default.jpg') }}" alt="image">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/images/messages/' . session('record.image')) }}" alt="image">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="small text-danger mt-5">{{ session('errorMessage') }}</p>
                    </div>
                    @if (session('passwordField'))
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    @endif
                </div>
                <input type="hidden" name="id" value="{{ session('record.id') }}">
                <input type="hidden" name="user_id" value="{{ session('record.user_id') }}">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-check btn-wrong-modal">Edit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteWrongModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete</h4>
            </div>
            <form action="{{ route('home.delete') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ session('record.name') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" value="{{ session('record.title') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea rows="5" class="form-control" readonly>{{ session('record.body') }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            @if (empty(session('record.image')))
                                <img class="img-responsive" src="{{ asset('storage/images/messages/default.jpg') }}" alt="image">
                            @else
                                <img class="img-responsive" src="{{ asset('storage/images/messages/' . session('record.image')) }}" alt="image">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="small text-danger mt-5">{{ session('errorMessage') }}</p>
                    </div>
                    @if (session('passwordField'))
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    @endif
                </div>
                <input type="hidden" name="id" value="{{ session('record.id') }}">
                <input type="hidden" name="user_id" value="{{ session('record.user_id') }}">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-check btn-wrong-modal">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

@if (session('modal') === 'editWrongModal')
    <script>
        $('#editWrongModal').modal();
    </script>
@elseif (session('modal') === 'deleteWrongModal')
    <script>
        $('#deleteWrongModal').modal();
    </script>
@elseif (session('modal') === 'editModal')
    <script>
        $('#editModal').modal();
    </script>
@elseif (session('modal') === 'deleteModal')
    <script>
        $('#deleteModal').modal();
    </script>
@endif

<script>
    // INPUT TYPE FILE
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready(function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if (input.length) {
                input.val(log);
            } else {}
        });
    });
</script>

@endsection