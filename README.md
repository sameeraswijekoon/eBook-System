
![image](https://github.com/user-attachments/assets/c0a07592-88eb-4c60-8034-dcee56f1621d)

# 📚 eBook Hub

![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-blue.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-2.2%2B-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

**eBook Hub** is a dynamic web application designed to facilitate the uploading, viewing, and management of eBooks. Tailored for both users and administrators, this platform ensures a seamless experience with robust authentication, role-based access, and an intuitive interface.
![image](https://github.com/user-attachments/assets/e2cb8f7a-7cdf-42c5-88fe-6abaaa1f0bbf)

<div align="center">
  <img src="https://github.com/user-attachments/assets/af040015-b612-4780-a4dc-519b7121ac12" width="32%" height="170px"/>
  <img src="https://github.com/user-attachments/assets/a2b007fe-6832-4dd4-8128-184adc1c32a1" width="32%" height="170px"/>
  <img src="https://github.com/user-attachments/assets/58ee50a5-1789-463d-96de-e793f7305f11" width="32%" height="170px"/>
</div>



---

## 📝 Table of Contents

- [📚 eBook Hub](#-ebook-hub)
  - [🛠️ Features](#️-features)
  - [🚀 Prerequisites](#-prerequisites)
  - [🔧 Installation](#-installation)
  - [💡 Usage](#-usage)
  - [🐛 Troubleshooting](#-troubleshooting)
  - [🤝 Contributing](#-contributing)
  - [📜 License](#-license)

---

## 🛠️ Features

- **🔐 User Authentication**: Secure login and registration system.
- **👥 Role-Based Access**: Differentiate functionalities between users and admins.
- **📚 Book Management**: Upload, view, and manage eBooks effortlessly.
- **📈 Dashboard**: Comprehensive overview with statistics and latest uploads.
- **🎨 Responsive Design**: Built with Tailwind CSS for mobile-friendly layouts.
- **🗃️ Database Integration**: Efficient data handling with MySQL.

---

## 🚀 Prerequisites

Ensure you have the following installed on your local machine:

- **💻 PHP**: Version 7.4 or higher
- **🗄️ MySQL**: Version 5.7 or higher
- **🌐 Web Server**: Apache or Nginx
- **📦 Composer**: For managing dependencies (optional)
- **📂 XAMPP/WAMP**: For a complete development environment (optional)

---

## 🔧 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/ebook-hub.git
cd ebook-hub
```

### 2. Setup the Database

- **Create a MySQL Database**: Name it `ebook_hub` or as per your preference.
  
- **Import the Database Schema**:

  ```sql
  CREATE DATABASE ebook_hub;

  USE ebook_hub;

  CREATE TABLE users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(100) NOT NULL,
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      role ENUM('admin', 'user') DEFAULT 'user'
  );

  CREATE TABLE books (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      author VARCHAR(255),
      upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      cover_image VARCHAR(255) NOT NULL,
      pdf_file VARCHAR(255) NOT NULL
  );
  ```

### 3. Configure the Database Connection

- **Edit `db.php`**: Update the database credentials as per your setup.

  ```php
  <?php
  try {
      $pdo = new PDO('mysql:host=localhost;dbname=ebook_hub', 'your_username', 'your_password');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die("Could not connect to the database:" . $e->getMessage());
  }
  ?>
  ```

### 4. Install Dependencies (Optional)

If your project uses Composer for dependencies, run:

```bash
composer install
```

### 5. Start the Server

- **Using XAMPP/WAMP**: Place the project folder in the `htdocs` (XAMPP) or `www` (WAMP) directory and start the Apache server.
  
- **Using PHP's Built-in Server**:

  ```bash
  php -S localhost:8000
  ```

Navigate to `http://localhost:8000` in your browser to access the application.

---

## 💡 Usage

### 📄 Registration
<div align="center">
  <img src="https://github.com/user-attachments/assets/8159e5a4-7d39-477c-a9e3-56699ebf78ee" width="40%" height="185px"/>
  <img src="https://github.com/user-attachments/assets/df696af5-f1b2-495e-88bc-c60b8ad2cc43" width="32%" height="185px"/>
 
</div>


1. **Navigate to the Registration Page**: Click on the **Register** link in the navigation bar.
2. **Fill in the Details**: Provide your name, email, and password.
3. **Submit**: Upon successful registration, you'll be prompted to log in.

### 🔑 Login

1. **Navigate to the Login Page**: Click on the **Login** link in the navigation bar.
2. **Enter Credentials**: Provide your registered email and password.
3. **Access Dashboard**: Upon successful login, you'll be redirected to the Dashboard.

### 🖥️ Dashboard

- **View Statistics**: See total users, books, categories, and languages.
- **Latest Books**: Browse the most recently uploaded books.
- **Manage Books (Admin Only)**: Upload new books and manage existing ones.

### 📚 Book Management

- **Upload Book (Admin)**:
  1. Navigate to the **Upload Book** page.
  2. Fill in the book details and upload the cover image and PDF file.
  3. Submit to add the book to the catalog.

- **View Books**:
  1. Go to the **All Books** page.
  2. Browse through the collection and view book details.

### 🛡️ Role Selection (Admin Only)

- **Assign Roles**: Navigate to the **Role Select** page to assign roles to users.

---

## 🐛 Troubleshooting

### 🛑 "User details not found."

- **Cause**: The session variable `user_id` is not set correctly during login.
- **Solution**:
  1. **Check `login.php`**: Ensure that `$_SESSION['user_id']` is set using the correct column name (`id`).
     
     ```php
     $_SESSION['user_id'] = $user['id'];
     ```
  
  2. **Verify Session Start**: Ensure `session_start();` is called at the very beginning of both `login.php` and `loguser.php`.
  
  3. **Debug Session Variables**: Add the following code at the top of `loguser.php` to verify session variables.
     
     ```php
     <?php
     session_start();
     echo '<pre>';
     print_r($_SESSION);
     echo '</pre>';
     exit();
     ?>
     ```
  
  4. **Check Database Entries**: Ensure that the user exists in the `users` table with the correct `id`.

### 🔒 Session Issues

- **Cookies Disabled**: Ensure that your browser has cookies enabled as sessions rely on them.
- **Server Configuration**: Verify that the server allows session handling and has proper permissions.

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the Repository**
2. **Create a Feature Branch**

   ```bash
   git checkout -b feature/YourFeature
   ```
   
3. **Commit Your Changes**

   ```bash
   git commit -m "Add some feature"
   ```
   
4. **Push to the Branch**

   ```bash
   git push origin feature/YourFeature
   ```
   
5. **Open a Pull Request**

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

---

## 📧 Contact

For any inquiries or support, please contact [sameerasw99@gmail.com](mailto:your-sameerasw99@gmail.com).

