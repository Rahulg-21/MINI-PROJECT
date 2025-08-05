<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ExploreScape</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom CSS -->
  <style>
    * {
      padding: 0;
      margin: 0;
      border: none;
      outline: none;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      background-image: url('img/bac%204.png');
      background-size: cover;
      background-position: top;
      background-repeat: no-repeat;
      overflow: hidden;
      animation: backgroundImage 1.6s ease-out forwards;
    }

    body::after {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
      background: linear-gradient(transparent 50%, rgb(0, 0, 0));
    }

    header nav {
      backdrop-filter: blur(5px);
      background-color: rgba(255, 255, 255, 0.2) !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
      animation: topIn 1.2s ease-out forwards;
    }

    .nav-link {
      font-size: 18px;
      font-weight: 500;
      letter-spacing: 2px;
      color: rgb(53, 53, 53) !important;
      padding: 10px 15px;
      border-radius: 20px 20px 0 0;
      transition: all 0.3s;
    }

    .nav-link.active,
    .nav-link:hover {
      background-color: #16423c;
      color: white !important;
    }

    .title h3 {
      font-size: 1.5rem;
      font-weight: 400;
      letter-spacing: 15px;
      color: white;
      animation: bottomInText 1s ease-out forwards;
    }

    .title h1 {
      font-size: calc(3rem + 5vw);
      font-weight: 800;
      letter-spacing: 0.4em;
      text-transform: uppercase;
      color: white;
      margin: -20px 0;
      animation: bottomInText 1.2s ease-out forwards;
    }

    p {
      font-size: 14px;
      font-weight: 300;
      letter-spacing: 1px;
      line-height: 1.8;
      color: rgba(255, 255, 255, 0.7);
      text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
      animation: bottomInText 1.2s ease-out forwards;
      animation-delay: 0.2s;
      opacity: 0;
    }

    .cta button {
      font-size: 18px;
      font-weight: 400;
      letter-spacing: 3px;
      text-transform: uppercase;
      background-color: transparent;
      border: 1px solid rgba(255, 255, 255, 0.8);
      color: rgba(255, 255, 255, 0.8);
      border-radius: 50px;
      padding: 10px 30px;
      gap: 8px;
      transition: all 0.2s;
      animation: bottomInText 1.2s ease-out forwards;
      animation-delay: 0.3s;
      opacity: 0;
    }

    .cta button:hover {
      background-color: rgba(255, 255, 255, 0.8);
      color: rgb(53, 53, 53);
    }

    .slider i {
      font-size: 2rem;
      color: rgba(255, 255, 255, 0.4);
      animation: zoomOut 1.2s ease-out forwards;
    }

    .back-1, .back-2, .back-3 {
      animation: bottomIn 1s ease-out forwards;
    }

    .back-2 { animation-delay: 0.3s; }
    .back-3 { animation-delay: 0.6s; }

    @keyframes bottomIn {
      from { transform: translateY(200px); }
      to { transform: translateY(0); }
    }

    @keyframes bottomInText {
      from { transform: translateY(500px); }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes backgroundImage {
      from { background-position: top; }
      to { background-position: 50% 14%; }
    }

    @keyframes topIn {
      from { transform: translateY(-100%); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes zoomOut {
      from { transform: scale(1.5); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<body>
  <header class="position-absolute top-0 start-0 w-100 z-3">
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-opacity-25">
   
    </nav>
  </header>

  <main class="position-relative vh-100 overflow-hidden content">
    <img src="img/bac%203.png" alt="background" class="position-absolute w-100 back-3" style="bottom: -12%;">
    <img src="img/bac%202.2.png" alt="background" class="position-absolute w-100 back-2">
    <img src="img/bac%201.png" alt="background" class="position-absolute w-100 back-1">

    <div class="position-absolute top-50 start-50 translate-middle text-center title">
      <h3>The Land of Serene Beauty</h3>
      <h1>Kerala</h1>
    </div>

    <div class="position-absolute bottom-25 start-50 translate-middle-x text-center text-white info-wrap">
      <p class="w-75 mx-auto">
        Kerala is a tropical paradise in southern India, known for its breathtaking landscapes, rich culture, and serene backwaters. Whether you're seeking adventure, relaxation, or a taste of India's unique traditions, Kerala has something for everyone.
      </p>
    </div>

    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 cta">
      <button class="btn">
        Explore More <i class="fa-solid fa-arrow-right ms-2"></i>
      </button>
    </div>

    <div class="position-absolute top-50 start-0 w-100 px-4 d-flex justify-content-between slider">
      <i class="fa-solid fa-chevron-left"></i>
      <i class="fa-solid fa-chevron-right"></i>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>