<?php
include 'dbconnect.php'; // Include database connection

session_start();
$favoritesCount = isset($_SESSION['favorites']) ? count($_SESSION['favorites']) : 0;

// Get the painting ID from the query string
$paintingID = isset($_GET['id']) ? (int)$_GET['id'] : 1; // Default to painting ID 1 if none provided

// Fetch painting details from the database
$stmt = $pdo->prepare("SELECT * FROM Paintings WHERE PaintingID = :id");
$stmt->bindValue(':id', $paintingID, PDO::PARAM_INT);
$stmt->execute();
$painting = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch artist details based on the artist's ID from the database
$artistID = $painting['ArtistID'];
$stmtArtist = $pdo->prepare("SELECT * FROM Artists WHERE ArtistID = :id");
$stmtArtist->bindValue(':id', $artistID, PDO::PARAM_INT);
$stmtArtist->execute();
$artist = $stmtArtist->fetch(PDO::FETCH_ASSOC);

$stmtGenres = $pdo->prepare("SELECT * FROM Genres g 
                             JOIN PaintingGenres pg ON g.GenreID = pg.GenreID 
                             WHERE pg.PaintingID = :id");
$stmtGenres->bindValue(':id', $paintingID, PDO::PARAM_INT);
$stmtGenres->execute();
$genres = $stmtGenres->fetchAll(PDO::FETCH_ASSOC);

// Fetch subjects associated with the painting
$stmtSubjects = $pdo->prepare("SELECT s.SubjectName FROM Subjects s 
                               JOIN PaintingSubjects ps ON s.SubjectID = ps.SubjectID 
                               WHERE ps.PaintingID = :id");
$stmtSubjects->bindValue(':id', $paintingID, PDO::PARAM_INT);
$stmtSubjects->execute();
$subjects = $stmtSubjects->fetchAll(PDO::FETCH_ASSOC);

// Fetch reviews associated with the painting
$stmtReviews = $pdo->prepare("SELECT * FROM Reviews WHERE PaintingID = :id");
$stmtReviews->bindValue(':id', $paintingID, PDO::PARAM_INT);
$stmtReviews->execute();
$reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);

// Example links for "On the Web" tab
$wikiLink = "https://en.wikipedia.org/wiki/" . urlencode($painting['Title']);
$googleLink = "https://arts.google.com/artist/" . urlencode($artist['FirstName'] . '+' . $artist['LastName']);

// Check if painting and artist exist
if ($painting && $artist):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
    <script src="js/misc.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet">
    <link href="css/icon.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    
<header>
    <div class="ui attached stackable grey inverted menu">
        <div class="ui container">
            <nav class="right menu">            
                <div class="ui simple dropdown item">
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
                <a class="item">
                <i class="heartbeat icon"></i> Favorites (<?= $favoritesCount ?>)
                </a>        
                <a class="item">
                  <i class="shop icon"></i> Cart
                </a>                                     
            </nav>            
        </div>     
    </div>   
    
    <div class="ui attached stackable borderless huge menu">
        <div class="ui container">
            <h2 class="header item">
              <img src="images/logo5.png" class="ui small image">
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

<main>
    <section class="ui segment grey100">
        <div class="ui doubling stackable grid container">
        
            <div class="nine wide column">
              <img src="images/art/works/medium/<?= $painting['ImageFileName'] ?>.jpg" alt="<?= $painting['Title'] ?>" class="ui big image" id="artwork">
                
                <div class="ui fullscreen modal">
                  <div class="image content">
                      <img src="images/art/works/large/<?= $painting['ImageFileName'] ?>.jpg" alt="<?= $painting['Title'] ?>" class="image">
                  </div>
                </div>                
            </div>  

            <div class="seven wide column">
                
                <div class="item">
                    <h2 class="header"><?= $painting['Title'] ?></h2>
                    <h3><?= $artist['FirstName'] . ' ' . $artist['LastName'] ?></h3>
                    <div class="meta">
                        <p>
                        <i class="orange star icon"></i>
                        <i class="orange star icon"></i>
                        <i class="orange star icon"></i>
                        <i class="orange star icon"></i>
                        <i class="empty star icon"></i>
                        </p>
                        <p><em><?= $painting['Description'] ?></em></p>
                    </div>  
                </div>                          
                
                <div class="ui top attached tabular menu">
                    <a class="active item" data-tab="details"><i class="image icon"></i>Details</a>
                    <a class="item" data-tab="museum"><i class="university icon"></i>Museum</a>
                    <a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a>
                    <a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a>    
                </div>
                
                <div class="ui bottom attached active tab segment" data-tab="details">
                    <table class="ui definition very basic collapsing celled table">
                      <tbody>
                          <tr>
                             <td>Artist</td>
                             <td><a href="<?= $artist['ArtistLink'] ?>"><?= $artist['FirstName'] . ' ' . $artist['LastName'] ?></a></td>                       
                          </tr>
                          <tr>                       
                             <td>Year</td>
                             <td><?= $painting['YearOfWork'] ?></td>
                          </tr>       
                          <tr>
                             <td>Medium</td>
                             <td><?= $painting['Medium'] ?></td>
                          </tr>  
                          <tr>
                             <td>Dimensions</td>
                             <td><?= $painting['Width'] ?>cm x <?= $painting['Height'] ?>cm</td>
                          </tr>        
                      </tbody>
                    </table>
                </div>
                
                <div class="ui bottom attached tab segment" data-tab="museum">
                    <table class="ui definition very basic collapsing celled table">
                      <tbody>
                        <tr>
                          <td>Museum</td>
                          <td></td>
                        </tr>       
                        <tr>
                          <td>Accession #</td>
                          <td><?= $painting['AccessionNumber'] ?></td>
                        </tr>  
                        <tr>
                          <td>Copyright</td>
                          <td><?= $painting['CopyrightText'] ?></td>
                        </tr>       
                        <tr>
                          <td>URL</td>
                          <td><a href="<?= $painting['MuseumLink'] ?>">View painting at museum site</a></td>
                        </tr>        
                      </tbody>
                    </table>    
                </div>     
                
                <div class="ui bottom attached tab segment" data-tab="genres">
                    <ul class="ui list">
                    <?php foreach ($genres as $genre): ?>
                            <li class="item"><?= $genre['GenreID'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>  
                
                <div class="ui bottom attached tab segment" data-tab="subjects">
                    <ul class="ui list">
                        <?php foreach ($subjects as $subject): ?>
                            <li class="item"><?= $subject['SubjectName'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>  
                
                <div class="ui segment">
                    <div class="ui form">
                        <div class="ui tiny statistic">
                          <div class="value">$<?= number_format($painting['Cost'], 2) ?></div>
                        </div>
                        <div class="four fields">
                            <div class="three wide field">
                                <label>Quantity</label>
                                <input type="number" value="1">
                            </div>                               
                            <div class="four wide field">
                                <label>Frame</label>
                                <select id="frame" class="ui search dropdown">
                                    <option>None</option>
                                    <option>Ansley</option>
                                    <option>Canyon</option>
                                </select>
                            </div>  
                            <div class="four wide field">
                                <label>Glass</label>
                                <select id="glass" class="ui search dropdown">
                                    <option>None</option>
                                    <option>Clear</option>
                                    <option>Museum</option>
                                </select>
                            </div>  
                            <div class="four wide field">
                                <label>Matt</label>
                                <select id="matt" class="ui search dropdown">
                                    <option>None</option>
                                    <option>Dawn Grey</option>
                                    <option>Gold</option>
                                </select>
                            </div>           
                        </div>                     
                    </div>

                    <div class="ui divider"></div>

                    <button class="ui labeled icon orange button">
                      <i class="add to cart icon"></i>
                      Add to Cart
                    </button>
                    <button class="ui right labeled icon button">
                    <a href="addToFavorites.php?PaintingID=<?= $painting['PaintingID'] ?>&ImageFileName=<?= $painting['ImageFileName'] ?>&Title=<?= urlencode($painting['Title']) ?>" class="ui orange button">
                        <i class="heart icon"></i> Add to Favorites
                    </a>

                      
                    </button>        
                </div>    
            </div>  
        </div> 
    </section>   
    
    <section class="ui doubling stackable grid container">
    <div class="sixteen wide column">

        <!-- Tabs for Description, On the Web, Reviews -->
        <div class="ui top attached tabular menu">
            <a class="active item" data-tab="first">Description</a>
            <a class="item" data-tab="second">On the Web</a>
            <a class="item" data-tab="third">Reviews</a>
        </div>

        <!-- Description Tab -->
        <div class="ui bottom attached active tab segment" data-tab="first">
            <?= $painting['Description'] ?>
        </div>  <!-- END DescriptionTab -->

        <!-- On the Web Tab -->
        <div class="ui bottom attached tab segment" data-tab="second">
            <table class="ui definition very basic collapsing celled table">
                <tbody>
                    <tr>
                        <td>Wikipedia Link</td>
                        <td><a href="<?= $wikiLink ?>">View painting on Wikipedia</a></td>
                    </tr>
                    <tr>
                        <td>Google Link</td>
                        <td><a href="<?= $googleLink ?>">View painting on Google Art Project</a></td>
                    </tr>
                    <tr>
                        <td>Google Text</td>
                        <td>Additional text goes here...</td>
                    </tr>
                </tbody>
            </table>
        </div>   <!-- END On the Web Tab -->

        <!-- Reviews Tab -->
        <div class="ui bottom attached tab segment" data-tab="third">
            <?php if (!empty($reviews)): ?>
                <div class="ui feed">
                    <?php foreach ($reviews as $review): ?>
                        <div class="event">
                            <div class="content">
                                <div class="date"><?= date("m/d/Y", strtotime($review['ReviewDate'])) ?></div>
                                <div class="meta">
                                    <a class="like">
                                        <?php for ($i = 0; $i < $review['Rating']; $i++): ?>
                                            <i class="star icon"></i>
                                        <?php endfor; ?>
                                    </a>
                                </div>
                                <div class="summary">
                                    <strong><?= htmlspecialchars($review['Comment']) ?>:</strong> <?= htmlspecialchars($review['Comment']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </div>   <!-- END Reviews Tab -->

    </div>
</section> <!-- END Description, On the Web, Reviews Tabs -->

    <?php include 'common-footer.php'; // Include footer ?>

</body>
</html>

<?php
else:
    echo "<p>Painting or artist not found.</p>";
endif;
?>
