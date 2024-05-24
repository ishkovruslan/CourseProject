<?php
require_once('mysql.php'); // Підключення до бази

function displayNews($db) {
    $result = $db->getActiveNews(date("Y-m-d"));
    if (count($result) > 0) {
        foreach ($result as $row) {
            echo '<div class="news-img">';
            echo '<img src="../images/news/' . htmlspecialchars($row['uploadPath']) . '">';
            echo '<p>' . htmlspecialchars($row["news_title"]) . '</p>';
            echo '</div>';
        }
    } else {
        echo "Новини відсутні";
    }
}

displayNews($db);
?>
