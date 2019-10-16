@foreach ($messages as $message)
<div class="post">
  <div class="clearfix">
    <div class="pull-left">
      <h2 class="mb-5 text-green"><b>{{ $message->title }}</b></h2>
    </div>
    <div class="pull-right text-right">
      <p class="text-lgray">
        {{ $message->date }}<br />
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
      src="{{strlen($message->image) > 0 ? asset('storage/images/messages/' . $message->image) : null}}" alt="image">
  </div>

  @guest
  @if (! $message->id_akun)

  <div class="form-group mx-sm-3 mb-2">
    <label class="sr-only">Password</label>
    <input type="password" name="password" class="form-control formPassword{{$message->id}}">
  </div>
  <button type="button" class="btn btn-default" onclick="editMessage( {{ $message->id }} )">
    <i class="fa fa-pencil p-3"></i>
  </button>
  <button type="button" class="btn btn-danger btnDelete mb-2" onclick="deleteMessage( {{ $message->id }} )">
    <i class="fa fa-trash p-3"></i>
  </button>

  @endif
  @else
  @if ($message->id_akun && $message->id_akun === auth()->user()->id)
  <button type="button" data-id="{{$message->id}}" class="btn btn-default btnEdit mb-2" onclick="editMessage( {{ $message->id }} )">
    <i class="fa fa-pencil p-3"></i>
  </button>
  <button type="button"  class="btn btn-danger mb-2 btnDelete" onclick="deleteMessage( {{ $message->id }} )">
    <i class="fa fa-trash p-3"></i>
  </button>
  {{-- <form class="form-inline mt-50" method="POST">
    @csrf
  </form> --}}
  @endif
  @endguest
</div>

@endforeach