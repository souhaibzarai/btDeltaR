# 🛍️ E-Commerce Product Management Platform (PFE 2024) BtDeltaR

This project is a dynamic PHP-based e-commerce product management system built as part of my final-year graduation project. It offers an admin-user architecture to manage brands, categories, and products efficiently while supporting search and filtering capabilities on the client-facing side.

---

## 🔧 Tech Stack
- **Backend:** PHP (with MySQLi)
- **Database:** MySQL
- **Frontend:** HTML, CSS (Bootstrap), minimal JS
- **Other Tools:** XAMPP/WAMP (for local development), Admin panel with basic CRUD

---

## 🚀 Features

### 👤 User-Side
- View all products grouped by **category** or **brand**
- Search for products using a keyword-based input
- View detailed product pages with pricing, description, rating, and more
- Display of **discounted prices** computed dynamically from stored discounts

### 🛠️ Admin Panel
- Add / Edit / Delete:
  - Products
  - Categories
  - Brands
- Filter products based on category for simplified browsing
- Pagination and search within admin tables
- JavaScript confirmation for destructive actions (e.g., delete)

---

## 🗃️ Database Design Highlights
- Relational schema with foreign key references:
  - Products linked to `brands` and `categories`
- Auto-calculation of **discounted price** via SQL on each load:
  ```sql
  UPDATE products 
  SET discountedPrice = fakePrice - (fakePrice * discount / 100)
  ```

---

## 🏁 Project Status
This is an unfinished but functional early version of the final-year project. Core user flows (search, display, filtering) and admin-side management (basic CRUD) are present. UI polish and validations were in progress when the version was saved.

---

## 📚 How to Run
1. Clone this repository
2. Set up a local server (e.g. XAMPP)
3. Import the provided SQL schema (see `/SQL/`)
4. Update database credentials in `connex.php`
5. Access `index.php` via your local server (e.g., `localhost/project/index.php`)

---

## 🧠 Learnings
- Practical experience with building and securing PHP applications
- Working with SQL joins and prepared statements
- Implementing admin interfaces for real-time data manipulation
