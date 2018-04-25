function likeEvent(id){
  $.ajax({
     type:'PUT',
     headers: {
       Accept: "text/plain; charset=utf-8",
       "Content-Type": "text/plain; charset=utf-8"
     },
     url: '/api/event/' + id,
     data:'_token = {{ echo csrf_token() }}',
     success:function(data){
      console.log(data);
      document.getElementById('like-btn-' + id).disabled = true;
      document.getElementById('like-text-' + id).innerHTML = data;
     }
  });
}
