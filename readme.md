
# 🌴 Kerala Tourism Mini Project

A simple PHP & MySQL-based web application to showcase popular tourist destinations in Kerala and allow visitors to book visit slots online.

## 🧾 Project Description

This mini project helps tourists plan their trips to Kerala by offering:
- Information about key tourist spots
- An online booking form for visitors
- Admin access to view bookings

It is a beginner-friendly web development project that combines frontend and backend basics.

## 💡 Features

### 🏠 Home Page
- Welcome message
- Kerala-themed banner or image
- Navigation to other pages

### 📍 Tourist Spots Page
- Display 5–6 famous destinations such as:
  - Munnar
  - Alleppey
  - Kovalam
- Each spot includes:
  - Image
  - Short description
  - Location

### 📝 Booking Form
Visitors can fill a form with:
- Name
- Contact Number
- Selected Destination
- Planned Visit Date

Form data is stored in a MySQL database.

### 🔐 Admin Panel
- Simple login-protected page (optional)
- View all user bookings
- Manage or export data (CSV optional)

## 🧑‍💻 Tech Stack

| Layer       | Technology        |
|-------------|-------------------|
| Frontend    | HTML, CSS, Bootstrap (optional) |
| Backend     | PHP               |
| Database    | MySQL             |
| Hosting     | XAMPP / WAMP / Localhost |

## 📂 Folder Structure

```

/kerala-tourism/
│
├── index.php                # Home page
├── spots.php                # Tourist destinations
├── booking.php              # Booking form
├── admin.php                # Admin panel
├── db\_config.php            # DB connection
├── style.css                # Optional custom styles
└── /images/                 # Destination images

```

## ⚙️ Setup Instructions

1. Clone or download the repository.
2. Start Apache & MySQL from XAMPP/WAMP.
3. Import the SQL file (`database.sql`) into phpMyAdmin.
4. Place the project folder in `/htdocs/` (XAMPP).
5. Open your browser and go to:  
   `http://localhost/kerala-tourism/`

## ✅ Future Enhancements (Optional)

- Add QR code generation after booking
- Enable hotel/resort booking
- Add live chat bot using JS or 3rd party plugin
- Admin authentication system

## 📌 Author

**Name:** Rahul G  
**Roll No:** 44  
**Mini Project for:** MCA 

```

