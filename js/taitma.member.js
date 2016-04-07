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

function addPaymentDetails(memberId,operation,respDivId,memberTypeDiv){

    var isErrored = false;
    var memberType = document.getElementById(memberTypeDiv).value;
     // alert(isErrored);
     // alert(memberId);
             if (memberId == "") {
                  document.getElementById(divId).innerHTML = "";
                      return;
            } else {
                      var paymentDate = document.getElementById("datepicker").value;
                      // var membershipStartDate = document.getElementById("memStartDate").value;
                      // var membershipEndDate = document.getElementById("memExpiryDate").value;
                      var paymentMode = document.getElementById("paymentMode").value;
                      var amount = document.getElementById("amount").value;
                      // var billNumber = document.getElementById("billNumber").value;                      
                      var paymentNumber = document.getElementById("paymentNumber").value;
                      var paymentAgainst = document.getElementById("paymentAgainst").value;
                      var otherDetails = document.getElementById("payOtherDetails").value;
                      var doc1 = document.getElementById("doc1").value ;
                      var doc2 = document.getElementById("doc2").value;
                      // var file1 = document.getElementById("doc1");

                       // alert(paymentDate+" & "+paymentMode +" & "+amount+" & "+ paymentNumber +" & "+paymentAgainst +" & "+otherDetails);

                      //validate the form
                     
                     if(memberType == null || memberType==""){
                      isErrored = true;
                      addErrorMessage(memberTypeDiv+"Message", "Please choose a Membership type.", memberTypeDiv);
                     }else{
                        removeErrorMessage(memberTypeDiv+"Message",memberTypeDiv);
                     }



                      if(paymentDate == null || paymentDate ==""){
                        isErrored = true;
                        addErrorMessage("paymentDateMessage","Please enter Payment date.","datepicker");
                      }else{

                          if(!validateDate(paymentDate)){
                            isErrored = true;
                            addErrorMessage("paymentDateMessage","Please enter a valid Payment date.","datepicker");
                          }else {
                            removeErrorMessage("paymentDateMessage","datepicker");

                          }
                      }

                      // if(membershipStartDate== null || membershipStartDate ==""){
                      //   isErrored = true;
                      //   addErrorMessage("memStartDateMessage","Please enter Memberhsip start date.","memStartDate");
                      // }else{
                      //    if(!validateDate(membershipStartDate)){
                      //       isErrored = true;
                      //       addErrorMessage("paymentDateMessage","Please enter a valid Memberhsip start date.","memStartDate");
                      //     }else {
                      //     removeErrorMessage("memStartDateMessage","memStartDate");
                      //   }
                      // }


                      // if(membershipEndDate== null || membershipEndDate ==""){
                      //   isErrored = true;
                      //   addErrorMessage("memExpiryDateMessage","Please enter Membership expiry date.","memExpiryDate");
                      // }else{
                      //   if(!validateDate(membershipEndDate)){
                      //       isErrored = true;
                      //       addErrorMessage("paymentDateMessage","Please enter a valid Memberhsip expiry date.","memStartDate");
                      //     }else {
                      //     removeErrorMessage("memExpiryDateMessage","memExpiryDate");
                      //   }
                      // }



                      if(paymentMode== null || paymentMode ==""){
                        isErrored = true;
                        addErrorMessage("paymentModeMessage","Please enter Payment mode.","paymentMode");
                      }else{
                          removeErrorMessage("paymentModeMessage","paymentMode");
                      }



                      if(amount== null || amount ==""){
                        isErrored = true;
                        addErrorMessage("amountMessage","Please enter Payment amount.","amount");
                      }else{

                          if(isNaN(amount)){
                            isErrored = true;
                            addErrorMessage("amountMessage","Please enter a valid Payment amount.","amount");
                          }else {
                           removeErrorMessage("amountMessage","amount");                         
                          }
                      }


                    // if(billNumber== null || billNumber ==""){
                    //     isErrored = true;
                    //     addErrorMessage("billNumberMessage","Please enter a bill number.","billNumber");
                    //   }else{
                    //       removeErrorMessage("billNumberMessage","billNumber");
                    //   }

                      if(paymentNumber== null || paymentNumber ==""){
                        isErrored = true;
                        addErrorMessage("paymentNumberMessage","Please enter a check/payment number.","paymentNumber");
                      }else{
                          removeErrorMessage("paymentNumberMessage","paymentNumber");
                      }


                      if(paymentAgainst== null || paymentAgainst ==""){
                         isErrored = true;
                       addErrorMessage("paymentAgainstMessage","Please enter payment against details.","paymentAgainst");
                      }else{
                          removeErrorMessage("paymentAgainstMessage","paymentAgainst");
                      }

                      // alert(document.getElementById("doc1").value.length);
                      if(doc1.length > 0){
                         var size = $("#doc1")[0].files[0].size;
                        // alert("file size : "+size);

                        if(size>1048576) {
                             isErrored = true;
                           addErrorMessage("doc1Message","Please upload a file less than 1 MB.","doc1");

                        }else {
                          removeErrorMessage("doc1Message","doc1");
                        }
                      }

                      // console.log(document.getElementById("doc2").value);
                      if(doc2.length > 0){
                         var size = $("#doc2")[0].files[0].size;
                        // alert("file size : "+size);

                        if(size>1048576) {
                             isErrored = true;
                           addErrorMessage("doc2Message","Please upload a file less than 1 MB.","doc2");

                        }else {
                          removeErrorMessage("doc2Message","doc2");
                        }
                      }

                      // if(!isErrored){

                      //     // var postVars = "operation="+operation+"&serialNo="+memberId+"&memberType="+memberType+"&paymentDate="+paymentDate+"&membershipStartDate="+membershipStartDate+"&membershipEndDate="+membershipEndDate+
                      //     //             "&paymentMode="+paymentMode+"&amount="+amount+"&billNumber="+billNumber+"&paymentNumber="+paymentNumber+"&paymentAgainst="+paymentAgainst+"&otherDetails="+otherDetails;
                          
                      //     var postVars = "operation="+operation+"&serialNo="+memberId+"&memberType="+memberType+"&paymentDate="
                      //                   +paymentDate+"&paymentMode="+paymentMode+"&amount="+amount+"&paymentNumber="+paymentNumber+"&paymentAgainst="+paymentAgainst+"&otherDetails="+otherDetails
                      //                   +"&doc1="+doc1+"&doc2="+doc2;
                      //                                 // alert(postVars);

                      //       sendPaymentDetails(postVars,respDivId);

                      // }

                      isErrored = !isErrored
                      console.log("isErrored : "+isErrored)
                       document.getElementById(respDivId).innerHTML = "<img id='processing' src='images/processing.gif' height='20'> </img>";
                      return isErrored;

                    }
}




function sendPaymentDetails(postVars,divId){

  alert(postVars);
    if(postVars==null || postVars ==""){

    }else{
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
                                  // location.reload(true);
                              }
                          }

                             xmlhttp.open("POST","user-operations.php",true);
                              xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                              xmlhttp.send(postVars);
                              document.getElementById(divId).innerHTML = "<img id='processing' src='images/processing.gif' height='20'> </img>";
    }



}



    function addErrorMessage(msgDiv,msg,inputDiv) {
     document.getElementById(msgDiv).innerHTML = msg;
      document.getElementById(inputDiv).className+= " errorBox" ;
    }

    function removeErrorMessage(msgDiv,inputDiv) {
      document.getElementById(msgDiv).innerHTML = "";
      document.getElementById(inputDiv).classList.remove("errorBox");   
    }

    function validateDate(dateStr){

      var dateObj = new Date(dateStr);
      if(dateObj && dateObj.getFullYear()>0) 
      return true;
      else 
      return false;
      

    }

