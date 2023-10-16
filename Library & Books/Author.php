<?php

class Author
{
    public string $name;
    public $books = [];

    /**
     * @param string $name
     * @param array $books
     */
    public function __construct(string $name, array $books = null)
    {
        $this->name = $name;
        $this->books = $books;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function setBooks(array $books): void
    {
        $this->books = $books;
    }

    // TODO Generate getters and setters of properties

    // TODO Generate constructor for all attributes. $books argument of the constructor can be optional

    /**
     * @param string $title
     * @param float $price
     * @return \Book
     */
    public function addBook(string $title, float $price): Book
    {
        // TODO Create instance of the book. Add into $books array and return it
        $book = new Book($title, $price);
        $book->setAuthor(new Author($this->name));
        $this->books[] = $book;
        return $book;
    }
}