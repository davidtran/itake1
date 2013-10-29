function commentRegisterEventSubmit(){
    var CurrentPage = 2;

		$( "#comment-form" ).submit(function( event ) {
		  // alert( "Handler for .submit() called." );
		  event.preventDefault();
		  var datos = $(this).serialize();
       	 $.post(BASE_URL + "/product/postComment", datos, function(data) {
            $( "#comment-form" )[0].reset();
            var _result = $.parseJSON(data);
            if (_result.error_code == 1) {
                $('#comment-container').prepend(utf8_decode(_result.msg.html));
            } else {
                console.log('error')
            }
            
        });

	});
        $( "#commentLoadMore" ).click(function(event) {
          // alert( "Handler for .click() called." )
           event.preventDefault();
           var datos = {product_id: $("#commentLoadMore").attr("product_id"),page:CurrentPage};
            $.get(BASE_URL + "/product/commentLoadMore/", datos, function(data) {
              var _result = $.parseJSON(data);
              if (_result.error_code == 1) {
                  $('#comment-container').append(utf8_decode(_result.msg.html));
                  if(CurrentPage==_result.msg.pageCount)
                  {
                      $( "#commentLoadMore" ).hide('fade');
                  }
                  CurrentPage++;
              } else {
                  console.log('error')
              }
              
               });
        });
        //reply
        $( "a[id^='comment-child-']" ).live( "click", function(event) {
            // alert( "Handler for .click() called." );
            event.stopPropagation();
            $(this).parent().find(".form-comment-child" ).show('fade');
            $(document).live( "click", function() {
                // $(this).find(".form-comment-child" ).hide('fade');
            });
        });
        // del
         $( "a[id^='del-comment-']" ).live( "click", function(event) {
              event.preventDefault();
              var datos = {comment_id:$(this).attr('comment_id')};
              if(confirm("Xoa?")==true){
              $(this).parent().parent().find(".pull-left").hide('fade');
              // $(this).parent().find(".replycomment").hide('fade');
              $.get(BASE_URL + "/product/delComment/", datos, function(data) {
              });
              }
          });
      $( "form[id^='farent-form_']" ).live( "submit", function(event) {
      // alert( "Handler for .submit() called." );
      event.preventDefault();
      var datos = $(this).serialize();
      $('#'+$(this).attr('id')).get(0).reset();

         $.post(BASE_URL + "/product/postComment", datos, function(data) {
            var _result = $.parseJSON(data);
            if (_result.error_code == 1) {
                $('#comment_id_'+_result.msg.parent_id+' #comment-container-parent').prepend(utf8_decode(_result.msg.html));
            } else {
                console.log('error')
            }
            
        });
  });

}