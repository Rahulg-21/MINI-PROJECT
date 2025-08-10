<div class="sidebar-menu">
    <header class="logo1">
        <a href="#" class="sidebar-icon">
            <span class="fa fa-bars"></span>
        </a>
    </header>

    <div style="border-top: 1px ridge rgba(255, 255, 255, 0.15)"></div>

    <div class="menu">
        <ul id="menu">
            <li>
                <a href="index.php">
                    <i class="fa fa-tachometer"></i>
                    <span>Dashboard</span>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li id="menu-academico">
                <a href="#">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    <span>Pages</span>
                    <span class="fa fa-angle-right" style="float: right"></span>
                    <div class="clearfix"></div>
                </a>
                <ul id="menu-academico-sub">
                    <li id="menu-academico-avaliacoes">
                        <a href="addpage.php">Add</a>
                    </li>
                    <li id="menu-academico-avaliacoes">
                        <a href="managepage.php">Manage</a>
                    </li>
                </ul>
            </li>

            <li id="menu-academico">
                <a href=" ">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span>View</span>
                    <div class="clearfix"></div>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="clearfix"></div>

<!-- Sidebar Toggle Script -->
<script>
    var toggle = true;

    $(".sidebar-icon").click(function () {
        if (toggle) {
            $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
            $("#menu span").css({ "position": "absolute" });
        } else {
            $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
            setTimeout(function () {
                $("#menu span").css({ "position": "relative" });
            }, 400);
        }
        toggle = !toggle;
    });
</script>

<!-- JS -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Sticky Header Script -->
<script>
    $(document).ready(function () {
        var navoffeset = $(".header-main").offset().top;
        $(window).scroll(function () {
            var scrollpos = $(window).scrollTop();
            if (scrollpos >= navoffeset) {
                $(".header-main").addClass("fixed");
            } else {
                $(".header-main").removeClass("fixed");
            }
        });
    });
</script>
</body>
</html>
