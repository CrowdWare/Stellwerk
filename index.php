<!DOCTYPE html>
<html>
<head>
  <title>Stellwerk</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="./slick/slick.css">
  <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
</head>
 <body>
    <h1>Stellwerk</h1>

    
<?php
function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}

$path = "./Categories";
$entries = scandir($path);
foreach($entries as $entry)
{
    if(is_dir($path."/".$entry) && $entry != "." && $entry != "..")
    {
        echo '<section class="filtering slider">';
        $subcategories = $path."/".$entry;
        $subs = scandir($subcategories);
        foreach($subs as $sentry)
        {
            if(is_dir($subcategories."/".$sentry) && $sentry != "." && $sentry != "..")
            {
                $filespath = $path."/".$entry."/".$sentry;
                $files = scandir($filespath);
                foreach($files as $file)
                {
                    if(!is_dir($filespath."/".$file) && endsWith($file, ".ini"))
                    {
                        $description = parse_ini_file($filespath."/".$file);
                        $image = $description["image"];
                        $width = $description["width"];
                        $height = $description["height"];
                        
                        echo '<div class="'.$sentry.'">';
                        echo '<a class="d-block mb-4" data-fancybox="images" href="'.$image.'" data-width="'.$width.'" data-height="'.$height.'">';
                        echo '<img class="img-fluid" src="'.$image.'">';
                        echo '</a>';
                        echo '</div>';
                        
                    }
                }
            }
        }
        echo '</section>';
    }
}
?>
    
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <script type="text/javascript">
    $(document).on('ready', function() 
    {  
      $(".filtering").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        mobileFirst: true,
        focusOnSelect: false,
        responsive: 
        [
          {
            breakpoint:769,
            settings: {slidesToShow:1}
          },
          {
            breakpoint:993,
            settings: {slidesToShow:2}
          },
          {
            breakpoint:1000,
            settings: {slidesToShow:3}
          },
        ]
      });
    });
    
    var filtered = false;
    $('.filter-btn').on('click',function()
    {
      $('.filter-btn').removeClass('active');
      var filter = $(this).data('attribute');
      if(filter == 'all')
      {
        $('.filtering').slick('slickUnfilter');
      }
      else
      {
        $('.filtering').slick('slickUnfilter');
        $('.filtering').slick('slickFilter', function( index ) 
        {
          return $('.' + filter, this).length === 1;
        });
      }
      $(this).addClass('active');
      filtered = true;
    }); 

</script>
 </body>
</html>
