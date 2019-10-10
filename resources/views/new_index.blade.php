<html>

<head>
    <title>Timedoor Challenge - Level 8</title>
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
                        <li><a href="/login">Login</a></li>
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
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" maxlength="16" minlength="3"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea rows="5" class="form-control" name="body" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Choose image from your computer :</label>
                                <div class="input-group">
                                    <input type="text" class="form-control upload-form" value="No file chosen" readonly
                                        required>
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            <i class="fa fa-folder-open"></i>&nbsp;Browse <input type="file"
                                                name="image" multiple required>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="text-center mt-30 mb-30">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                        <hr>
                        <div class="post">
                            @foreach ($post as $post)

                            <div class="clearfix">
                                <div class="pull-left">
                                    <h2 class="mb-5 text-green"><b>{{ $post->title }}</b></h2>
                                </div>
                                <div class="pull-right text-right">
                                    <p class="text-lgray">{{ $date }}<br /><span class="small">{{ $post->time }}</span>
                                    </p>
                                </div>
                            </div>
                            <h4 class="mb-20">{{ $post->name }}<span class="text-id">-</span></h4>
                            {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed laoreet, risus nec suscipit luctus, tortor nibh scelerisque est, nec suscipit justo odio id arcu. Nulla nec sagittis ante, non luctus nulla. Sed imperdiet ullamcorper tortor, ac vulputate mauris. In pulvinar metus eget imperdiet ullamcorper. Vivamus a dolor tempor diam sollicitudin interdum.</p> --}}
                            <p>{{ $post->body }}</p>
                            <div class="img-box my-10">
                                <img class="img-responsive img-post" src="{{ $image }}" alt="image">
                            </div>
                            <form class="form-inline mt-50">
                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="inputPassword2" class="sr-only">Password</label>
                                    <input type="password" class="form-control" id="inputPassword2"
                                        placeholder="Password">
                                </div>
                                <a type="submit" class="btn btn-default mb-2" data-toggle="modal"
                                    data-target="#editModal"><i class="fa fa-pencil p-3"></i></a>
                                <a type="submit" class="btn btn-danger mb-2" data-toggle="modal"
                                    data-target="#deleteModal"><i class="fa fa-trash p-3"></i></a>
                            </form>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="Yutaka Tokunaga">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" value="Here is your title">
                        <p class="small text-danger mt-5">*Your title must be 3 to 16 characters long</p>
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea rows="5"
                            class="form-control">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed laoreet, risus nec suscipit luctus, tortor nibh scelerisque est, nec suscipit justo odio id arcu. Nulla nec sagittis ante, non luctus nulla. Sed imperdiet ullamcorper tortor, ac vulputate mauris. In pulvinar metus eget imperdiet ullamcorper. Vivamus a dolor tempor diam sollicitudin interdum.</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <img class="img-responsive" alt="" src="https://via.placeholder.com/500x500">
                        </div>
                        <div class="col-md-8 pl-0">
                            <label>Choose image from your computer :</label>
                            <div class="input-group">
                                <input type="text" class="form-control upload-form" value="No file chosen" readonly>
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        <i class="fa fa-folder-open"></i>&nbsp;Browse <input type="file" name="image"
                                            multiple>
                                    </span>
                                </span>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">Delete image
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
                </div>
                <div class="modal-body pad-20">
                    <p>Are you sure want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
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
    <script>
        $(document).ready( function() {
          $(".button-edit").on("click",function(e){
              e.preventDefault();
              
              const _id = $(this).attr("data-id");
              let image;          
          
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
              formData.append('_token', 'zYyOBbgipKImLDRZlxw409cl6y2nDoXjGFJ8hYP4');
                 
                $.ajax({
                  url: "http://127.0.0.1:8000/edit_post",
                  cache: false,   
                  contentType: false,
                  processData: false,
                  type: "POST",
                  data: formData,
                  success: function(data) {
                      if(!data.error){
                        $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", false);   
                        window.location.reload();
                      }else{
                        $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", true);
                        $(".wrong-password").html("wrong input password dibawah");
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
    <script>
        $(document).ready(function(){
          $(".password-delete").on("keyup",function(e){
            let _id = $(this).attr("data-id");
            let password = $(this).val();
            let btnDelete = $(this).parent().closest(".post").find(`.btn-delete${_id}`);
    
            if(e.keyCode === 13){
    
              $.ajax({
                  url: "http://127.0.0.1:8000/cek_password",
                  cache: false,                 
                  type: "POST",
                  data: {
                    _token: "zYyOBbgipKImLDRZlxw409cl6y2nDoXjGFJ8hYP4",
                    id: _id,
                    password: password
                  },
                  success: function(data) {
                    if(data.error){
                      btnDelete.addClass("disabled");
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
                  url: "http://127.0.0.1:8000/cek_password",
                  cache: false,                 
                  type: "POST",
                  data: {
                    _token: "zYyOBbgipKImLDRZlxw409cl6y2nDoXjGFJ8hYP4",
                    id: _id,
                    password: password
                  },
                  success: function(data) {
                      if(data.error){
                        e.preventDefault();                   
                        _this.addClass("disabled");
                        $("#deleteModal").modal("hide");
                        $(`.text-error${_id}`).show();
                      }else{
                        $("#deleteModal").modal("show");
                      }                                                                      
                    },
                  error: function(error){
                    console.log(error);
                  }  
              })                   
              //  confirm modal delete
              $(".btn-modal-delete").on("click",function(){
                $.ajax({
                  url: "http://127.0.0.1:8000/delete_post",
                  cache: false,                 
                  type: "POST",
                  data: {
                    _token: "zYyOBbgipKImLDRZlxw409cl6y2nDoXjGFJ8hYP4",
                    id: _id,
                  },
                  success: function(data) {
                    if(!data.error){
                      window.location.reload();
                    }else{
                      alert(data);
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