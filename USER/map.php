<?php 
include '../CONFIG/config.php';
include 'components/head.php'; 
?>
<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<!-- Kerala Map -->
<div id="map-wrapper">
  <div id="map-background">
    <div id="map-container" class="mb-4 text-center">
      <img src="assets/img/Kerala-map.svg" alt="Kerala Map" id="kerala-map">
    </div>
  </div>
</div>

<!-- District Cards -->
<section id="districts" class="container">
  <div class="district-grid">
    <?php
    $sql = "SELECT * FROM districts ORDER BY name ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '
        <div class="district-card">
          <a href="explore.php?id='.$row['id'].'">
            <img src="assets/img/districts/'.$row['image'].'" alt="'.$row['name'].'">
          </a>
          <h3>'.$row['name'].'</h3>
        </div>
        ';
      }
    } else {
      echo "<p>No districts found.</p>";
    }
    ?>
  </div>
</section>

<?php include 'components/footer.php'; ?>

<style>

  .district-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 20px;
  margin-top: 30px;
}
.district-card {
  text-align: center;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.district-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.district-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  display: block;
}
.district-card h3 {
  padding: 10px;
  margin: 0;
  font-size: 1rem;
}
/* Map Styling */
#map-wrapper {
  max-width: 1100px;
  margin: 30px auto;
  padding: 0 15px;
}

#map-background {
  background: linear-gradient(135deg, #c3e8ff, #f9f9f9);
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

#map-container {
  display: flex;
  justify-content: center;
}

#kerala-map {
  width: 100%;
  height: auto;
  max-width: 600px;
  display: block;
}

/* District Cards */
#districts {
  margin-top: 40px;
}
.district-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}
.district-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  overflow: hidden;
  text-align: center;
  transition: transform 0.2s ease-in-out;
}
.district-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
}
.district-card h3 {
  margin: 10px 0;
  font-size: 1.1rem;
}
.district-card:hover {
  transform: translateY(-5px);
}

/* Responsive */
@media (max-width: 576px) {
  #kerala-map {
    max-width: 100%;
  }
  .district-card img {
    height: 120px;
  }
}
</style>
