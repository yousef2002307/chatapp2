$(document).ready(function () {
    $("figure i").click(function(){
       $(".photo input[type='file']").click();
      
        });
        $(".photo form input.file").change(function(){
            var img = document.querySelector(".photo img");
            URL.revokeObjectURL(img.src);
            img.src = URL.createObjectURL(document.forms['photo']['file'].files[0]);
        });
        $("figure a").click(function(e){
            e.preventDefault();
            $.post("phas2ajax.php",
                function (data, textStatus, jqXHR) {
                window.location.href = window.location.origin + window.location.pathname;
              
                }
               
            );
        });
        $(".username a").click(function(e){
            e.preventDefault();
            $.post("phas2ajax.php",{val:true},
                function (data, textStatus, jqXHR) {
                window.location.href = window.location.origin + window.location.pathname + "?do=phase2";
              
                }
               
            );
        });
     
});