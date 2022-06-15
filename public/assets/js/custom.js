function removeRow(id, path) {
  let check = confirm("Silmək istədiyinizə əminsiniz?");

  if(check) {
    window.location.assign(path+id);
  }
}

$(function(){

  $("#user-activate input").change(function() {

    let status = this.checked ? 1 : 0;
    let conf = confirm("İş statusunu dəyişmək istədiyinizə əminsiniz?");
    let userId = $("#user-activate").attr("data-id");
     
    if(conf) {
      $.ajax({
        url: "/set-status",
        method: "put",
        data: {
          status, 
          id: userId,
          _token: $("#request_csrf").val()
        },
        success: (data)=>{  
          if(data.error===null) {
            if($("#user-activate label").text()=="Online"){
              $("#user-activate label").text("Offline")
            } else {
              $("#user-activate label").text("Online")
            }
          }
        }, 
        error: (err) => {
          console.log(err)
          this.checked = !this.checked
          alert("Sistem xətası")
        }
      })
    } else { 

      this.checked = !this.checked

    }

  })


})