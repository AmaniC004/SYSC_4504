<?php
// Connect to the database
include 'dbconnect.php';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include Memcached
//$memcache = new Memcached();
//$memcache->addServer('localhost', 11211);

session_start();
$favoritesCount = isset($_SESSION['favorites']) ? count($_SESSION['favorites']) : 0;

// Fetch filter parameters from GET
$artistFilter = $_GET['artist'] ?? null;
$galleryFilter = $_GET['gallery'] ?? null;
$shapeFilter = $_GET['shape'] ?? null;

// Generate cache key based on filters
//$cacheKey = "paintings_" . md5(json_encode($_GET));
//$paintings = $memcache->get($cacheKey);

// Build SQL query based on selected filters
$sql = "SELECT paintings.*, 
               artists.FirstName, 
               artists.LastName, 
               artists.Nationality, 
               artists.YearOfBirth, 
               artists.YearOfDeath 
        FROM paintings 
        JOIN artists ON paintings.ArtistID = artists.ArtistID";
$conditions = [];
if ($artistFilter) {
    $conditions[] = "paintings.ArtistID = ?";
}
if ($galleryFilter) {
    $conditions[] = "paintings.GalleryID = ?";
}
if ($shapeFilter) {
    $conditions[] = "paintings.ShapeID = ?";
}

if ($conditions) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " LIMIT 20"; // Optional limit

$stmt = $conn->prepare($sql);
$types = '';
$values = [];
if ($artistFilter) {
    $types .= 'i';
    $values[] = $artistFilter;
}
if ($galleryFilter) {
    $types .= 'i';
    $values[] = $galleryFilter;
}
if ($shapeFilter) {
    $types .= 'i';
    $values[] = $shapeFilter;
}

// Bind parameters dynamically
if ($types) {
    $stmt->bind_param($types, ...$values);
}
$stmt->execute();
$result = $stmt->get_result();

$paintings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $paintings[] = $row;
    }
} else {
    echo "No paintings found.";
}

    // Store paintings result in cache for 10 minutes
    /*$memcache->set($cacheKey, $paintings, 600);

// Function to get cached data or fetch from DB
function getCachedData($memcache, $cacheKey, $query, $pdo) {
    $data = $memcache->get($cacheKey);
    if ($data === false) {
        $data = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $memcache->set($cacheKey, $data, 600);
    }
    return $data;
}*/

// Fetch Artists, Galleries (Museums), and Shapes for the dropdown filters
$artists = $pdo->query("SELECT ArtistID, LastName FROM Artists ORDER BY LastName")->fetchAll(PDO::FETCH_ASSOC);
$galleries = $pdo->query("SELECT GalleryID, GalleryName FROM Galleries ORDER BY GalleryName")->fetchAll(PDO::FETCH_ASSOC);
$shapes = $pdo->query("SELECT ShapeID, ShapeName FROM Shapes ORDER BY ShapeName")->fetchAll(PDO::FETCH_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="http://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
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
                        <i class="user icon"></i> Account
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
                    <a class="item"><i class="shop icon"></i> Cart</a>
                </nav>
            </div>
        </div>

        <div class="ui attached stackable borderless huge menu">
            <div class="ui container">
                <h2 class="header item">
                    <img src="images/logo5.png" class="ui small image">
                </h2>
                <a class="item"><i class="home icon"></i> Home</a>
                <a class="item"><i class="mail icon"></i> About Us</a>
                <a class="item"><i class="home icon"></i> Blog</a>
                <div class="ui simple dropdown item">
                    <i class="grid layout icon"></i> Browse
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
            <form class="ui form" method="GET">
                <h4 class="ui dividing header">Filters</h4>
                <div class="field">
                    <label>Filter by Artist</label>
                    <select name="artist" class="ui dropdown">
                        <option value="">All Artists</option>
                        <?php foreach ($artists as $artist): ?>
                          <option value="<?= $artist['ArtistID'] ?>" <?= $artist['ArtistID'] == $artistFilter ? 'selected' : '' ?>>
                            <?= $artist['LastName'] ?>
                          </option>
                       <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label>Filter by Gallery</label>
                    <select name="gallery" class="ui dropdown">
                        <option value="">All Galleries</option>
                        <?php foreach ($galleries as $gallery): ?>
                          <option value="<?= $gallery['GalleryID'] ?>" <?= $gallery['GalleryID'] == $galleryFilter ? 'selected' : '' ?>>
                            <?= $gallery['GalleryName'] ?>
                          </option>
                       <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label>Filter by Shape</label>
                    <select name="shape" class="ui dropdown">
                        <option value="">All Shapes</option>
                        <?php foreach ($shapes as $shape): ?>
                          <option value="<?= $shape['ShapeID'] ?>" <?= $shape['ShapeID'] == $shapeFilter ? 'selected' : '' ?>>
                            <?= $shape['ShapeName'] ?>
                          </option>
                       <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="ui button">Filter</button>
            </form>
        </section>

        <section class="eleven wide column">
            <h1 class="ui header">Paintings</h1>
            <ul class="ui divided items" id="paintingsList">
                <?php foreach ($paintings as $painting): ?>
                    <li class="item">
                        <a class="ui small image" href="single-painting.php?id=<?php echo $painting['PaintingID']; ?>">
                            <img src="images/art/works/square-medium/<?php echo $painting['ImageFileName']?>.jpg">
                        </a>
                        <div class="content">
                            <a class="header" href="single-painting.php?id=<?php echo $painting['PaintingID']; ?>">
                                <?= $painting['Title'] ?>
                            </a>
                            <div class="meta">
                                <span class="cinema">
                                    <?= $painting['FirstName'] . ' ' . $painting['LastName'] ?>
                                </span>
                            </div>
                            <div class="description">
                                <p><?= $painting['Description'] ?></p>
                            </div>
                            <div class="meta">
                                <strong>$<?= $painting['Cost'] ?></strong>
                            </div>
                            <div class="extra">
                                <a class="ui icon orange button" href="cart.php?id=<?php echo $painting['PaintingID']; ?>"><i class="add to cart icon"></i></a>
                                <a href="addToFavorites.php?PaintingID=<?= $painting['PaintingID'] ?>&ImageFileName=<?= $painting['ImageFileName'] ?>&Title=<?= urlencode($painting['Title']) ?>" class="ui orange button">
                                  <i class="heart icon"></i> Add to Favorites
                                </a>

                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <?php include 'common-footer.php'; // Include footer ?>
</body>
</html>