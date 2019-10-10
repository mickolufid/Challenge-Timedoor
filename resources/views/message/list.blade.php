@foreach ($messages as $message)
<div class="post">
  <div class="clearfix">
    <div class="pull-left">
      <h2 class="mb-5 text-green"><b>{{ $message->title }}</b></h2>
    </div>
    <div class="pull-right text-right">
      <p class="text-lgray">
        {{ $date }}<br />
        <span class="small">{{ $message->time}}</span>
      </p>
    </div>
  </div>

  <h4 class="mb-20">
    {{ $message->name ?? 'No Name' }} <span class="text-id">ID - {{ $message->id_akun }}</span>
  </h4>

  <p>{!! nl2br(e($message->body)) !!}</p>

  <div class="img-box my-10">
    <img class="img-responsive img-post"
      src="{{strlen($message->image) > 0 ? Crypt::decryptString($message->image) : null}}" alt="image">
  </div>

  @guest
  @if (! $message->id_akun)

  <div class="form-group mx-sm-3 mb-2">
    <label class="sr-only">Password</label>
    <input type="password" name="password" class="form-control formPassword{{$message->id}}">
  </div>
  <button type="button" data-id="{{$message->id}}" class="btn btn-default buttonEdit
    mb-2" data-toggle="modal" data-target="#editModal{{@$message->id}}">
    <i class="fa fa-pencil p-3"></i>
  </button>
  <button type="button" data-toggle="modal" data-target="#deleteModal" data-id="{{$message->id}}" class="btn btn-danger btnDelete mb-2">
    <i class="fa fa-trash p-3"></i>
  </button>

  @endif
  @else
  @if ($message->id_akun && $message->id_akun === auth()->user()->id)
  <button type="button" data-id="{{$message->id}}" class="btn btn-default btnEdit
  mb-2">
    <i class="fa fa-pencil p-3"></i>
  </button>
  <button type="button" data-toggle="modal" data-target="#deleteModal" data-id="{{$message->id}}" class="btn btn-danger mb-2 btnDelete">
    <i class="fa fa-trash p-3"></i>
  </button>
  {{-- <form class="form-inline mt-50" method="POST">
    @csrf
  </form> --}}
  @endif
  @endguest
</div>
<div class="modal fade" id="editModal{{@$message->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
            class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="formModal{{$message->id}}">
          <div class="form-group">
            <label>Name</label>
            <input id="modalName{{$message->id}}" type="text" class="form-control" value="{{$message->name}}"
              name="name">
            <p class="text-danger name-error"></p>
          </div>
          <div class="form-group">
            <label>Title</label>
            <input type="text" id="modalTitle{{$message->id}}" class="form-control" value="{{$message->title}}"
              name="title">
            <p class="text-danger title-error"></p>
          </div>
          <div class="form-group">
            <label>Body</label>
            <textarea id="modalBody{{$message->id}}" rows="5" name="body"
              class="form-control">{{$message->body}}</textarea>
            <p class="text-danger body-error"></p>
          </div>
          <div class="form-group row">
            <div class="col-md-4">
              <img class="img-responsive modal-edit-img{{$message->id}}" alt=""
                src="{{strlen($message->image) ? Crypt::decryptString($message->image) : null}}">
            </div>
            <div class="col-md-8 pl-0">
              <label>Choose image from your computer :</label>
              <div class="input-group">
                <input type="text" class="form-control upload-form" value="Choose Image" name="image" readonly>
                <span class="input-group-btn">
                  <span class="btn btn-default btn-file">
                    <i class="fa fa-folder-open"></i>&nbsp;Browse <input id="imageModal{{$message->id}}" type="file"
                      name="image" multiple>
                  </span>
                </span>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" class="check-delete-img">Delete image
                </label>
              </div>
            </div>
          </div>
          @if(Auth::user() && Auth::user()->id !== $message->id_akun)
          <div class="form-group">
            <label>Password</label>
            <input id="modalPassword{{$message->id}}" name="password" type="password" class="form-control">
            <p class="wrong-password small text-danger mt-5"></p>
          </div>
          @elseif(!Auth::user() || Auth::user()->id !== $message->id_akun)
          <label>Password</label>
          <input id="modalPassword{{$message->id}}" name="password" type="password" class="form-control">
          <p class="wrong-password small text-danger mt-5"></p>
          @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-edit">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<hr>
@endforeach