<?php
echo '

<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset=utf-8>
    <link href=\'http://fonts.googleapis.com/css?family=Merriweather\' rel=\'stylesheet\' type=\'text/css\'>
    <link href=\'http://fonts.googleapis.com/css?family=Open+Sans\' rel=\'stylesheet\' type=\'text/css\'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
        <script src="js/misc.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">
    
</head>
<body >
    
<header>
    <div class="ui attached stackable grey inverted  menu">
        <div class="ui container">
            <nav class="right menu">            
                <div class="ui simple  dropdown item">
                  <i class="user icon"></i>
                  Account
                    <i class="dropdown icon"></i>
                  <div class="menu">
                    <a class="item"><i class="sign in icon"></i> Login</a>
                    <a class="item"><i class="edit icon"></i> Edit Profile</a>
                    <a class="item"><i class="globe icon"></i> Choose Language</a>
                    <a class="item"><i class="settings icon"></i> Account Settings</a>
                  </div>
                </div>
                <a class=" item">
                  <i class="heartbeat icon"></i> Favorites
                </a>        
                <a class=" item">
                  <i class="shop icon"></i> Cart
                </a>                                     
            </nav>            
        </div>     
    </div>   
    
    <div class="ui attached stackable borderless huge menu">
        <div class="ui container">
            <h2 class="header item">
              <img src="images/logo5.png" class="ui small image" >
            </h2>  
            <a class="item">
              <i class="home icon"></i> Home
            </a>       
            <a class="item">
              <i class="mail icon"></i> About Us
            </a>      
            <a class="item">
              <i class="home icon"></i> Blog
            </a>      
            <div class="ui simple dropdown item">
              <i class="grid layout icon"></i>
              Browse
                <i class="dropdown icon"></i>
              <div class="menu">
                <a class="item"><i class="users icon"></i> Artists</a>
                <a class="item"><i class="theme icon"></i> Genres</a>
                <a class="item"><i class="paint brush icon"></i> Paintings</a>
                <a class="item"><i class="cube icon"></i> Subjects</a>
              </div>
            </div>        
            <div class="right item">
                <div class="ui mini icon input">
                  <input type="text" placeholder="Search ...">
                  <i class="search icon"></i>
                </div>
            </div>      

        </div>
    </div>       
</header> 
    
<main class="ui segment doubling stackable grid container">

    <section class="five wide column">
        <form class="ui form">
          <h4 class="ui dividing header">Filters</h4>

          <div class="field">
            <label>Artist</label>
            <select class="ui fluid dropdown">
                <option>Select Artist</option>  
                <option>name</option>
            </select>
          </div>  
          <div class="field">
            <label>Museum</label>
            <select class="ui fluid dropdown">
                <option>Select Museum</option>  
                <option>name</option>
            </select>
          </div>   
          <div class="field">
            <label>Shape</label>
            <select class="ui fluid dropdown">
                <option>Select Shape</option>  
                <option>name</option>
            </select>
          </div>   

            <button class="small ui orange button" type="submit">
              <i class="filter icon"></i> Filter 
            </button>    

        </form>
    </section>
    

    <section class="eleven wide column">
        <h1 class="ui header">Paintings</h1>
        <ul class="ui divided items" id="paintingsList">

          <li class="item">
            <a class="ui small image" href="detail.php?id=565"><img src="images/art/works/square-medium/131040.jpg"></a>
            <div class="content">
              <a class="header" href="detail.php?id=565">View of St. Markís from the Punta della Dogana</a>
              <div class="meta"><span class="cinema">Canaleto</span></div>        
              <div class="description">
                <p>The View of St. Markís Basin came to Brera in 1828 with the View of the Grand Canal Looking toward the Punta della Dogana from Campo SantíIvo.</p>
              </div>
              <div class="meta">     
                  <strong>$900</strong>        
              </div>        
              <div class="extra">
                <a class="ui icon orange button" href="cart.php?id=565"><i class="add to cart icon"></i></a>
                <a class="ui icon button" href="favorites.php?id=565"><i class="heart icon"></i></a>          
              </div>        
            </div>      
          </li>

          <li class="item">
            <a class="ui small image" href="detail.php?id=568"><img src="images/art/works/square-medium/137010.jpg"></a>
            <div class="content">
              <a class="header" href="detail.php?id=568">Abbey among Oak Trees</a>
              <div class="meta"><span class="cinema">Casper David Friedrich</span></div>        
              <div class="description">
                <p>Abbey among Oak Trees is the companion piece to Monk by the Sea. Friedrich showed both paintings in the Berlin Academy Exhibition of 1810.</p>
              </div>
              <div class="meta">     
                  <strong>$900</strong>        
              </div>        
              <div class="extra">
                <a class="ui icon orange button" href="cart.php?id=568"><i class="add to cart icon"></i></a>
                <a class="ui icon button" href="favorites.php?id=568"><i class="heart icon"></i></a>          
              </div>        
            </div>      
          </li>    

        </ul>        
    </section>  
    
</main>    
    
  <footer class="ui black inverted segment">
      <div class="ui container">footer for later</div>
  </footer>
</body>
</html>
';
?>