<?php
    require 'dbcon.php';
?>
<div class="overflow-scroll"  id="sampleTable">
    

</div>


<script>
  $(document).ready(function(){
    function lodetable(page){
          $.ajax({
            url : 'product-list-all.php',
            type : 'POST',
            data : {page_no:page},
            success : function(data) {
              $('#sampleTable').html(data);
            }
          });
      }
      lodetable();

    $(document).on("click",".pagination a",function(e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        lodetable(page_id);
    });


  });
</script>