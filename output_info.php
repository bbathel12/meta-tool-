<?php

class output_info {
  
  
  function __construct($input_data,$live_data,$comparison){
    $this->input_data = $input_data;
    $this->live_data  = $live_data;
    $this->comparison = $comparison;
  }
  function output(){
    $count = 0;
    foreach($this->input_data as $input){                          //loop through input data and scraped data to compare
      echo "<h2><a href='".$input['url']."' target='_blank'>".$input['url']."</a></h2>";
      foreach($input as $k => $input_piece ){
        if(!strstr($k,'url')){
          $message = ( $this->comparison[$count][$k] ? "text-success" :  "text-danger" );
          ?>
          <h3 class="<?php echo "$k"."_ ";  ?> input"><?php echo ucfirst ( $k ).": "; echo "<span class='$message' > $input_piece"; ?></h3>
          <h3 class="<?php echo "$k"."_ ";  ?> output"><?php echo "Live ".ucfirst ( $k ).": "; echo "<span class='$message' > ". $this->live_data[$count][$k]; ?></h3>
        <?php
        }
        
      }// end of inner foreach
      echo "<hr>";
      $count += 1;
    }
  }
  
}


?>