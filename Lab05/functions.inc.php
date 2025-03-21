<?php

function generateLink($url, $label, $class) {
    
     // Echoes an anchor tag with the provided URL, label, and class
     echo "<a href=\"" .$url. "\" class=\"" .$class. "\">".$label."</a>";

}


function outputPostRow($number)  {

    include("travel-data.inc.php");

    echo "<div class='row'>";
        echo "<div class='col-md-4'>";
            $label = "<img src=images/" .${'thumb'.$number}. " alt=". ${'title'.$number}." class=img-responsive>";
            generateLink("post.php?id=".${'postId'.$number}, $label,'');
        echo "</div>";

        echo "<div class='col-md-8'>";
            echo "<h2>".${'title'.$number}."</h2>";

            echo "<div class='details'>Posted by ";
            generateLink("user.php?id=".${'userId'.$number}, ${'userName'.$number},'');

            echo "<span class='pull-right'>".${'date'.$number}."</span>";

            echo "<p class='ratings'>";
                constructRating(${'reviewsRating'.$number});
                echo ${'reviewsNum'.$number}. " REVIEWS";
            echo "</p>";

            echo "</div>";
            echo "<p class='excerpt'>".${'excerpt'.$number}."</p>";

            echo "<p>";
                generateLink("post.php?id=".${'postId'.$number}, 'Read more','btn btn-primary btn-sm');
            echo "</p>";

        echo "</div>";
    echo "</div>";
    echo "<hr>";
}

/*
  Function constructs a string containing the <img> tags
  necessary to display star images that reflect a rating 
   out of 5
*/
function constructRating($rating) {

    // Output gold stars
    for ($i = 0; $i < $rating; $i++) {
        echo "<img src='images/star-gold.svg' width='16'>";
    }

    // Output white stars to fill up to 5 stars
    for ($i = 0; $i < (5-$rating); $i++) {
        echo "<img src='images/star-white.svg' width='16'>";
    }

}

?>

<?php
