<?php

class output_info {
  
  /* Creates an output object takes three arrays
   *  input_data is an array of parsed input seperated in to url, title, description, and h1
   *  live_data is data scraped for the pages seperated in to url, title, description, and h1
   *  comparison is the output of the info_comparer, it's an array of booleans that tell you if the url, title, description, and h1 of the input and scraped data match
   */
  function __construct($input_data,$live_data,$comparison){
    $this->input_data = $input_data;
    $this->live_data  = $live_data;
    $this->comparison = $comparison;
  }
  
  /* Outputs formatted data collected */  
  function output(){
    $count = 0;
    foreach($this->input_data as $input){                          //loop through input data and scraped data to compare
      echo "<h2>Page ".($count+1)."</h2>";                          
      echo "<h2><a href='".$input['url']."' target='_blank'>".$input['url']."</a></h2>";
      foreach($input as $k => $input_piece ){
        if(!strstr($k,'url')){
          echo "<div class='row'>";
          $message = ( $this->comparison[$count][$k] ? "text-success" :  "text-danger" );
          echo "</div>";
          ?>
          <div class='row'>
          <h3 class="col-md-2 col-xs-offset-0 col-xs-12 <?php echo "$k"."_ ";  ?> input"><?php echo ucfirst ( $k ).":</h3> "; echo "<h3 class='col-md-10 col-md-offset-0 col-xs-offset-0 col-xs-12'><span class='$message' > $input_piece</h3>"; ?></h3>
          </div><div class='row'>
          <h3 class="col-md-2 col-xs-offset-0 col-xs-12 <?php echo "$k"."_ ";  ?> output"><?php echo "Live ".ucfirst ( $k ).":</h3> "; echo "<h3 class='col-md-10 col-md-offset-0 col-xs-offset-0 col-xs-12'><span class='$message' > ". $this->live_data[$count][$k]; ?></h3>
          </div>
        <?php
        }
        
      }// end of inner foreach
      ?>
          <div class="row" style="">
            <h3 class="col-md-2 col-xs-offset-0 col-xs-12">Notes</h3>
            <textarea class="col-md-10 col-md-offset-0 col-xs-offset-0 col-xs-12 notes" rows=5 name="Page_<?php echo $count ; ?>_Notes" placeholder="notes" ><?php $notes = (isset ($_POST['Page_'.$count.'_Notes']))? $_POST['Page_'.$count.'_Notes'] : "" ; echo $notes; ?></textarea>
          </div>
      <?php
      echo "<hr>";
      $count += 1;
    }
  }
  
}


?>