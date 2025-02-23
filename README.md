# **DocClinicx - Setup Guide**

## **Prerequisites**

Ensure the target computer has the following installed:

-   **XAMPP with PHP 8.2.12 or higher**
-   **Composer**
-   **Node.js & NPM** (for Tailwind CSS and Vite)

---

## **Installation Steps**

### **1. Download The Zip File**

#### **Option 2: Copy Manually**

Copy the entire project folder to the target computer and **navigate to it in the terminal**.

---

### **2. Install Dependencies**

In the terminal, run the following command inside the project folder to install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

---

### **3. Configure Environment File**

-   Copy `.env.example` and rename it to `.env`:
    ```bash
    cp .env.example .env
    ```
-   Update the app name:
    ```ini
    APP_NAME=DocClinicx
    ```
-   Update the `.env` file with your database settings:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=doc_clinicx
    DB_USERNAME=root
    DB_PASSWORD=your_passsword || leave it blank if none
    ```
-   Configure email settings (update credentials if necessary):
    ```ini
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=465
    MAIL_USERNAME=docclinicxofficial@gmail.com
    MAIL_PASSWORD=your_app_password
    MAIL_ENCRYPTION=ssl
    MAIL_FROM_ADDRESS="docclinicxofficial@gmail.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

---

### **4. Generate Application Key**

-   Still in the terminal, run this command:

```bash
php artisan key:generate
```

---

### **5. Set Up the Database**

#### **Create a Database in MySQL**

```sql
CREATE DATABASE doc_clinicx;
```

#### **Import Database Schema**

Once the database is created, import the schema using phpMyAdmin:

1. In phpMyAdmin, click on the doc_clinicx database (left panel).
2. Click on the Import tab at the top.
3. Click Choose File and navigate to

```bash
database/schema/mysql-schema.sql
```

4. Select the mysql-schema.sql file and click Open.
5. Click Go to start the import.
6. Once completed, you should see a success message, confirming that the schema has been imported.

---

#### **Run Seeders**

To seed the users account (Admin, Staff, Dentist, and Patient):

```bash
php artisan db:seed
```

---

### **6. Set Up Storage & Caching**

Run the following commands to set up file storage and clear caches:

```bash
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

### **7. Start Background Processes**

#### **Start the Queue Worker**

```bash
php artisan queue:work
```

#### **Run Scheduler**

```bash
php artisan schedule:work
```

---

### **8. Run the Application**

#### Run Apache Server

If needed, manually start Laravel with:

-   run **Apache** and **MySQL** on **XAMPP**.

-   After that run these command on the terminal:

```bash
npm run dev
```

```bash
php artisan serve
```

Then, visit: **http://127.0.0.1:8000**

---

### **9. Login Credentials**

To access user login credentials, open the following file:

```
credentials.txt
```

This files containes the necessary usernames and passwords for different user roles.

---

## **Troubleshooting**

-   **Composer issues?** Run `composer update`
-   **Database connection errors?** Check `.env` database settings
-   **Email issues?** Ensure SMTP credentials are correct
-   **File storage issues?** Run `php artisan storage:link`

---
