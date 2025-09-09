
# 🌴 Kerala Tourism Web Application

A web-based portal to explore Kerala’s tourist attractions, hotels, emergency services, and cultural highlights.  
The system includes **Admin Panel** for management and **User Portal** for browsing content.

http://localhost/Kerala-Tourism/ADMIN/index.php

http://localhost/Kerala-Tourism/HOME/index.php

---

## 📂 Project Structure

```

Kerala-Tourism/
│── ADMIN/         # Admin panel for managing content
│── USER/          # User-facing site (tourism info, pages, booking, etc.)
│── HOTEL/         # Hotel module (listing, booking, details)
│── GUIDE/         # Guide module (local guides, contact info)
│── HOME/          # Homepage and static sections
│── CONFIG/        # Database configuration files
│── readme.md      # Project documentation

````

---

## ⚙️ Main Functionalities

### 👨‍💻 Admin Panel
- **Page Management**  
  Add, edit, delete tourism pages (Activities, Culture, Food, Souvenir, Wedding Destinations).
- **Tourist Spot Management**  
  CRUD operations for tourist spots with images, description, location.
- **Emergency Services Management**  
  Manage hospitals, police, ambulance, fire & rescue, coast guard, elephant squads, ham radio.
- **Hotel & Guide Management** (future expansion).

### 👥 User Portal
- View tourism pages with detailed descriptions & images.
- Browse **district-wise tourist spots**.
- Access **emergency services directory**.
- Explore **hotels & accommodations**.
- Cultural and food information sections.

---

## 🛠️ Tech Stack
- **Frontend**: HTML, CSS, Bootstrap, JS  
- **Backend**: PHP (modular, component-based)  
- **Database**: MySQL (InnoDB, foreign keys for districts, services, pages, etc.)  

---

## 🚀 Setup Instructions
1. Clone project into your web server directory:
   ```bash
   git clone <repo-url> /var/www/html/Kerala-Tourism
````

2. Import database from provided `.sql` file.
3. Update database credentials in `CONFIG/config.php`.
4. Access via browser:

   * **User Site** → `http://localhost/Kerala-Tourism/USER/index.php`
   * **Admin Panel** → `http://localhost/Kerala-Tourism/ADMIN/index.php`

---

## 📌 Notes

* Uploads are stored under `ADMIN/uploads/`.
* Districts are linked to pages, tourist spots, and emergency services.
* Ensure `uploads/` directory has write permissions.

---

✨ Developed for showcasing Kerala’s rich tourism experience.

```
