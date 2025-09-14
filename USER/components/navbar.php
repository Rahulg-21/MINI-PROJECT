<!-- Sidebar -->
<div class="sidebar bg-success" id="sidebar">
    <!-- Sidebar Title -->
    <div class="sidebar-title">
        <h4>User Dashboard</h4>
    </div>
    <ul>
        <li title="HOME">
            <a href="../HOME/index.php"><span class="label">HOME</span></a>
        </li>
        <li title="Dashboard">
            <a href="index.php"><span class="label">Dashboard</span></a>
        </li>

        <li title="Hotel Bookings">
            <a href="viewHotel.php"><span class="label">View Hotel Bookings</span></a>
        </li>

        <li title="Guide Bookings">
            <a href="viewGuide.php"><span class="label">View Guide Bookings</span></a>
        </li>

        <li title="Place Bookings">
            <a href="viewBooking.php"><span class="label">Place Bookings</span></a>
        </li>
 
       
       
          <li title="Add Tourist Spot">
            <a href="addTourist.php"><span class="label">Add Tourist Spot</span></a>
        </li>
         <li title="Logout">
            <a href="logout.php"><span class="label ">Logout</span></a>
        </li>
    </ul>
</div>

<!-- Sidebar toggle button -->
<button class="sidebar-toggle-btn" id="sidebarToggle"><i class="fa fa-bars"></i></button>

<!-- Mobile overlay -->
<div class="overlay" id="overlay"></div>

<!-- Scripts -->
<script>
$(document).ready(function(){
    // Toggle sidebar on mobile or collapsed
    $('#sidebarToggle').click(function(){
        $('#sidebar').toggleClass('active collapsed');
        $('#overlay').toggleClass('active');
    });

    // Close sidebar by clicking overlay
    $('#overlay').click(function(){
        $('#sidebar').removeClass('active');
        $(this).removeClass('active');
    });
});
</script>

<!-- Styles -->
<style>
/* Sidebar styles */
.sidebar {
    width: 250px;
    min-height: 100vh;
    background: #198754; /* Bootstrap success green */
    color: #fff;
    position: fixed;
    top: 0; left: 0;
    padding-top: 70px; /* extra top padding for navbar */
    transition: width 0.3s, left 0.3s;
    overflow-y: auto;
    z-index: 999;
    font-size: 1.1rem;
}
.sidebar.collapsed { width: 80px; }

.sidebar ul { list-style: none; padding:0; margin:0; }

.sidebar ul li { 
    padding: 16px 24px;
    position: relative; 
}

.sidebar-title {
    text-align: center;
    font-weight: 600;
    font-size: 1.3rem;
    padding: 15px 0;
    background: #145c32; /* darker green for title */
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
.sidebar-title h4 {
    margin: 0;
    color: #fff;
}
.sidebar ul li a { 
    color:#fff; 
    text-decoration:none; 
    display:flex; 
    align-items:center; 
    justify-content:flex-start; 
    transition: all 0.3s; 
    font-weight: 500;
}

.sidebar ul li a .label { 
    margin-left: 15px; 
    transition: opacity 0.3s; 
}

.sidebar.collapsed ul li a .label { 
    opacity:0; 
    pointer-events:none; 
}

.sidebar ul li:hover { 
    background: rgba(0,0,0,0.2); 
    border-radius:8px; 
}

.sidebar ul li i { 
    width:24px; 
    text-align:center; 
    font-size:1.2rem;
}

/* Tooltip for collapsed sidebar */
.sidebar.collapsed ul li[title]:hover::after {
    content: attr(title);
    position: absolute;
    left:80px;
    top:50%;
    transform: translateY(-50%);
    background:#000;
    color:#fff;
    padding:6px 12px;
    border-radius:4px;
    white-space:nowrap;
    font-size:0.95rem;
}

/* Mobile styles */
@media (max-width:992px) {
    .sidebar { left:-250px; }
    .sidebar.active { left:0; }
    .sidebar.collapsed { width:250px; } /* Don't collapse on mobile */
}

/* Mobile overlay */
.overlay {
    display: none;
    position: fixed;
    top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.5);
    z-index: 998;
    transition: 0.3s;
}
.overlay.active { display: block; }
</style>
