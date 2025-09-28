
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Kerala Tourism</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-2.1.4.min.js"></script>


    <!-- Icons & Fonts -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700|Montserrat:400,700" rel="stylesheet">

    <style>
        body { font-family: 'Roboto', sans-serif; background: #f4f6f9; margin:0; }
        .sidebar { width: 250px; background: #212529; color: #fff; height: 100vh; position: fixed; top: 0; left: 0; transition: all 0.3s; overflow-y: auto; z-index: 999; padding-top: 60px; }
        .sidebar.collapsed { width: 70px; }
        .sidebar ul { list-style: none; padding: 0; margin:0; }
        .sidebar ul li { padding: 12px 20px; }
        .sidebar ul li a { color: #fff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; }
        .sidebar ul li a:hover { background: rgba(255,255,255,0.1); border-radius: 6px; }
        .sidebar ul li i { margin-right: 10px; }
        .sidebar ul li ul { padding-left: 15px; }
        .sidebar-toggle-btn { position: fixed; top: 15px; left: 15px; z-index: 1100; background:#198754; color:#fff; border:none; padding:8px 12px; border-radius:4px; display:none; }
        .header { height: 60px; width: 100%; position: fixed; top:0; left:0; background:#198754; color:#fff; display:flex; align-items:center; justify-content: space-between; padding:0 20px; z-index:1000; }
        .header .logo { font-weight: bold; font-size: 1.2rem; }
        .header .profile { cursor:pointer; position: relative; }
        .header .profile .dropdown-menu { position: absolute; right:0; top:60px; background:#fff; color:#000; border-radius:5px; min-width:150px; display:none; box-shadow:0 0 10px rgba(0,0,0,0.2); }
        .header .profile .dropdown-menu a { display:block; padding:10px; color:#000; text-decoration:none; }
        .header .profile .dropdown-menu a:hover { background:#f4f4f4; }
        .content { margin-left: 250px; padding: 80px 20px 20px 20px; transition: all 0.3s; }
        .sidebar.collapsed ~ .content { margin-left: 70px; }
        .card { border-radius:10px; }
        .breadcrumb { background:none; padding:0; margin-bottom:20px; }
        .copyrights { text-align:center; margin-top:40px; padding:15px; background:#fff; border-top:1px solid #ddd; }

        @media (max-width: 992px) {
            .sidebar { left: -250px; }
            .sidebar.active { left: 0; }
            .sidebar-toggle-btn { display:block; }
            .content { margin-left: 0; padding-top:100px; }
        }
    </style>
</head>
