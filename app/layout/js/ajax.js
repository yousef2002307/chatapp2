$(document).ready(function(){
    let serial = "yousef-AhMeD12345678920022008";
    let i =0;
    let count = 0;
    let x9 ;
    let singlechat;
    /////////////////////////////////////////////////////

$(".btn-chat").click(function(){
    let iduser = $(this).parents(".mb-5").attr("data-id");
    $.post("addmessage.php", {value:'hi',towho : iduser,ishere:true} );
    window.location = window.location.href.substr(0,location.href.indexOf("?"));
});











    ///////////////////////////////////////
  singlechat =    setInterval(() => {

         
       
$(".chat-container").load("ajaxsec.php",{count : i,like:serial});


  
$.post("updateseen2.php", {val : i} );
          
        



    },3000);
    
    setInterval(() => {
      i = whichHasActive();
     
       whichHasActive();
    $.ajax({
      
        url: "mesaage.php",
        data: {count2 : i,like:serial},
        method : "POST",
        success: function (data) {
            document.querySelector(".message-body").innerHTML = data;
        },
        complete : function(){
            if(count == 0){
       

           
                let divs = document.querySelectorAll(".message-body  div");
                divs = Array.from(divs);
                let lastdiv = divs.slice(-1);
                $(lastdiv).addClass("lastman");
                $(".message-body").scrollTop($('.lastman').offset().top);
              
                count++;
          
            }
        }
       });
      
            
       

        
        
       
    },1010);
    
    /*
    setInterval(() => {


        $(".chat-container").load("ajaxsec.php",{count : i});
        $(".message-body").load("ajaxsec.php",{count2 : i});
            },1000);
            */
////////////////sync active class on clicking singlechat////////////////////
$(".chatapp").on("click",".singelchat",function(){
    count = 0;
    clearInterval(singlechat);
 i = $(this).data("id");
$(this).addClass("active");
$(this).siblings(".singelchat").removeClass("active");
let divs = document.querySelectorAll(".message-body  div");
divs = Array.from(divs);
let lastdiv = divs.slice(-1);
$(lastdiv).addClass("lastman");

$(".message-body").scrollTop($('.lastman').offset().top);
singlechat =    setInterval(() => {

         
       
    $(".chat-container").load("ajaxsec.php",{count : i,like:serial});
    
    
      
    $.post("updateseen2.php", {val : i} );
              
            
    
    
    
        },3000);
});
//check which element has active class 
function whichHasActive(){
    let singlechats = document.querySelectorAll(".chatapp .singelchat");
    let dataid = 0;
    singlechats = Array.from(singlechats, (ele) => {
        if(ele.classList.contains("active")){
            dataid = ele.dataset.id ; 
            $(".messages bold").text(ele.dataset.user);
            $(".messages img").attr("src","app/uploads/"+ele.dataset.img);

        }
    });
    return dataid;
}
/////////////adding message on clicking enter////////////

$(".message-tools input").keypress(function (e) {
    let active = whichHasActive();
    if(e.key == "Enter" && $(this).val() !== ''){
    $.post("addmessage.php", {value:$(this).val(),towho : active} );
  $(this).val("");
    }
    });
    $(".message-tools i").click(function (e) {
        let active = whichHasActive();
        
        $.post("addmessage.php", {like:serial,towho : active} );
        });
/////// makeAtLatPoint/////////////




    
   
    


 /*
    setInterval(() => {
      i = whichHasActive();
     
       whichHasActive();
        $(".message-body").load("mesaage.php",{count2 : i,like:serial},() => {
            if(count == 0){
       

           
            let divs = document.querySelectorAll(".message-body  div");
            divs = Array.from(divs);
            let lastdiv = divs.slice(-1);
            $(lastdiv).addClass("lastman");
            $(".message-body").scrollTop($('.lastman').offset().top);
          
            count++;
      
        }
        });
       
            
       

        
        
       
    },1010);
    */

  /////chaange is_writing on chnge event /////////////////////////////////////////////////////
  $(".message-tools input").change(function(){
    $.post("updateseen2.php", {writing : i} );
  });
  
});