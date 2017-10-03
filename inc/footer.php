
 <footer>




  <!-- APP CONTENT -->

  <!-- jQuery CDN -->
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

  <!-- jQuery local fallback -->
  <script>window.jQuery || document.write('<script src="./style/js/jquery.min.js"><\/script>')</script>
 
  <!-- Bootstrap JS CDN -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
 
 <!-- Bootstrap JS local fallback -->
 <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="./style/js/bootstrap.min.js"><\/script>')}</script>
 
 <!-- Bootstrap CSS local fallback -->
 <div id="bootstrapCssTest" class="hidden"></div>
 <script>
   $(function() {
     if ($('#bootstrapCssTest').is(':visible')) {
       $("head").prepend('<link rel="stylesheet" href="./style/css/bootstrap.min.css">');
     }
   });
 </script>
</footer>
</html>