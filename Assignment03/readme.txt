README - Programming Assignment 3: PHP, SQL, State, Caching

Overview

This assignment implements a web application using PHP, SQL, and session management. It consists of dynamic web pages for browsing and viewing painting details using data from a MariaDB database. The application also includes a feature to manage favorite paintings and implements caching using Memcached to optimize performance.

Contents

browse-paintings.php - Displays paintings from the database with filtering options by artist, museum, or shape.

single-painting.php - Shows detailed information for a single painting using a query string parameter.

addToFavorites.php - Adds a painting to the user's favorites list using session management.

view-favorites.php - Displays the user's list of favorite paintings.

remove-favorites.php - Removes a specific painting or all paintings from the favorites list.

common-header.php - Common header file used across all pages.

dbconnect.php - Handles database connections and queries.

common-footer.php - Common footer file used across all pages.
