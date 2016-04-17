function registerFunction(){
  var name = document.getElementById('user').value;
  var pass = document.getElementById('pass').value;
  var file = document.getElementById('uploadImage').value;
     $.ajax({
            type:'POST',
            url:'/index.php/Register/submit',
            data:{'name':name,
                  'pass':pass,
                  'Avatar':file},
            success:function(data){
                
                
            }
        });
}
function logonFunction(){
  var name = document.getElementById('username').value;
  var pass = document.getElementById('password').value;
     $.ajax({
            type:'POST',
            url:'/index.php/Welcome/logon',
            data:{'name':name,
                  'pass':pass},
            success:function(data){
                
                location.reload();
            }
        });
}
function logoutFunction(){
     $.ajax({
            type:'POST',
            url:'/index.php/Welcome/logout',
            success:function(data){
                
                location.reload();
            }
        });
}

function sellFunction(){
    var top = document.getElementById('top').value;
    var middle = document.getElementById('middle').value;
    var bottom = document.getElementById('bottom').value;
     $.ajax({
            type:'POST',
            url:'/index.php/Assembly/sellComplete',
            data:{'top':top,
                  'middle':middle,
                  'bottom':bottom},
            success:function(data){
                
                
            }
        });
}


$(document).ready(function (e) {
 $("#form").on('submit',(function(e) {
  e.preventDefault();
  $.ajax({
         url: "/index.php/Register/submit",
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   success: function(data)
      {
    
      },
     error: function(e) 
      {
    $("#err").html(e).fadeIn();
      }          
    });
 }));
});