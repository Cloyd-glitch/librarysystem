<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. SEED CATEGORIES
        // ==========================================
        $categories = [
            ['id' => 1, 'name' => 'Fiction'],
            ['id' => 2, 'name' => 'Science & Technology'],
            ['id' => 3, 'name' => 'History'],
            ['id' => 4, 'name' => 'Philosophy'],
            ['id' => 5, 'name' => 'Arts & Literature'],
            ['id' => 6, 'name' => 'Biography & Memoir'],
            ['id' => 7, 'name' => 'Mystery & Thriller'],
            ['id' => 8, 'name' => 'Business & Finance'],
            ['id' => 9, 'name' => 'Self-Help'],
            ['id' => 10, 'name' => 'Comics & Graphic Novels'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['id' => $cat['id']],
                [
                    'name' => $cat['name'],
                    'isActive' => true,
                    'date_added' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        // ==========================================
        // 2. SEED BOOKS
        // ==========================================
        $books = [
            // Fiction (Cat 1)
            ['name' => 'To Kill a Mockingbird', 'isbn' => '978-0446310789', 'author' => 'Harper Lee', 'category_id' => 1],
            ['name' => '1984', 'isbn' => '978-0451524935', 'author' => 'George Orwell', 'category_id' => 1],
            ['name' => 'The Great Gatsby', 'isbn' => '978-0743273565', 'author' => 'F. Scott Fitzgerald', 'category_id' => 1],
            ['name' => 'Pride and Prejudice', 'isbn' => '978-1503290563', 'author' => 'Jane Austen', 'category_id' => 1],
            ['name' => 'The Catcher in the Rye', 'isbn' => '978-0316769488', 'author' => 'J.D. Salinger', 'category_id' => 1],

            // Science & Tech (Cat 2)
            ['name' => 'A Brief History of Time', 'isbn' => '978-0553380163', 'author' => 'Stephen Hawking', 'category_id' => 2],
            ['name' => 'Clean Code', 'isbn' => '978-0132350884', 'author' => 'Robert C. Martin', 'category_id' => 2],
            ['name' => 'The Pragmatic Programmer', 'isbn' => '978-0201616224', 'author' => 'Andrew Hunt', 'category_id' => 2],
            ['name' => 'Introduction to Algorithms', 'isbn' => '978-0262033848', 'author' => 'Thomas H. Cormen', 'category_id' => 2],
            ['name' => 'Design Patterns', 'isbn' => '978-0201633610', 'author' => 'Erich Gamma', 'category_id' => 2],

            // History (Cat 3)
            ['name' => 'Sapiens: A Brief History of Humankind', 'isbn' => '978-0062316097', 'author' => 'Yuval Noah Harari', 'category_id' => 3],
            ['name' => 'Guns, Germs, and Steel', 'isbn' => '978-0393317558', 'author' => 'Jared Diamond', 'category_id' => 3],
            ['name' => 'The Silk Roads', 'isbn' => '978-1101912379', 'author' => 'Peter Frankopan', 'category_id' => 3],

            // Philosophy (Cat 4)
            ['name' => 'The Republic', 'isbn' => '978-0140449143', 'author' => 'Plato', 'category_id' => 4],
            ['name' => 'Meditations', 'isbn' => '978-0812968255', 'author' => 'Marcus Aurelius', 'category_id' => 4],
            ['name' => 'Beyond Good and Evil', 'isbn' => '978-0140449235', 'author' => 'Friedrich Nietzsche', 'category_id' => 4],

            // Mystery (Cat 7)
            ['name' => 'The Girl with the Dragon Tattoo', 'isbn' => '978-0307949486', 'author' => 'Stieg Larsson', 'category_id' => 7],
            ['name' => 'Gone Girl', 'isbn' => '978-0307588371', 'author' => 'Gillian Flynn', 'category_id' => 7],
            ['name' => 'Sherlock Holmes: The Complete Novels', 'isbn' => '978-0553212419', 'author' => 'Arthur Conan Doyle', 'category_id' => 7],

            // Business (Cat 8)
            ['name' => 'Atomic Habits', 'isbn' => '978-0735211292', 'author' => 'James Clear', 'category_id' => 8],
            ['name' => 'Thinking, Fast and Slow', 'isbn' => '978-0374533557', 'author' => 'Daniel Kahneman', 'category_id' => 8],
            ['name' => 'Zero to One', 'isbn' => '978-0804139298', 'author' => 'Peter Thiel', 'category_id' => 8],
        ];

        foreach ($books as $book) {
            DB::table('books')->insertOrIgnore(array_merge($book, [
                'isActive' => true,
                'date_added' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }

        // ==========================================
        // 3. SEED USERS (Login Accounts)
        // ==========================================
        
        // 3.1 Admin User
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@library.com'],
            [
                'student_id' => 'ADMIN-001',
                'firstname' => 'Super',
                'lastname' => 'Admin',
                'course' => 'N/A',
                'year_level' => 0,
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // 3.2 Librarian User
        DB::table('users')->updateOrInsert(
            ['email' => 'librarian@library.com'],
            [
                'student_id' => 'LIB-001',
                'firstname' => 'Head',
                'lastname' => 'Librarian',
                'course' => 'N/A',
                'year_level' => 0,
                'role' => 'librarian',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // ==========================================
        // 4. SEED STUDENTS & STUDENT USERS
        // ==========================================
        $students = [
            ['id' => '2023-0001', 'first' => 'John', 'last' => 'Doe', 'email' => 'john@student.com', 'course' => 'BSCS', 'year' => 3],
            ['id' => '2023-0002', 'first' => 'Jane', 'last' => 'Smith', 'email' => 'jane@student.com', 'course' => 'BSIT', 'year' => 2],
            ['id' => '2023-0003', 'first' => 'Mike', 'last' => 'Johnson', 'email' => 'mike@student.com', 'course' => 'BSCS', 'year' => 4],
            ['id' => '2023-0004', 'first' => 'Sarah', 'last' => 'Williams', 'email' => 'sarah@student.com', 'course' => 'BSE', 'year' => 1],
            ['id' => '2023-0005', 'first' => 'David', 'last' => 'Brown', 'email' => 'david@student.com', 'course' => 'BSIT', 'year' => 3],
        ];

        foreach ($students as $stu) {
            // Add to 'students' table (for transactions)
            $studentId = DB::table('students')->insertGetId([
                'student_id' => $stu['id'],
                'firstname' => $stu['first'],
                'lastname' => $stu['last'],
                'email' => $stu['email'],
                'course' => $stu['course'],
                'year_level' => $stu['year'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Add to 'users' table (for login)
            DB::table('users')->updateOrInsert(
                ['email' => $stu['email']],
                [
                    'student_id' => $stu['id'],
                    'firstname' => $stu['first'],
                    'lastname' => $stu['last'],
                    'course' => $stu['course'],
                    'year_level' => $stu['year'],
                    'role' => 'student',
                    'password' => Hash::make('password123'), // Default password
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}