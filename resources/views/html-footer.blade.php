<script type="text/javascript" src="{{asset('js/jquery.1.8.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-scrolltofixed.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.easing.1.3.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.isotope.js')}}"></script>
<script type="text/javascript" src="{{asset('js/wow.js')}}"></script>
<script type="text/javascript" src="{{asset('js/classie.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(e) {
        $('#test').scrollToFixed();
        $('.res-nav_click').click(function(){
            $('.main-nav').slideToggle();
            return false    
            
        });
        
    });
</script>

 <script type="text/javascript">
 var count = 0;
 var leadsLength = 0;
 var leadsOrig = [];
 
    $(document).ready(function() {
    	l = ""; t = ""; c = "";
    	$('#sendFormSubmit').click(function(e){
          l = $('#leads').val(); leadsOrig = l;
          t = $('#title').val();
          c = $('#content').val();
          
          if(l == "" || t == "" || c == ""){
               if(l == "") alert("Contacts field is required");
               if(t == "") alert("Title field is required");
               if(c == "") alert("Content field is required");
          } 
          
          else{
             leads = l.split('\n');
             //alert(leads.length);
             leadsLength = leads.length;
             var mailInterval;
             
             if(leads.length >= 1){
             	initSendMail(t,c);
             }
          }
          
          return false;
        });
    });
    
    function initSendMail(t, c){
       recpt = leadsOrig[count];
       sendMail(recpt,t, c);
    } 
    
    function sendMail(ld,title,content){
        data = {"_token": "{{csrf_token()}}", "leads": ld, "title": title,"content": content};
           $.ajax({
    
   type : 'POST',
   url  : "{{url('send')}}",
   async: false, 
   data : data,
   beforeSend: function()
   { 
    $("#error").fadeOut();
    $("#response").fadeOut();
    $("#working").html('<br><br><img class="img img-responsive" src="{{asset('img/loading.gif')}}" alt="Sending emails, please wait.. "><br>Sending emails, please wait.... </strong>');
   },
   success :  function(response)
      {        
        //alert(response);
        $("#working").fadeOut();
      if(response == "success"){
      	formerResult = $("#response").html();
          newResult = formerResult + " Email sent to " + lead + " successfully!<br>";
          $("#response").html(newResult);
          
          ++count;
          window.setTimeout(function(){console.log("Wait for 5 seconds..");},500);
          
          if(count < leadsLength){
          	sendMail(leadsOrig[count],title,content);
           }
       }   
     }
   });
         return false;            
    } 
</script>



</body>
</html>