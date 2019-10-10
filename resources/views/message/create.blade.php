<form action="" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="form-group">
      <label>Name</label>
      <input type="text" class="form-control" name="name"
        value="{{Auth::user() ? Auth::user()->nama : old('name')}}">
      @error('name')
      <p class="text-danger">{{$message}}</p>
      @enderror
    </div>
    <div class="form-group">
      <label>Title</label>
      <input type="text" class="form-control" name="title" value={{old('title')}}>
      @error('title')
      <p class="text-danger">{{$message}}</p>
      @enderror
    </div>
    <div class="form-group">
      <label>Body</label>
      <textarea rows="5" class="form-control" name="body">{{old('body')}}</textarea>
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
      <input type="password" class="form-control" name="password" value={{old('password')}}>
      @error('password')
      <p class="text-danger">{{$message}}</p>
      @enderror
    </div>
    @endif
    <div class="text-center mt-30 mb-30">
      <button class="btn btn-primary" type="submit">Submit</button>
    </div>
  </form>