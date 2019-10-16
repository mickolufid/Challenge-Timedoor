<form action="" method="post" enctype="multipart/form-data" id="fm">
    {{csrf_field()}}
	<input type="hidden" name="id" id="idMessage" value="{{ old('id') ? old('id') : 0 }}">
	<input type="hidden" name="user_id" id="idUser" value="{{ Auth::user() ? Auth::user()->id : 0 }}">
    
	<div class="form-group">
      <label>Name</label>
      <input type="text" class="form-control" name="name" id="name"
        value="{{Auth::user() ? Auth::user()->nama : old('name')}}">
      @error('name')
      <p class="text-danger">{{$message}}</p>
      @enderror
    </div>
    <div class="form-group">
      <label>Title</label>
      <input type="text" class="form-control" name="title" value="{{old('title')}}" id="title">
      @error('title')
      <p class="text-danger">{{$message}}</p>
      @enderror
    </div>
    <div class="form-group">
      <label>Body</label>
      <textarea rows="5" class="form-control" name="body" id="body">{{old('body')}}</textarea>
      @error('body')
      <p class="text-danger">{{$message}}</p>
      @enderror
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
      @error('image')
      <p class="text-danger">{{$message}}</p>
      @enderror
    </div>
    @if(!Auth::user())
    <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" name="password">
      @error('password')
      <p class="text-danger">{{$message}}</p>
      @enderror
    </div>
    @endif
    <div class="text-center mt-30 mb-30">
      <button class="btn btn-primary" type="submit" id="submit">{{ old('id') && old('id') != 0 ? 'UPDATE' : 'SAVE' }}</button>
	  <button class="btn btn-info" type="button" onclick="location.reload()">Reset</button>
    </div>
  </form>