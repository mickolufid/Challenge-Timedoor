@extends('layouts.primary')

@section('title', 'Timedoor Challenge - Level 8')

@section('content')
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 bg-white p-30 box">
        <div class="text-center">
          <h1 class="text-green mb-30"><b>Level 8 Challenge</b></h1>
        </div>

        @include('message.create')

        <hr>
        @include('message.list')

        {{-- <div class="text-center mt-30">
                    <nav>
                        {{ $messages->links() }}
        </nav>
      </div> --}}
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

@endsection

@section('script')
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
    $(".buttonEdit").on("click",function(e){
        e.preventDefault();        
        const _id = $(this).attr("data-id");
        let image;         
        let password = $(`.formPassword${_id}`).val();

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
                  let queryString = "wrongPassword=false"
                  let pageUrl = '?' + queryString;
                  window.history.pushState('', '', pageUrl);  
                  $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", false);                      
                }else{                
                  let queryString = "wrongPassword=true"
                  let pageUrl = '?' + queryString;
                  window.history.pushState('', '', pageUrl);                                         
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
          console.log(_id)
          let urlString = window.location.href;
          let url = new URL(urlString);                                         
          
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
                  let queryString = "wrongPassword=false"
                  let pageUrl = '?' + queryString;
                  window.history.pushState('', '', pageUrl);                                                      
                  $(".wrong-password").addClass("text-success") 
                  $(".wrong-password").removeClass("text-danger") 
                  $(".wrong-password").html("password benar silahkan lanjut edit");
                  $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", false);   
                }else{                    
                  let queryString = "wrongPassword=false&wrongPasswordModal=true"
                  let pageUrl = '?' + queryString;
                  window.history.pushState('', '', pageUrl);
                  $(".wrong-password").addClass("text-danger") 
                  $(".wrong-password").removeClass("text-success") 
                  $(".wrong-password").html("wrong password input dibawah");
                  $(`#formModal${_id} :input`).not("[name='password']").prop("disabled", true);
                  $(`.text-error${_id}`).show();                                 
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
            url: "{{route('editMessage')}}",
            cache: false,               
            contentType: false,
            processData: false,
            type: "POST",
            data: formData,
            success: function(data) {            
                  
                if(!data.errorValidate){  
                  let queryString = "wrongPassword=false&wrongPasswordModal=false&errorValidate=false"
                  let pageUrl = '?' + queryString;
                  window.history.pushState('', '', pageUrl);    
                  if(url.searchParams.get("errorValidate") ==  "false"){            
            window.location.href = "/"
            
          } 
                }else{  
                  let queryString = "wrongPassword=false&wrongPasswordModal=false&errorValidate=true"
                  let pageUrl = '?' + queryString;
                  window.history.pushState('', '', pageUrl);                               
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
            url: "{{route('editMessage')}}",
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

<script>
  $(document).ready(function(){
    $(".formPassword").on("keyup",function(e){
      let _id = $(this).attr("data-id");
      let password = $(this).val();
      let btnDelete = $(this).parent().closest(".post").find(`.btnDelete${_id}`);

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
      let password = $(`.formPassword${_id}`).val();

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
            url: "{{route('deleteMessage')}}",
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
@endsection