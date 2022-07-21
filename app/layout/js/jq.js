$(document).ready(function(){
  
  $(".lang select").change(function(){
    location.href = `http://localhost/chat/index/${$(this).val()}`;
 
});
////shown file input on camera icon click///////////////////////
$("figure i").click(function(){
  $(".form-file").click();
 
   });

   $(".col-md-7 form .form-file").change(function(){
    var img = document.querySelector(".photo img");
    URL.revokeObjectURL(img.src);
    img.src = URL.createObjectURL(document.forms['edit']['file'].files[0]);
  //img = document.forms['edit']['file'].files[0].name;

   // ,);
});

////////function to remove alert-danger after 5 seconds //////////////////////////////
function hiddenTheAlert(){
  $(".alert-danger").animate({
    "opacity" : 0
  },1000);
 
}

setTimeout(() => {
hiddenTheAlert();
},5000);
//show setting ul on click on setting and hide on clicking any part of body/////////////
$("html").click(function(){

$(" .navbar div ul").fadeOut();
});
$(".navbar div span.span").click(function (e) {
$(this).siblings("ul").fadeIn();
e.stopPropagation();
});
////////make the nicescroll boy /////////////////////////////////////////////////////////
$(function() {  
  $(".chatapp .chats").niceScroll();
  $(".chatapp .messages .message-body").niceScroll();
});

$(".chats").scroll(function(){
console.log("hello to chats")
});

///////////////////make the width of messages header as message////////////////////


///////increase the space on message secion on the favor of user section///////////////////////////////////////////////////////////
$(".chatapp .header .d-flex span").click(function(){
if($(".chatapp .user").is(":visible")){
  $(".chatapp .user").css("display","none");
  $(".chatapp .messages").css("width","75%");
  $(".chatapp .messages").css("border-right","none");
  

}else{
  $(".chatapp .user").css("display","block");
  $(".chatapp .messages").css("width","50%");
  $(".chatapp .messages").css("border-right","1px solid #ddd");
  

}
});
/////////////////photos on clicking//////////////////////
/* js  chatiingg work */

///on making scroll at the end of the messages field/////////////////////
if($(".chatapp .messages .message-tools")){
 

  }
});






