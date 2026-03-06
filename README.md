# Windsor Lapttops E-Commerce Website

A simple PHP-based E-Commerce web application that allows users to browse laptops, view product details, add items to a shopping cart, and proceed to checkout.

This project demonstrates the basic structure of an online store using PHP, MySQL, HTML, CSS, and JavaScript.

# Project Overview
The Laptop E-Commerce Website simulates an online store where customers can:
- Browse available laptops
- View detailed product information
- Add laptops to a shopping cart
- View and manage items in the cart
- Proceed to checkout

# Feature
- View all available laptops  
- Product details page  
- Add products to cart  
- Shopping cart management  
- Checkout page  
- Database connection using PHP  
- Simple responsive layout  

# Technologies Used
- **PHP** – Server-side programming
- **MySQL** – Database management
- **HTML** – Page structure
- **CSS** – Styling and layout
- **JavaScript** – Client-side interactions
- **XAMPP** – Local development server

# Database Setup
1. Open **phpMyAdmin**
`https://localhost/phpmyadmin`

2. Create a new database
`ecommerce_db`

3. Create a table using:
   
```sql
CREATE TABLE IF NOT EXISTS laptops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    brand VARCHAR(50),
    processor VARCHAR(50),
    ram VARCHAR(20),
    storage VARCHAR(20),
    price DECIMAL(10,2),
    image_url VARCHAR(255)
);

INSERT INTO laptops (name, brand, processor, ram, storage, price, image_url) VALUES 
('Dell Inspiron', 'Dell', 'Core i5', '8GB', '512GB SSD', 75000, 'dell_inspiron.jpg'),
('HP Pavilion', 'HP', 'Ryzen 5', '16GB', '256GB SSD', 68000, 'hp_pavilion.jpg'),
('Lenovo IdeaPad', 'Lenovo', 'Core i3', '4GB', '1TB HDD', 45000, 'lenovo_ideapad.jpg');

```

# Installation and Setup
### 1. Install XAMPP
Download and install XAMPP.

### 2. Start the Server
Open XAMPP Control Panel and start:
- Apache
- MySQL

### 3. Move Project Folder
Copy the project folder into:
`C:\xampp\htdocs\`

Example:
`C:\xampp\htdocs\ecommerce_laptops`

### 4. Open the Website
Open your browser and go to:
`http://localhost/ecommerce_laptops/`

# How the System Works
- User opens the homepage.
- User browses available laptops.
- User clicks a laptop to view details.
- User adds the laptop to the shopping cart.
- Items appear in the cart page.
- User proceeds to checkout.

# Purpose
- Developed as a web development project to practice building an e-commerce system using PHP and MySQL.

# Author
Lyvia Gekonge
