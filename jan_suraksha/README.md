Jan Suraksha Portal - Scaffold

What this contains:
- Basic public pages: `index.php`, `register.php`, `login.php`, `profile.php`, `file-complaint.php`, `track-status.php`
- Admin area: `admin/index.php`, `admin/dashboard.php`
- DB schema: `db/schema.sql`
- Assets: `css/style.css`, `js/main.js`

Quick setup (Windows with XAMPP):
1. Copy this folder to your XAMPP `htdocs` (already expected at `c:\xampp\htdocs\online_crime_portal`).
2. Create the database and tables: Import `db/schema.sql` using phpMyAdmin or MySQL CLI.
3. Edit `config.php` to set your DB credentials if needed.
4. Start Apache and MySQL via XAMPP control panel.
5. Visit http://localhost/online_crime_portal/ in your browser.

Notes & next steps:
- This is a functional skeleton. You should harden file uploads, add CSRF protection, input sanitization, OTP verification for mobile, and 2FA for admins before production use.
- I can continue and implement the rest of the pages (about-us, blog listing/article page, feedback handling), add client-side validation, and polish UI to exactly match the PDF. Reply to continue.
