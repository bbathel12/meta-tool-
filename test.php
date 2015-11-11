<?php
ini_set('display_errors',1);
include_once('functions.php');
include_once('input_holder.php');


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


$test_input_parser = new input_parser($test_text);
$test_input_parser->test();



?>