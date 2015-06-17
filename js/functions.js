/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("#submit").click(function () {
        $('#histogram').attr("src", "./loading.gif");
        var img = new Image();
        img.onload = function () {
            $('#histogram').attr("src", img.src);;
        }
        img.onerror = function () {
            alert("The username provided dose not exist");
            $('#histogram').attr("src", "");;
        }
        img.src = "./histogram.php?username=" + $("#username").val();
        //$('#histogram').attr("src", "./histogram.php?username=" + $("#username").val());

    });

});

