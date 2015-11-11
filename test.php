<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/meta-tool/style.css">
  </head>
<?php
ini_set('display_errors',1);
include_once('functions.php');


/* test for input_parser stuff */
$test_text = <<< END

URL: http://www.shelllandinggolf.com/-golf-overview 

Page Title (Title Tag): Golf Course - Gautier, MS - Shell Landing Golf Club 

Page Description (Meta Description): Do you want an affordable golf course and restaurant combination? If so, you have to schedule a visit to Shell Landing Golf Club. Learn more about it here. 

Page Heading (H1):  Premier Golf Course on the Mississippi Gulf Coast


URL: http://www.shelllandinggolf.com/-golf-overview 

Page Title (Title Tag): Golf Course - Gautier, MS - Shell Landing Golf Club 

Page Description (Meta Description): Do you want an affordable golf course and restaurant combination? If so, you have to schedule a visit to Shell Landing Golf Club. Learn more about it here. 

Page Heading (H1):  Premier Golf Course on the Mississippi Gulf Coast

END;

$test_input_parser = new input_parser($test_text); // instantiates input_parser
$test_input_parser->test();                        // runs test function
$urls = $test_input_parser->get_urls();
$test_info_getter = new info_getter($urls);
$test_info_getter->test();


$input_info = $test_input_parser->get_pages();
$input_info[0]['title'] = 'blah';
$live_info = $test_info_getter->get_info();
$test_info_comparer = new info_comparer($input_info, $live_info);
$test_info_comparer->compare();
$test_info_comparer->test();

$comparison = $test_info_comparer->get_comparison();

$test_outputer = new output_info($input_info,$live_info,$comparison);
$test_outputer->output();

?>