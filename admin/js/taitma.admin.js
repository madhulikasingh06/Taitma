/**
*
**/

    function addUsefulLinks(){   

                   // alert ("inside  addUsefulLinks!");

                  // if(document.getElementById("message")){
                  //   var msg = document.getElementById("message");
                  //   msg.style.display = 'none';
                  // }

                 // alert ("inside  addUsefulLinks!");
                  var e = document.getElementById("add-links");
                      if(e.style.display == 'block')
                          e.style.display = 'none';
                       else
                          e.style.display = 'block';
    }

/**
*
**/

    function showEditUsefulLinks(){
                         
                  // alert ("inside  showLoginBoxd!");

                    var e = document.getElementById("edit-useful-link");
                   //  e.style.display = '';

                       if(e.style.display == 'block'){
                          // var vform = document.getElementById("edit-useful-link-form");
                          // vform.reset();

                          // var vform = document.getElementById("edit-useful-link-form");

        
                          e.style.display = 'none';

                       }
                       else {

                             e.style.display = 'block';

                       }
      }

      
/**
*
**/

      function editLink(id){

            // alert("inside edit Link");

            divId="editLink"+id;

             if (id == "") {
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
                  xmlhttp.open("GET","edit-delete-useful-links.php?oper=edsul&id="+id,true);
                  xmlhttp.send();
                  document.getElementById(divId).innerHTML = "<div class ='row' style='text-align:center;'><img id='processing' src='images/processing1.gif' height='20'></img></div>";

              }

          }

/**
*
*
**/

      function updateUsefulLink(id){

        alert ("inside updateUsefulLink id:"+id );


            divId="editLinkStatus"+id;
            // alert(divId);

             if (id == "") {
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
                  xmlhttp.open("GET","edit-delete-useful-links.php?oper=edul&id="+id,true);
                  xmlhttp.send();
              }


      }


     function updateUsefulLinks(action,id){

             // alert ("inside updateUsefulLinksss a:"+action );


            divId="editLinkStatus"+id;
             // alert("updateUsefulLinks div id ::"+divId);

             if (id == "") {
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

                    if (action=='d') {

                      if (confirm("Are you sure you want to delete this Link? This cannot be undone!") == true) {
                         xmlhttp.open("GET","edit-delete-useful-links.php?oper=edul&action="+action+"&id="+id,true);
                          xmlhttp.send();

                          document.getElementById(divId).innerHTML = "<img id='processing' src='images/processing1.gif' height='5'></img>";

                              } ;
                    }else {

                          // need to add post here

                          //get post variable values
                            var title = document.getElementById("title"+id).value;
                            // alert(title);
                            // var urls =document.getElementById("url"+id+"[]").value;
                            // alert(urls);

                             // var urls =document.getElementById("urls[]").value;

                             // alert("total urls ::"+document.getElementById("url-"+id+"-2[]").value);

                             var i = 0;
                             var urlsArray = new Array();
                             while(document.getElementById("edit-add-url-"+id+"-"+i+"[]")!=null && typeof(document.getElementById("edit-add-url-"+id+"-"+i+"[]")) != 'undefined'){
                                
                                // alert("edit-add-url-"+id+"-"+i+"[]");
                                
                                urlsArray[i]= document.getElementById("edit-add-url-"+id+"-"+i+"[]").value.trim();

                                // alert("url no ::"+i +" value ::" +urlsArray[i]);
                                i++;

                             }

                              var prem_val = document.getElementById("premium_val"+id).value;
                              var enabled = document.getElementById("enabled"+id).value;


                            

                           var postVars = "operation=edul&action="+action+"&id="+id+"&title="+title+"&urls[]="+urlsArray+"&premium_val="+prem_val+"&enabled="+enabled;
                            alert(postVars);

                          xmlhttp.open("POST","edit-delete-useful-links.php",true);
                              xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                          xmlhttp.send(postVars);
                          document.getElementById(divId).innerHTML = "<img id='processing' src='images/processing.gif' height='20'> </img>";
                    }

                      

              }


      }

/**
*
*
**/

      function toggleDiv(divID){

             // alert(divID);

              var e = document.getElementById(divID);
              if(e.style.display == 'block')
                  e.style.display = 'none';
              else
                  e.style.display = 'block';

      }

      

      function toggleForm(divID){

            // alert(divID);

              var e = document.getElementById(divID+"-form");
              if(e.style.display == 'block')
                  e.style.display = 'none';
              else
                  e.style.display = 'block';

      }



/**
*
*
**/

      function cancelForm(divID){

          // alert(divID);

        formID=divID+"-form";

         // alert(formID);
        document.getElementById(formID).reset();
        document.getElementById(formID).style.display='none';


      }

 function cancelDiv(divID){
          // alert(divID);
        document.getElementById(divID).style.display='none';
}





function addInput(divName,counter){

        var lastChildID = document.getElementById(divName).lastChild.id;

        // alert("last child : "+lastChildID);

        if(lastChildID != undefined){

            var lastId = lastChildID.split("-");
            // alert(lastId[lastId.length-1]);
            counter=parseInt(lastId[lastId.length-1])+1;
          
          }

          var newdiv = document.createElement('div');

            var id=divName+"-"+counter+"[]";
            // alert(id);
            newdiv.id=id;
            newdiv.innerHTML = "<label for='urls[]' class='col-sm-4'>Link URL:</label>"+
                            "<input  class='input-box col-sm-6' type='url' name='urls[]' onChange='updateValue(\""+ id +"\",this.value)'/> " +
                            // "<input  class='col-sm-1' style='width:20px;' type='button' value='-' onClick='removeInput(\""+ id +"\");'> ";
                            "<a href='#' class='col-sm-1'  onClick='removeInput(\""+ id +"\");'><span class='sign-link'>-</span></a>";

          document.getElementById(divName).appendChild(newdiv);

}


function removeInput(divName) {

  // alert(divName);
    var elem = document.getElementById(divName);
    elem.parentNode.removeChild(elem);

}

function updateValue(divName, value){

  // alert(divName+" and "+value);
  document.getElementById(divName).value=value;
}




















