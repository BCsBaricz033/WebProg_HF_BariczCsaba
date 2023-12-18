<?php
$json_data = '[
    {
        "title": "The Catcher in the Rye",
        "author": "J.D. Salinger",
        "publication_year": 1951,
        "category": "Fiction"
    },
    {
        "title": "To Kill a Mockingbird",
        "author": "Harper Lee",
        "publication_year": 1960,
        "category": "Fiction"
    },
    {
        "title": "1984",
        "author": "George Orwell",
        "publication_year": 1949,
        "category": "Dystopian"
    },
    {
        "title": "The Great Gatsby",
        "author": "F. Scott Fitzgerald",
        "publication_year": 1925,
        "category": "Fiction"
    },
    {
        "title": "Brave New World",
        "author": "Aldous Huxley",
        "publication_year": 1932,
        "category": "Dystopian"
    }
]';

$books = json_decode($json_data, true);

$categorized_books = array();

foreach ($books as $book) {
    $category = $book['category'];
    if (!isset($categorized_books[$category])) {
        $categorized_books[$category] = array();
    }
    $categorized_books[$category][] = $book;
}
echo '<table border="1">';
echo '<tr><th>Category</th><th>Title</th><th>Author</th><th>Publication Year</th></tr>';

foreach ($categorized_books as $category => $books_in_category) {
    echo '<tr><td colspan="4"><b>' . $category . '</b></td></tr>';

    foreach ($books_in_category as $book) {
        echo '<tr>';
        echo '<td></td>';
        echo '<td>' . $book['title'] . '</td>';
        echo '<td>' . $book['author'] . '</td>';
        echo '<td>' . $book['publication_year'] . '</td>';
        echo '</tr>';
    }
}

echo '</table>';

?>
