<?php
class img_info_comparer{
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
