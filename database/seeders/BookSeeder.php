<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['name' => 'To Kill a Mockingbird', 'isbn' => '978-0446310789', 'author' => 'Harper Lee', 'stock' => 11, 'category_id' => 1],
            ['name' => '1984', 'isbn' => '978-0451524935', 'author' => 'George Orwell', 'stock' => 9, 'category_id' => 1],
            ['name' => 'The Great Gatsby', 'isbn' => '978-0743273565', 'author' => 'F. Scott Fitzgerald', 'stock' => 10, 'category_id' => 1],
            ['name' => 'Pride and Prejudice', 'isbn' => '978-1503290563', 'author' => 'Jane Austen', 'stock' => 11, 'category_id' => 1],
            ['name' => 'The Catcher in the Rye', 'isbn' => '978-0316769488', 'author' => 'J.D. Salinger', 'stock' => 10, 'category_id' => 1],
            ['name' => 'A Brief History of Time', 'isbn' => '978-0553380163', 'author' => 'Stephen Hawking', 'stock' => 10, 'category_id' => 2],
            ['name' => 'Clean Code', 'isbn' => '978-0132350884', 'author' => 'Robert C. Martin', 'stock' => 10, 'category_id' => 2],
            ['name' => 'The Pragmatic Programmer', 'isbn' => '978-0201616224', 'author' => 'Andrew Hunt', 'stock' => 9, 'category_id' => 2],
            ['name' => 'Introduction to Algorithms', 'isbn' => '978-0262033848', 'author' => 'Thomas H. Cormen', 'stock' => 11, 'category_id' => 2],
            ['name' => 'Design Patterns', 'isbn' => '978-0201633610', 'author' => 'Erich Gamma', 'stock' => 13, 'category_id' => 2],
            ['name' => 'Sapiens: A Brief History of Humankind', 'isbn' => '978-0062316097', 'author' => 'Yuval Noah Harari', 'stock' => 10, 'category_id' => 3],
            ['name' => 'Guns, Germs, and Steel', 'isbn' => '978-0393317558', 'author' => 'Jared Diamond', 'stock' => 15, 'category_id' => 3],
            ['name' => 'The Silk Roads', 'isbn' => '978-1101912379', 'author' => 'Peter Frankopan', 'stock' => 12, 'category_id' => 3],
            ['name' => 'The Republic', 'isbn' => '978-0140449143', 'author' => 'Plato', 'stock' => 11, 'category_id' => 4],
            ['name' => 'Meditations', 'isbn' => '978-0812968255', 'author' => 'Marcus Aurelius', 'stock' => 13, 'category_id' => 4],
            ['name' => 'Beyond Good and Evil', 'isbn' => '978-0140449235', 'author' => 'Friedrich Nietzsche', 'stock' => 9, 'category_id' => 4],
            ['name' => 'The Girl with the Dragon Tattoo', 'isbn' => '978-0307949486', 'author' => 'Stieg Larsson', 'stock' => 11, 'category_id' => 7],
            ['name' => 'Gone Girl', 'isbn' => '978-0307588371', 'author' => 'Gillian Flynn', 'stock' => 11, 'category_id' => 7],
            ['name' => 'Sherlock Holmes: The Complete Novels', 'isbn' => '978-0553212419', 'author' => 'Arthur Conan Doyle', 'stock' => 10, 'category_id' => 7],
            ['name' => 'Atomic Habits', 'isbn' => '978-0735211292', 'author' => 'James Clear', 'stock' => 9, 'category_id' => 8],
            ['name' => 'Thinking, Fast and Slow', 'isbn' => '978-0374533557', 'author' => 'Daniel Kahneman', 'stock' => 11, 'category_id' => 8],
            ['name' => 'Zero to One', 'isbn' => '978-0804139298', 'author' => 'Peter Thiel', 'stock' => 11, 'category_id' => 8],
            ['name' => 'The Odyssey', 'isbn' => '978-0451524234', 'author' => 'Homer', 'stock' => 11, 'category_id' => 1],
            ['name' => 'The Metamorphosis', 'isbn' => '978-9626342862', 'author' => 'Franz Kafka', 'stock' => 10, 'category_id' => 7],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}