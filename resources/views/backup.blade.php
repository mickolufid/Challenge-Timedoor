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