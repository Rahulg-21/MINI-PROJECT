
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
      <!-- Sidebar Title -->
    <div class="sidebar-title">
        <h4>Admin</h4>
    </div>
    <ul>
        <li title="Dashboard">
            <a href="index.php"><i class="fa fa-tachometer"></i><span class="label">Dashboard</span></a>
        </li>
        <li title="Pages">
            <a href="#pagesSubmenu" class="submenu-toggle">
                <i class="fa fa-list-ul"></i>
                <span class="label">Pages</span>
                <i class="fa fa-angle-down ms-auto"></i>
            </a>
            <ul class="collapse" id="pagesSubmenu">
                <li><a href="addpage.php">➕ Add</a></li>
                <li><a href="managepage.php">⚙ Manage</a></li>
            </ul>
        </li>
          <li title="Emergency">
            <a href="#touristSubmenu" class="submenu-toggle">
                <i class="fa fa-map-marker"></i>
                <span class="label">Emergency</span>
                <i class="fa fa-angle-down ms-auto"></i>
            </a>
            <ul class="collapse" id="touristSubmenu">
                <li><a href="addemergency.php">➕ Add</a></li>
                <li><a href="manageemergency.php">⚙ Manage</a></li>
            </ul>
        </li>
        <li title="Hotels">
            <a href="#touristSubmenu" class="submenu-toggle">
                <i class="fa fa-map-marker"></i>
                <span class="label">Hotels</span>
                <i class="fa fa-angle-down ms-auto"></i>
            </a>
            <ul class="collapse" id="touristSubmenu">
                <li><a href="approveHotel.php">➕ Approve</a></li>
                <li><a href="manageHotel.php">⚙ Manage</a></li>
            </ul>
        </li>
        
        <li title="weather report"><a href="sendEmail.php"><i class="fa fa-users"></i><span class="label">weather report</span></a></li>

        <li title="Tourist Spots">
            <a href="#touristSubmenu" class="submenu-toggle">
                <i class="fa fa-map-marker"></i>
                <span class="label">Tourist Spots</span>
                <i class="fa fa-angle-down ms-auto"></i>
            </a>
            <ul class="collapse" id="touristSubmenu">
                <li><a href="addtourist.php">➕ Add</a></li>
                <li><a href="managespot.php">⚙ Manage</a></li>
            </ul>
        </li>

        <li title="Approve Guide">
            <a href="#GuideSubmenu" class="submenu-toggle">
                <i class="fa fa-map-marker"></i>
                <span class="label">Approve Guide</span>
                <i class="fa fa-angle-down ms-auto"></i>
            </a>
            <ul class="collapse" id="touristSubmenu">
                <li><a href="approveGuide.php">➕ Approve</a></li>
                <li><a href="manageGuide.php">⚙ Manage</a></li>
            </ul>
        </li>


        <li title="Approve Spots"><a href="approvetouristspot.php"><i class="fa fa-users"></i><span class="label">Approve Spots</span></a></li>

        <li title="View Contact Msg"><a href="viewContact.php"><i class="fa fa-users"></i><span class="label">View Contact Msg</span></a></li>

        

        <li title="Logout"><a href="logout.php"><i class="fa fa-sign-out"></i><span class="label">Logout</span></a></li>
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

    // Submenu toggle
    $('.submenu-toggle').click(function(e){
        e.preventDefault();

        // Close other open submenus
        $(this).parent().siblings().find('ul').slideUp();
        $(this).parent().siblings().find('.fa-angle-down').removeClass('rotate');

        // Toggle current submenu
        $(this).next('ul').slideToggle();
        $(this).find('.fa-angle-down').toggleClass('rotate');
    });
});
</script>


<!-- Styles -->
<style>
/* Sidebar styles */
.sidebar {
    width: 250px;
    min-height: 100vh;
    background: #212529;
    color: #fff;
    position: fixed;
    top: 0; left: 0;
    padding-top: 70px; /* extra top padding for navbar */
    transition: width 0.3s, left 0.3s;
    overflow-y: auto;
    z-index: 999;
    font-size: 1.1rem; /* increase font size */
}
.sidebar.collapsed { width: 80px; }

.sidebar ul { list-style: none; padding:0; margin:0; }

.sidebar ul li { 
    padding: 16px 24px; /* increased padding for bigger clickable area */
    position: relative; 
}
/* Sidebar Title */
.sidebar-title {
    text-align: center;
    font-weight: 600;
    font-size: 1.3rem;
    padding: 15px 0;
    background: #343a40;
    border-bottom: 1px solid rgba(255,255,255,0.1);
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
    font-weight: 500; /* slightly bolder */
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
    background: rgba(255,255,255,0.15); 
    border-radius:8px; 
}

.sidebar ul li i { 
    width:24px; /* slightly bigger icons */
    text-align:center; 
    font-size:1.2rem; /* icon size increase */
}

.sidebar ul li ul { display:none; padding-left:20px; }

.sidebar ul li ul li { 
    padding:12px 24px; /* submenu padding increased */
    font-size:1rem;
}

.fa-angle-down.rotate { 
    transform: rotate(180deg); 
    transition:0.3s; 
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
