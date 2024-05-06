<?php
/* Отримання поточної дати */
$current_date = date("Y-m-d");
/* Зчитуємо новини з news.csv */
$news_data = array_map('str_getcsv', file('../data/news.csv'));
/* Вивід нових які підпадають під необхідний діапазон */
foreach ($news_data as $news) {
    /* Перевірка актуальності новини */
    if ($current_date >= $news[3] && $current_date <= $news[4]) {
        // Виводимо блок з новиною
        echo '<div class="news-img">';
        echo '<img src="' . htmlspecialchars($news[1]) . '" alt="Зображення новини">';
        echo '<p>' . htmlspecialchars($news[0]) . '</p>';
        echo '</div>';
    }
}
?>