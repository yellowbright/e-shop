<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"   "http://www.w3.org/TR/html4/loose.dtd"> 
  <html> 
  <head> 
<script type="text/javascript" src="/Public/Js/jquery-1.4.2.min.js"></script>
     
    <script> 
    $(document).ready(function(){ 
       
      $("button").click(function(){ 
        $(this).clone(true).insertAfter(this); 
      }); 
   
    }); 
    </script> 
     
  </head> 
  <body> 
    <button>Clone Me!</button> 
    <div>
      <?php  $abc = NULL; $ccc = implode(',', $abc); var_dump($abc); echo '<br/>'; die; ?>
    </div>
  </body> 
  </html>