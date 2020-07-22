<div class="content-holder">
    <div class="content" id="content-1" data-id='1' style="display: block;">
        <p>First Options</p>
        <input type="checkbox" />Item <br />
        <input type="checkbox" />Item
    </div>
    <div class="content" id="content-2" data-id='2'>
        <p>Second Options</p>
        <input type="checkbox" />Item <br />
        <input type="checkbox" />Item
    </div>
    <div class="content" id="content-3" data-id='3'>
        <p>Third Options</p>
        <input type="checkbox" />Item <br />
        <input type="checkbox" />Item
    </div>
    <button type="button" class="back">Back</button>
    <button type="button" class="next">Next</button>
</div>
<div class="end" data-id='4'>
    <p>Congratulation! You are done!</p>
    <button type="button" class="edit-previous">Edit Previous Options</button>
</div>


<script type="text/javascript">
    $('body').on('click', '.next', function() { 
    var id = $('.content:visible').data('id');
    var nextId = $('.content:visible').data('id')+1;
    $('[data-id="'+id+'"]').hide();
    $('[data-id="'+nextId+'"]').show();
    
    if($('.back:hidden').length == 1){
        $('.back').show();
    }
    
    if(nextId == 4){
        $('.content-holder').hide();
        $('.end').show();
    }
});

$('body').on('click', '.back', function() { 
    var id = $('.content:visible').data('id');
    var prevId = $('.content:visible').data('id')-1;
    $('[data-id="'+id+'"]').hide();
    $('[data-id="'+prevId+'"]').show();
    
    if(prevId == 1){
        $('.back').hide();
    }    
});

$('body').on('click', '.edit-previous', function() { 
    $('.end').hide();
    $('.content-holder').show();
    $('#content-3').show();
});
</script>


<style type="text/css">
      .content {
      display: none;
  }
  button {
      margin-top: 30px;
  }
  .back {
      display: none;
  }
  .next {
      margin-left: 50px;
  }
  .end {
      display: none;
  }
</style>