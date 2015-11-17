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
                    document.getElementById(divId).innerHTML = "<div class ='row' style='text-align:center;'><img id='processing' src='images/processing.gif' height='20'></img></div>";

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

              var errArray = [];
              var errArrayIndex = 0;

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

                            document.getElementById(divId).innerHTML = "<img id='processing' src='images/processing.gif' height='20'></img>";

                                } ;
                      }else {

                            //validate the fields

                             if(validateUsefulLinks("-"+id)){

                              //get post variable values
                               var title = document.getElementById("title-"+id).value;
                               var prem_val = document.getElementById("premium_val-"+id).value;
                              var enabled = document.getElementById("enabled-"+id).value;

                               var i = 0;
                               var urlsArray = new Array();
                               
                               // alert("element : "+document.getElementById("edit-add-url-"+id+"-"+i+"[]"));
                               while(!(document.getElementById("edit-add-url-"+id+"-"+i+"[]")== undefined)){
                                  
                                  // alert("edit-add-url-"+id+"-"+i+"[]");
                                  
                                var url =   document.getElementById("edit-add-url-"+id+"-"+i+"[]").value;

                                  // alert("url  is ::"+url);
                                      
                                    if(!(url==undefined)){

                                      // if(ValidateURL(url.trim())){
                                        urlsArray[i]=url.trim();                                     
                                      // }

                                    }
                                  i++;

                               }




                               var postVars = "operation=edul&action="+action+"&id="+id+"&title="+title+"&urls[]="+urlsArray+"&premium_val="+prem_val+"&enabled="+enabled;
                                      // alert(postVars);

                                    xmlhttp.open("POST","edit-delete-useful-links.php",true);
                                        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                                    xmlhttp.send(postVars);
                                    document.getElementById(divId).innerHTML = "<img id='processing' src='images/processing.gif' height='20'> </img>";


                             }

                           
                      }

                        

                }


        }

/**
*
*
*
*/

  function validateUsefulLinks(divId){

      // alert("inside validateUsefulLinks");
      // var errors = 0;
      var titleID = "title"+divId;
      var urlID = "edit-add-url"+divId;
      var enabledID = "enabled"+divId;  
      var premium_valID = "premium_val"+divId;
      var errArray = [];
      var i = 0;
      var urlsArray = new Array();

       // alert(titleID+"  "+urlID+"  "+enabledID+"  "+premium_valID);


        if(document.getElementById(titleID)!=undefined){
         
           var titleVal = document.getElementById(titleID).value;
            // alert("checking title titleVal::"+titleVal);
           if(titleVal.trim()=="" || titleVal.trim().length<1){
                errArray.push(titleID);
            }
 
        }

        while(!(document.getElementById(urlID+"-"+i+"[]")== undefined)){
            
         // alert("checking uls::"+titleVal);

          var url =   document.getElementById(urlID+"-"+i+"[]").value;                                    
            if(!(url==undefined)){

               if(ValidateURL(url.trim())){
                 urlsArray[i]=url.trim();                                     
               }else {
                  errArray.push(urlID+"-"+i+"[]");
                }

            }else {
                  errArray.push(urlID+"-"+i+"[]");
            }
            i++;
        }

      // alert("checked uls::");

      // alert("checked enabled ::");

      if(document.getElementById(premium_valID)!=undefined){
        var prem_Val=document.getElementById(premium_valID).value;
         // alert("checking prem_Val ::"+prem_Val);
        if(prem_Val==""){
            errArray.push(premium_valID);
        }
      }

      if(document.getElementById(enabledID)!=undefined){
        var enabledVal=document.getElementById(enabledID).value;
        // alert("checking enabled ::"+enabledVal);
        if(enabledVal==""){
            errArray.push(enabledID);
        }
      }

 

      // alert("timepass");
       var errors = parseInt(errArray.length);

       // alert("erros length ::"+errors);

       if(errors>0){

          // alert("inside if ");
          
          for (var i = 0; i <errors; i++) {

            error = errArray[i];
            var errStart = error.substr(0,2);

            if(errStart == "ed"){
              CreateErrorPara(error+"-msg" , "Please supply  a valid url");
              document.getElementById(error).className+=" errorBox";  

            }else if (errStart =="ti"){
                CreateErrorPara(error+"-msg","Please enter a valid Title.");
                document.getElementById(error).className+=" errorBox";  
            }else if(errStart == "en") {
                CreateErrorPara(error+"-msg","Please select enabled value.");
                document.getElementById(error).className+=" errorBox";  
            }else if(errStart == "pr") {
                CreateErrorPara(error+"-msg","Please select a premium value.");
                document.getElementById(error).className+=" errorBox";  
            }

          };

        return false;
      }else {
                  // alert("inside else ");

        return true;
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


        counter=parseInt(counter);
    // alert("divName : "+divName+" and   counter ::"+counter);

          var lastChildID = document.getElementById(divName).lastChild.id;

           // alert("last child : "+lastChildID);

          if(lastChildID != undefined){

              var lastId = lastChildID.split("-");
              // alert(lastId[lastId.length-1]);
              counter=parseInt(lastId[lastId.length-1])+1;
            
            }
          
          var id=divName+"-"+counter+"[]";
          var newDivID =divName+"-"+counter+"-div";
            //error div 
            var errDiv = document.createElement('div');
            errDiv.id=id+"-msg";
            errDiv.className+=" center error";

            //  "<div id='"+id+"-msg'"+ "class=' center error row'></div>"+

            var newdiv = document.createElement('div');

           
              // alert(id);
              newdiv.id=newDivID;
              newdiv.className+="";
              newdiv.innerHTML ="<div class='col-sm-3'><label for='urls[]' >URL:</label></div>"+
                              "<div class='col-sm-7'><input type='url' class='input-box-link' name='urls[]' id=\'"+id+"\' onChange='updateValue(\""+ newDivID +"\",this.value)'/></div>"+
                              "<div class='col-sm-2'><a href='#'  onClick='removeInput(\""+ newDivID +"\");'><span class='sign-link'>-</span></a></div>";

            document.getElementById(divName).appendChild(errDiv);
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


    function ValidateURL(url) { 
        var v = new RegExp(); 
        // v.compile(/^(?:(ftp|http|https):\/\/)?(?:[\w-]+\.)+[a-z]{3,6}$/gi); 
        v.compile( /((ftp|http|https)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/);
        if (v.test(url)) { 
             // alert("You must supply a valid URL."+url); 
           return true; 
        }else {
          return false;
        } 
    } 


  function CreateErrorPara(divid,msg){

    // document.getElementById("MyElement").className += " MyClass";

    // alert(divid)
     // if(divid!=null){
      var newdiv = document.createElement("div");
      newdiv.className+="col-sm-12 center";
      var errPara = document.createElement("p");
      divid.className="errorBox";
      // errPara.innerHTML = msg;
      // document.getElementById(newdiv).appendChild(errPara);
      // document.getElementById(divid).appendChild(errPara);

      newdiv.innerHTML = "<p>"+msg+"</p>";
      document.getElementById(divid).appendChild(newdiv);


     // }



  }

















