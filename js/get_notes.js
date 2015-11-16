$(document).ready(
  function(){
    var text = ""
    $('#all_notes_button').click(function(){
      $('.notes').each(
        function(index){
          $this = $(this);
          if ($this.val().length > 0) {
            text += "Page " + (index + 1) + ":\n" + $this.val() + '\n';
          }
        })
      $('#all_notes').val(text).removeClass('hidden');
    })
  }
)