<html>

<head>
  <title>Timedoor Challenge - Level 8</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/tmdrPreset.css">
  <!-- CSS End -->
  <!-- Javascript -->
  <script type="text/javascript" src="assets/js/jquery.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <!-- Javascript End -->
</head>

<body class="bg-lgray">
  <header>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <h2 class="font16 text-green mt-15"><b>Timedoor 30 Challenge Programmer</b></h2>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            @if(Auth::user())
            <li><a href="/logout">Logout</a></li>
            @else
            <li><a href="/login">Login</a></li>
            @endif
            <li><a href="/register">Register</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </header>
  <main>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 bg-white p-30 box">
            <div class="text-center">
              <h1 class="text-green mb-30"><b>Level 8 Challenge</b></h1>
            </div>
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
            <hr>
            <div class="post">
              @foreach ($posts as $post)
              <div class="clearfix">
                <div class="pull-left">
                  <h2 class="mb-5 text-green"><b>{{$post->title}}</b></h2>
                </div>
                <div class="pull-right text-right">
                  <p class="text-lgray">{{$date}}<br /><span class="small">{{$post->time}}</span></p>
                </div>
              </div>
              <h4 class="mb-20">{{$post->name}} {{$post->id_akun ? "[id:". $post->id_akun."]" : null}}<span
                  class="text-id">-</span></h4>

              <p>{{$post->body}}</p>
              <div class="img-box my-10">
                <img class="img-responsive img-post"
                  src="{{strlen($post->image) > 0 ? Crypt::decryptString($post->image) : null}}" alt="image">
              </div>

              @if(Auth::user() && Auth::user()->id === $post->id_akun)
              <input data-id="{{@$post->id}}" type="hidden" class="form-control password-delete p-del{{@$post->id}}"
                placeholder="Password" value="{{$post->password}}">
              <a type="submit" class="btn btn-default mb-2 button-edit" data-toggle="modal"
                data-target="#editModal{{@$post->id}}" data-id="{{@$post->id}}"><i class="fa fa-pencil p-3"></i></a>
              <a data-toggle="modal" data-target="#deleteModal" class="btn btn-danger mb-2 btn-delete{{@$post->id}}"
                data-id="{{@$post->id}}"><i class="fa fa-trash p-3"></i></a>
              @elseif(Auth::user() && $post->id_akun === NULL)
              <div style="display:none;" class="form-group mx-sm-3 mb-2">
                <label class="sr-only">Password</label>
                <input data-id="{{@$post->id}}" type="password" class="form-control password-delete p-del{{@$post->id}}"
                  placeholder="Passwords">
                <p style="display:none;" class="text-error{{@$post->id}} small text-danger">Wrong input
                  password dibawah
                </p>
              </div>

              @elseif(!Auth::user() && $post->id_akun === NULL)
              <div class="form-group mx-sm-3 mb-2">
                <label class="sr-only">Password</label>
                <input data-id="{{@$post->id}}" type="password" class="form-control password-delete p-del{{@$post->id}}"
                  placeholder="Password">
                <p style="display:none;" class="text-error{{@$post->id}} small text-danger">Wrong input
                  password dibawah
                </p>
              </div>
              <a type="submit" class="btn btn-default mb-2 button-edit" data-toggle="modal"
                data-target="#editModal{{@$post->id}}" data-id="{{@$post->id}}"><i class="fa fa-pencil p-3"></i></a>
              <a data-toggle="modal" data-target="#deleteModal" class="btn btn-danger mb-2 btn-delete{{@$post->id}}"
                data-id="{{@$post->id}}"><i class="fa fa-trash p-3"></i></a>
              @endif

              <div class="modal fade" id="editModal{{@$post->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span
                          aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post" enctype="multipart/form-data" id="formModal{{$post->id}}">
                        <div class="form-group">
                          <label>Name</label>
                          <input id="modalName{{$post->id}}" type="text" class="form-control" value="{{$post->name}}"
                            name="name">
                          <p class="text-danger name-error"></p>
                        </div>
                        <div class="form-group">
                          <label>Title</label>
                          <input type="text" id="modalTitle{{$post->id}}" class="form-control" value="{{$post->title}}"
                            name="title">
                          <p class="text-danger title-error"></p>
                        </div>
                        <div class="form-group">
                          <label>Body</label>
                          <textarea id="modalBody{{$post->id}}" rows="5" name="body"
                            class="form-control">{{$post->body}}</textarea>
                          <p class="text-danger body-error"></p>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-4">
                            <img class="img-responsive modal-edit-img{{$post->id}}" alt=""
                              src="{{strlen($post->image) ? Crypt::decryptString($post->image) : null}}">
                          </div>
                          <div class="col-md-8 pl-0">
                            <label>Choose image from your computer :</label>
                            <div class="input-group">
                              <input type="text" class="form-control upload-form" value="Choose Image" name="image"
                                readonly>
                              <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                  <i class="fa fa-folder-open"></i>&nbsp;Browse <input id="imageModal{{$post->id}}"
                                    type="file" name="image" multiple>
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
                        @if(Auth::user() && Auth::user()->id !== $post->id_akun)
                        <div class="form-group">
                          <label>Password</label>
                          <input id="modalPassword{{$post->id}}" name="password" type="password" class="form-control">
                          <p class="wrong-password small text-danger mt-5"></p>
                        </div>
                        @elseif(!Auth::user() || Auth::user()->id !== $post->id_akun)
                        <label>Password</label>
                        <input id="modalPassword{{$post->id}}" name="password" type="password" class="form-control">
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

            </div>

            <div class="text-center mt-30">
              <nav>
                <ul class="pagination">
                  <li><a href="#">&laquo;</a></li>
                  <li><a href="#">&lsaquo;</a></li>
                  <li class="active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">&rsaquo;</a></li>
                  <li><a href="#">&raquo;</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <p class="font12">Copyright &copy; <script>
        document.write(new Date().getFullYear());
      </script> by <a href="https://timedoor.net" class="text-green">PT. TIMEDOOR INDONESIA</a> </p>
  </footer>


  </div>
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
              class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
        </div>
        <div class="modal-body pad-20">
          <p>Are you sure want to delete this item?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger btn-modal-delete">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    // INPUT TYPE FILE
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
      });

      $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
            input.val(log);
          } else {
            if( log ) alert(log);
          }
        });
      });
  </script>
  @if(!Auth::user())
  <script>
    $(document).ready( function() {
      $(".button-edit").on("click",function(e){
          e.preventDefault();        
          const _id = $(this).attr("data-id");
          let image;         
          let password = $(`.p-del${_id}`).val();

          $.ajax({
              url: "{{route('checkPassword')}}",
              cache: false,                 
              type: "POST",
              data: {
                _token: "{{csrf_token()}}",
                id: _id,
                password: password
              },
              success: function(data) {
                  if(!data.error){               
                    $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", false);                      
                  }else{                          
                    localStorage.setItem("errorPassword","wrong password");              
                    $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", true);
                    $(`.text-error${_id}`).show();
                    $(".btn-modal-delete").removeClass("disabled");                  
                  }                                                                      
                },
              error: function(error){
                console.log(error);
              }  
          })     
          $(".save-edit").on("click",function(){ 
            var counter = 0;                     
            $.ajax({
              url: "{{route('checkPassword')}}",
              cache: false,                 
              type: "POST",                                        
              data: {
                _token: "{{csrf_token()}}",
                id: _id,
                password: $(`#modalPassword${_id}`).val()
              },
              success: function(data) {
                  if(!data.error){  
                    counter++;                                                        
                    $(".wrong-password").addClass("text-success") 
                    $(".wrong-password").removeClass("text-danger") 
                    $(".wrong-password").html("password benar silahkan lanjut edit");
                    $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", false);   
                  }else{                    
                    localStorage.setItem("errorPassword","wrong password");
                    $(".wrong-password").addClass("text-danger") 
                    $(".wrong-password").removeClass("text-success") 
                    $(".wrong-password").html("wrong password input dibawah");
                    $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", true);
                    $(`.text-error${_id}`).show();                                 
                    return;
                  }                                                                      
                },
              error: function(error){
                console.log(error);
              }  
          })   
                    
          let img = $(`#imageModal${_id}`)[0].files[0];
          
          if(!img || img === undefined){
            img = $(`.modal-edit-img${_id}`).attr('src');            
          }   
          let formData = new FormData();
          formData.append('id',_id)
          formData.append('name', $(`#modalName${_id}`).val());
          formData.append('title', $(`#modalTitle${_id}`).val());
          formData.append('body', $(`#modalBody${_id}`).val());
          formData.append('image', img);
          formData.append('delete_img',$(".check-delete-img:checked").val());
          formData.append('password',$("#modalPassword"+_id).val());
          formData.append('_token', '{{csrf_token()}}');
             
            $.ajax({
              url: "{{route('editPost')}}",
              cache: false,   
              contentType: false,
              processData: false,
              type: "POST",
              data: formData,
              success: function(data) {                
                  if(!localStorage.getItem("errorPassword") && !data.errorValidate){  
                    counter++;
                    console.log("Password benar dan validasi benar")                      
                  }else{  
                    counter--;                                         
                    localStorage.setItem('errorValidate', data.errorValidate);
                    if(data.errorValidate && data.errorValidate.name){
                        $( '.name-error' ).html( data.errorValidate.name[0] );
                    }
                    if(data.errorValidate && data.errorValidate.body){
                        $( '.body-error' ).html( data.errorValidate.body[0] );
                    }
                    if(data.errorValidate && data.errorValidate.title ){
                        $( '.title-error' ).html( data.errorValidate.title[0] );
                    }                    
                  }                                                                         
                },
              error: function(error){
                console.log(error);
              }  
              })                           
          })  
          })

        })
      
  </script>
  @else
  <script>
    $(document).ready( function() {
      
      $(".button-edit").on("click",function(e){
          e.preventDefault();        
          const _id = $(this).attr("data-id");
          let image;         
          let password = $(`.p-del${_id}`).val();
          
          $(".save-edit").on("click",function(){                          
                    
          let img = $(`#imageModal${_id}`)[0].files[0];
          
          if(!img || img === undefined){
            img = $(`.modal-edit-img${_id}`).attr('src');            
          }   
          let formData = new FormData();
          formData.append('id',_id)
          formData.append('name', $(`#modalName${_id}`).val());
          formData.append('title', $(`#modalTitle${_id}`).val());
          formData.append('body', $(`#modalBody${_id}`).val());
          formData.append('image', img);
          formData.append('delete_img',$(".check-delete-img:checked").val());
          formData.append('password',$("#modalPassword"+_id).val());
          formData.append('_token', '{{csrf_token()}}');
             
            $.ajax({
              url: "{{route('editPost')}}",
              cache: false,   
              contentType: false,
              processData: false,
              type: "POST",
              data: formData,
              success: function(data) {
                  if(!data.error && !data.errorValidate){
                           
                      window.location.reload();  
                      $(".wrong-password").addClass("text-success") 
                      $(".wrong-password").removeClass("text-danger")                     
                      $(".wrong-password").html("Password benar silahkan lanjut edit");           
                    
                  }else{                                        
                    if(data.errorValidate.name){
                        $( '.name-error' ).html( data.errorValidate.name[0] );
                    }
                    if(data.errorValidate.body){
                        $( '.body-error' ).html( data.errorValidate.body[0] );
                    }
                    if(data.errorValidate.title){
                        $( '.title-error' ).html( data.errorValidate.title[0] );
                    }
                  }                                                                         
                },
              error: function(error){
                console.log(error);
              }  
              })
          })                        
          })
        })
      
  </script>
  @endif

  {{-- @if(Session::has('errors'))
  <script>
  $(document).ready(function(){
      $('.modal.fade').modal({show: false});
  })
  </script>
  @endif --}}

  <script>
    $(document).ready(function(){
      $(".password-delete").on("keyup",function(e){
        let _id = $(this).attr("data-id");
        let password = $(this).val();
        let btnDelete = $(this).parent().closest(".post").find(`.btn-delete${_id}`);

        if(e.keyCode === 13){
          $.ajax({
              url: "{{route('checkPassword')}}",
              cache: false,                 
              type: "POST",
              data: {
                _token: "{{csrf_token()}}",
                id: _id,
                password: password
              },
              success: function(data) {
                if(data.error){              
                  // btnDelete.addClass("disabled");
                  $(`.text-error${_id}`).show();         
                }else{
                  btnDelete.removeClass("disabled");
                  $(`.text-error${_id}`).hide();
                }
                                                                                       
              },
              error: function(error){
                console.log(error);
              }  
              })                    
        }
      })
      // cek password melalui tombol delete
      $(".btn-danger").on("click",function(e){
        let _this = $(this);
        let _id = $(this).attr("data-id");
        let password = $(`.p-del${_id}`).val();

          $.ajax({
              url: "{{route('checkPassword')}}",
              cache: false,                 
              type: "POST",
              data: {
                _token: "{{csrf_token()}}",
                id: _id,
                password: password
              },
              success: function(data) {
                  if(data.error){
                    // e.preventDefault();                   
                    // _this.addClass("disabled");
                    $(".btn-modal-delete").addClass("disabled");
                    console.log(data.error)
                    // $("#deleteModal").modal("hide");
                    $(`.text-error${_id}`).show();
                  }else{
                    $(".btn-modal-delete").removeClass("disabled");
                    //$("#deleteModal").modal("show");
                  }                                                                      
                },
              error: function(error){
                console.log(error);
              }  
          })                   
          //  confirm modal delete
          $(".btn-modal-delete").on("click",function(){
            if($(this).hasClass("disabled")) return;
            $.ajax({
              url: "{{route('deletePost')}}",
              cache: false,                 
              type: "POST",
              data: {
                _token: "{{csrf_token()}}",
                id: _id,
              },
              success: function(data) {
                if(!data.error){
                  window.location.reload();
                  console.log(data)
                }else{
                  console.log(data);
                }
                },
              error: function(error){
                console.log(error);
              }  
            })           
          })
      })
    });
  </script>

</body>

</html>