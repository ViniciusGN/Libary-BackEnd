# Back-End Web Application - ENSICAEN  
**Library Project**  
Vinicius Nascimento  

This repository contains a complete PHP-based web application developed as part of the **Developpement Back-End** course at ENSICAEN. The project explores server-side logic, database interaction using PostgreSQL, and dynamic front-end behaviors via JavaScript and AJAX.

The project is divided into **three main parts**, each introducing new functionality and concepts in back-end development, including session handling, cookies, database queries, cart management, and asynchronous interactions.

---

## 🔧 Environment Setup (XAMPP + PostgreSQL)

### For Windows:
1. **Install XAMPP**:
   - Download from https://www.apachefriends.org/index.html
   - Install and run Apache server and PHP.

2. **Project Folder**:
   - Place the project files inside `C:/xampp/htdocs/mysite/TP3`
   - Your project will be accessible at: `http://localhost/mysite/TP3`

3. **Install PostgreSQL**:
   - Download from https://www.postgresql.org/
   - Use pgAdmin or `psql` command line to manage your DB.

4. **Import the Database**:
   - Use the provided `livres.sql` dump.
   - Run via command line:
     ```bash
     psql -U postgres -f C:/path/to/livres.sql
     ```

### For Linux:
1. Install Apache and PHP:
   ```bash
   sudo apt install apache2 php libapache2-mod-php
   ```

2. Install PostgreSQL:
   ```bash
   sudo apt install postgresql postgresql-contrib php-pgsql
   ```

3. Place your site files inside `/var/www/html/mysite/TP3`

4. Import the database as on Windows.

---

## 📁 Project Structure
```
TP3/
├── Cart/                  # Handles cart logic (AJAX + PHP)
├── Requests/              # PHP files for database queries
├── Script/                # JavaScript files (AJAX, DOM manipulation)
├── SQL/                   # PL/pgSQL functions (inscription, etc.)
├── Assets/                # CSS and design assets
├── index.php              # Main page
├── login.php              # Client login
├── register.php           # Client registration
├── logout.php             # Session termination
└── counter.txt            # Visitor counter
```

---

## 🧠 Technologies Used
- **PHP (vanilla)**
- **PostgreSQL** (with PDO)
- **HTML5 / CSS3**
- **JavaScript** (Vanilla + AJAX)

---

## 🚀 Project Overview

### 🔹 Part 1: Basic Structure and Visitor Counter
- Implemented a counter saved in `counter.txt`
- Used cookies to avoid multiple counts from the same user
- Created a homepage with header, navigation inputs, and result sections
- Introduced dynamic content sections using `<section>` and `<nav>`

### 🔹 Part 2: Dynamic Searches with AJAX + SQL
- Implemented search for:
  - Authors (by name)
  - Books (by title and code)
  - Works by a specific author
- Used AJAX to query the database and display real-time results
- Results rendered in HTML using JavaScript and parsed JSON

### 🔹 Part 3: Shopping Cart System
- Created tables `clients`, `panier`, and `commande`
- User registration and login with session and cookies
- Add/remove/view items from cart
- Finalize orders (cart items moved to `commande` table)
- Cart stored in DB and associated with user session

---

## 💡 Features Implemented
- 📈 Visitor tracking using file and cookies
- 🔐 Client session + authentication
- 🔍 Dynamic author/book search
- 🛒 Cart system (add, view, clear, confirm)
- 🗃️ Database-backed order management

---

## ✅ How to Use
1. Register a new client via `register.php`
2. Login through `login.php`
3. Search for books/authors in the homepage
4. Add items to the cart and consult them
5. Finalize your order or clear your cart

---

## 📚 Reference Concepts
- **Cookies & Sessions**: Identify and manage users
- **AJAX**: Communicate with server without reloading
- **PostgreSQL PL/pgSQL**: For database logic (e.g., `inscription()`)
- **Separation of Concerns**: PHP for server, JS for client

---