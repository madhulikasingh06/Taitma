/**
*
*	function to check if email already exists
**/

function checkEmailExists(div){

	  var divId = div.id+"Message";	
	  var email = div.value;

//	alert ("inside checkEmailExists email : "+email+"  div Message id : "+divId);


              if (email == "") {
               document.getElementById(divId).innerHTML = "";
                  return;
             } else { 
                  if (window.XMLHttpRequest) {
                      // code for IE7+, Firefox, Chrome, Opera, Safari
                      xmlhttp = new XMLHttpRequest();
                  } else {
                      // code for IE6, IE5
                      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                  }
                  xmlhttp.onreadystatechange = function() {
                      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                          document.getElementById(divId).innerHTML = xmlhttp.responseText;
                      }
                  }
                  xmlhttp.open("GET","status.php?oper=emailExists&email="+email,true);
                  xmlhttp.send();
              }

}



function forwardMessage(messageId,divId){

  // alert("inside forwardMessage.");

   if (messageId == "") {
               
                  return;
             } else { 
                  if (window.XMLHttpRequest) {
                      // code for IE7+, Firefox, Chrome, Opera, Safari
                      xmlhttp = new XMLHttpRequest();
                  } else {
                      // code for IE6, IE5
                      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                  }
                  xmlhttp.onreadystatechange = function() {
                      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                           document.getElementById(divId).innerHTML = "";
                          alert(xmlhttp.responseText);
                           location.reload(true);

                      }
                  }
                  xmlhttp.open("GET","user-operations.php?oper=forwardMessage&id="+messageId,true);
                  xmlhttp.send();
                  document.getElementById(divId).innerHTML = "<div class ='row' style='text-align:center;'><img id='processing' src='images/processing.gif' height='20'></img></div>";

              }

}



/**
*
**/
