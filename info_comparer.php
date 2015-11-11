<?php
class info_comparer{
  
  function __construct(){
    $this->input_info = func_get_arg(0);
    $this->scraped_info = func_get_arg(1);
  }
  
  function compare(){
    $count = 0;                                                 //count to be used for scraped info index.
    $this->comparison = array();                                //array to hold the comparison data.
    foreach($this->input_info as $input){                       //loop through input data and scraped data to compar
      foreach($input as $k => $input_piece ){
        if(strstr($input_piece,$this->scraped_info[$count][$k])){
          $this->comparison[$count][$k] = true;
        }
        else{
          $this->comparison[$count][$k] = false;
        }
      }// end of inner foreach
      $count += 1;
    }
  }
  
  function get_comparison(){
    return $this->comparison;
  }
  
  function test(){
    echo "<h1>Comparison</h1><pre>";
    echo print_r($this->comparison);
    echo "</pre>";
  }
  
}//end class


?>
