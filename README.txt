# 📂 Document Approval System (Laravel + PostgreSQL)

A simple Laravel-based application where users can upload documents and admins can approve/reject them. Includes audit logging and secure file storage.

---

## 🚀 Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/<your-username>/<repo-name>.git
cd <repo-name>
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run build
```

### 3. Configure Environment
Copy `.env.example` to `.env` and update your database:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=document_approval
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

### 4. Run Migrations
```bash
php artisan migrate
```

(Optional) Import SQL dump:
```bash
psql -U postgres -d document_approval < database/document_approval.sql
```

### 5. Serve the App
```bash
php artisan serve
```
App will run on: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔑 Middleware & Commands

- **`is_admin` middleware**: Protects admin routes so only admins can view dashboard and approve/reject documents.  
- **CSRF Protection**: All POST requests are secured by Laravel’s CSRF token.  
- **Auth Middleware**: Ensures only logged-in users can upload or view documents.  

---

## 🧹 Document Cleanup

- When a document is deleted:
  - The file is removed from `storage/app/documents`.
  - The database record is deleted.
  - A log entry is created in `document_logs` with `action=delete`.  

This ensures storage and database stay in sync, preventing orphaned files.

---

## 📊 Tech Stack

- **Laravel 12**
- **PostgreSQL**
- **Bootstrap 5**
- **Blade Templates**

---

## 👤 Roles

- **User**: Uploads and manages their own documents.  
- **Admin**: Approves/rejects documents and downloads them.  

---

## 📜 License
MIT
