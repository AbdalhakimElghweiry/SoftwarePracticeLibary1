<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Staff::create(['name' => 'ali',  'email' => 'ali2@gmail.com',  'password' => '12345678']);
        Staff::create(['name' => 'sara', 'email' => 'sara@gmail.com', 'password' => '12345678']);
        Staff::create(['name' => 'omar', 'email' => 'omar@gmail.com', 'password' => '12345678']);

        $c1 = Customer::create(['name' => 'Customer One', 'email' => 'c1@gmail.com', 'phone_number' => '0911111111', 'password' => '12345678']);
        Customer::create(['name' => 'Customer Two', 'email' => 'c2@gmail.com', 'phone_number' => '0922222222', 'password' => '12345678']);

        $fiction = Category::create(['name' => 'Fiction', 'description' => 'Novels and stories']);
        $science = Category::create(['name' => 'Science', 'description' => 'Science and technology books']);

        $b1 = Book::create(['name' => 'Harry Potter', 'author' => 'J. K. Rowling', 'ISBN' => '9780747532699', 'category_id' => $fiction->id]);
        Book::create(['name' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'ISBN' => '9780553380163', 'category_id' => $science->id]);

        $c1->borrowings()->attach($b1->id, [
            'borrowing_date' => now()->toDateString(),
            'return_date'    => now()->addDays(7)->toDateString(),
            'is_returned'    => false,
        ]);
    }
}
