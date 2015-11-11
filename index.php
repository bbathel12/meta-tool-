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
<body class="container-fluid">
<?php
ini_set('display_errors',1);
include_once('functions.php');
include_once('input_holder.php');
?>

<?php if(!isset($_POST['urls'])) { //if the form has been filled out?>
<div class="row">
<h1 class="text-center text-warning col-xs-10 col-xs-offset-1" >This will give you the 1st <strong>H1</strong>, <strong>Title</strong>, and <strong>Description</strong> of all the URLs you enter.</h1>
</div>
  <div class="row">
    <form method="post" class=" well col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row">
          <label class="text-center col-xs-10 col-xs-offset-1" for="urls"> URLS:(endline seperated list of URLS)</label>
        </div>
        <div class="row">
          <textarea class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2" name="urls"></textarea>
        </div>
        <div class="row">
          <input class="btn-primary col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-5" type="submit">
        </div>
    </form>
  </div>
<?php

}

else{

    $urls = explode("\n", $_POST['urls']);
    for($count = 0; $count < count($urls)-1;$count++){
      if(!(preg_match('/[\w\/]/',substr($urls[$count], -1)))){ 
        $urls[$count] = substr($urls[$count], 0, -1);
     } 
    }
    
    $result = multiRequest($urls);

    $i=0;
    foreach($result as $r){
        do_stuff($r,$urls,$i);
        $i++;
    }
    
}
?>
</body>
</html>


