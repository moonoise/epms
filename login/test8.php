<html>
    <head>

     <!-- Bootstrap -->
     <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

     <style>
.progress {
  margin: 5px;
  width: 500px;
}

</style>

    <link href="../vendors/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
   
    </head>

<body>
    
<h3>Dynamic Progress Bar</h3>
<p>Running progress bar from 0% to 100% in 10 seconds</p>
<div class="progress">
  <div id="dynamic"  class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-pause="70" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
    <span id="current-progress"></span>
  </div>
</div>
 <small>57% Complete</small>

 <h3>Dynamic Progress Bar</h3>
<p>Running progress bar from 0% to 100% in 10 seconds</p>
<div class="progress">
  <div id="dynamic2"  class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-pause="50" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
    <span id="current-progress"></span>
  </div>
</div>
 <small>57% Complete</small>

</body>
 <!-- jQuery -->
 <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script>

$(".progress-bar").each(function(i){
    var idProgress = $(this).attr('id')
    progressBar("#"+idProgress)
    console.log(idProgress)
})

function progressBar(id) {
    var current_progress = 0;
    var interval = setInterval(function() {
        current_progress += 1;
        var bar_pause = $(id).attr('aria-pause')
        $(id)
        .css("width", current_progress + "%")
        .attr("aria-valuenow", current_progress)
        .text(current_progress + "% Complete");
        if (current_progress >= bar_pause)
            clearInterval(interval);
    }, 10);
    }



</script>

</html>