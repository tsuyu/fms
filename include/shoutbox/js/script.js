$(document).ready(function(){
  $('#submit').on('click', function(){
    var shout = $('#shout').val();
    var dataString = 'shout='+shout;
    
    //Validation
    if( shout === ''){
    alert("Please fill in your shout");
    } else {
    $.ajax({
      type:"POST",
      url:"./include/shoutbox/shoutbox.php",
      data: dataString,
      cache: false,
      success: function(html){
      $("#shouts ul").prepend(html);
      
      }
    });//End Ajax
    
    } // End else
    
    //Reset input forms to blank.
    $('#shout').val("");
 return false;
  });//End Click
});//End Ready

//Javascript date to sql date object
//Source:  http://stackoverflow.com/questions/20083807/javascript-date-to-sql-date-object
