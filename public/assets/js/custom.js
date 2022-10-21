function removeRow(id, path) {
  let check = confirm("Silmək istədiyinizə əminsiniz?");

  if(check) {
    window.location.assign(path+id);
  }
}

$(function() {

  $.ajax({
    url: "/admin/notification-count",
    method: "get",
    success: (res)=> { 
      $(".notification-toggle span").text(res.data)
    }
  })
 
  setInterval(() => { 
    $.ajax({
      url: "/admin/notification-count",
      method: "get",
      success: (res)=> { 
        $(".notification-toggle span").text(res.data)
      }
    })
    
  }, 20000);

  $(document).on("click", ".notification-toggle", function() {
    if($(".notification-window").hasClass("is-active")) {
      $(".notification-window").removeClass("is-active");

    } else {
      $(".notification-window").addClass("is-active");
      $.ajax({
        url: "/admin/fetch-notifications",
        method: "get",
        success: (res)=> { 
    
                let str = "";
                if(res.data.length>0) {
                  (res.data).forEach((item, index)=>{
                          str += ` <li class="">
                              <p>Yeni müraciət</p>
                              <span>${item.type}</span>
                              <div class="notification-detail-box"> 
                                <button type="button" class="btn btn-info" data-id="${item.id}">OXU</button>
                                <a href="${item.type==="Xidmət üzrə müraciət" ? "/admin/service-appeals" : "/admin/country-appeals" }" onclick="return false">Ətraflı</a> 
                              </div>
                            </li> `;
                  });
                } else {
                  str = `<li style="border: none; margin: 0">Yeni bildiriş yoxdur</li>`
                }
                $(".notification-window ul").html(str);
                 
        }
      });
    }
  });

  $(document).on("click", ".notification-window .notification-detail-box a", function() {
    var id = $(this).prev().attr("data-id");
    var href = $(this).attr("href");
    $.ajax({
      url: "/admin/read-notification/"+id,
      method: "get",
      success: (res)=> {  
        if(res.error==null) {
         window.location.href = href;
        }  else {
          alert(res.error.message)
        }  
      }
    });
    console.log(id)
  });

  $(document).on("click", ".notification-window .btn-info", function() {
    var id = $(this).attr("data-id");
    $.ajax({
      url: "/admin/read-notification/"+id,
      method: "get",
      success: (res)=> {  
        if(res.error==null) {
          alert(res.data.message)
          $.ajax({
            url: "/admin/fetch-notifications",
            method: "get",
            success: (res)=> { 
        
                    let str = "";
                    if(res.data.length>0) {
                      (res.data).forEach((item, index)=>{
                              str += ` <li class="">
                                  <p>Yeni müraciət</p>
                                  <span>${item.type}</span>
                                  <div class="notification-detail-box"> 
                                    <button type="button" class="btn btn-info" data-id="${item.id}">OXU</button>
                                    <a href="${item.type==="Xidmət üzrə müraciət" ? "/admin/service-appeals" : "/admin/country-appeals" }" onclick="return false">Ətraflı</a> 
                                  </div>
                                </li> `;
                      });
                    } else {
                      str = `<li style="border: none; margin: 0">Yeni bildiriş yoxdur</li>`
                    }
                    $(".notification-window ul").html(str);
                     
            }
          });
        }  else {
          alert(res.error.message)
        }  
      }
    });
  })

  $(document).on("click", ".delete-media-file", function() {

    let rowId = $(this).attr("row-id");
    let id = $(this).attr("data-id");
    let path = $(this).attr("data-path");
    let check = confirm("Silmək istədiyinizə əminsiniz?");

    if(check) {
      $.ajax({
        url: "/admin/delete-file/"+id+"/"+path,
        method: "get",
        data: {},
        success: (res)=>{  
          if(res.error===null) {
            $.ajax({
              url: "/admin/get-files/"+rowId+"/1",
              method: "get",
              success: (res)=> { 
                      let str = "";
                      (res.data).forEach((item, index)=>{
                              str += `
                                      <div class="additional-file-item">
                                              <img src="/public/assets/uploads/tour-images/${item.file}" class="table-describe" />
                                              <button type="button" class="btn btn-danger delete-media-file" data-id="${item.id}"
                                              row-id="${id}" data-path="${path}">sil</button> 
                                      </div> 
                              `;
                      })

                      $("#additional-files-box").html(str);
                       
              }
            });
          }
        }, 
        error: (err) => {
          console.log(err)
        }
      })
    }
  })

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
              if(status===1) {
                setTimeout(()=>{
                  window.location.assign("/admin/appeals");
                },1000)
              }
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