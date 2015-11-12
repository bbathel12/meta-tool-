<?php
class info_comparer{
  /* creates info_comparer it takes two arrays
   *  input info: parsed data from an input_parser
   *  scraped info: data scraped from urls with info_getter
   */
  function __construct(){
    $this->input_info = func_get_arg(0);
    $this->scraped_info = func_get_arg(1);
  }
  /* this compares input_info and scraped_info and creates an array of the results of comparisons. */
  function compare(){
    $count = 0;                                                                           //count to be used for scraped info index.
    $this->comparison = array();                                                          //array to hold the comparison data.
    foreach($this->input_info as $input){                                                 //loop through input data and scraped data to compar
      foreach($input as $k => $input_piece ){                                             
        $input_piece_no_spaces  = preg_replace('/\s/','',$input_piece);                   //removes all spaces from input_piece to make for easy comparison
        $scraped_info_no_spaces = preg_replace('/\s/','',$this->scraped_info[$count][$k]);//removes all spaces from scraped data for easy comparison
        if($input_piece_no_spaces === $scraped_info_no_spaces){                           //compares both with no spaces if they are the same sets a boolean to true else sets it to false
          $this->comparison[$count][$k] = true;
        }
        else{
          $this->comparison[$count][$k] = false;
        }
      }// end of inner foreach
      $count += 1;
    }
  }
  /* returns the comparison array so that output_info can use it later. */
  function get_comparison(){
    return $this->comparison;
  }
  /* this will return a comparison wrapped in pre tags */
  function test(){
    echo "<h1>Comparison</h1><pre>";
    echo print_r($this->comparison);
    echo "</pre>";
  }
  
}//end class


?>
