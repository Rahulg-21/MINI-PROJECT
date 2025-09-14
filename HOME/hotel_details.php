<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include '../CONFIG/config.php';

$hotel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch hotel details
$stmt = $conn->prepare("
    SELECT h.*, d.name AS district_name, ts.name AS spot_name, ts.image AS spot_image
    FROM hotels h
    LEFT JOIN districts d ON h.district_id = d.id
    LEFT JOIN tourist_spots ts ON h.spot_id = ts.id
    WHERE h.id = ? AND h.status='Approved'
");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$hotel = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch hotel rooms
$rooms_stmt = $conn->prepare("SELECT * FROM hotel_rooms WHERE hotel_id=? AND available_rooms>0 ORDER BY room_type ASC");
$rooms_stmt->bind_param("i", $hotel_id);
$rooms_stmt->execute();
$rooms_result = $rooms_stmt->get_result();
$rooms_stmt->close();
?>

<?php include 'components/head.php'; ?>
<body>
<?php include 'components/navbar.php'; ?>

<div class="container py-5">
<?php if ($hotel): ?>
    <div class="card shadow-lg p-4 mb-4">
        <div class="row g-4 align-items-center">
            <!-- Hotel Image -->
            <div class="col-md-3 text-center">
                <img src="<?php echo !empty($hotel['image']) ? '../HOTEL/uploads/hotels/'.$hotel['image'] : 'assets/default_hotel.png'; ?>" 
                     class="rounded shadow" 
                     style="width:200px; height:150px; object-fit:cover;" alt="Hotel">
            </div>

            <!-- Hotel Info -->
            <div class="col-md-9">
                <h3 class="fw-bold mb-2"><?php echo $hotel['name']; ?></h3>
                <p class="mb-1"><strong>Email:</strong> <?php echo $hotel['email']; ?></p>
                <p class="mb-1"><strong>Mobile:</strong> <?php echo $hotel['mobile']; ?></p>
                <p class="mb-1"><strong>District:</strong> <?php echo $hotel['district_name'] ?? 'N/A'; ?></p>
                <?php if (!empty($hotel['spot_name'])): ?>
                    <p class="mb-0 text-muted"><em>Nearby Spot: <?php echo $hotel['spot_name']; ?></em></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Available Rooms -->
    <h5 class="mb-3">🏨 Available Rooms</h5>
    <div class="row g-4 mb-4">
        <?php if ($rooms_result->num_rows > 0): ?>
            <?php while($room = $rooms_result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title fw-bold"><?php echo htmlspecialchars($room['room_type']); ?></h6>
                        <p class="card-text"><?php echo htmlspecialchars(substr($room['description'], 0, 80)); ?>...</p>
                        <p class="mb-1"><strong>Price:</strong> ₹<?php echo $room['price']; ?> / night</p>
                        <p class="mb-1"><strong>Available:</strong> <?php echo $room['available_rooms']; ?></p>
                    </div>
                    <?php if ($room['available_rooms'] > 0): ?>
                    <div class="card-footer text-center">
                        <button class="btn btn-success bookRoomBtn" 
                                data-room_id="<?= $room['id'] ?>" 
                                data-room_type="<?= htmlspecialchars($room['room_type'], ENT_QUOTES) ?>">
                                Book Now
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="card-footer text-center text-danger">Fully Booked</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">No rooms available at the moment.</p>
        <?php endif; ?>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="book_room.php">
            <div class="modal-header">
              <h5 class="modal-title">Book Room</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="room_id" id="modal_room_id">
              <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
              
              <div class="mb-3">
                  <label class="form-label">Room Type</label>
                  <input type="text" id="modal_room_type" class="form-control" readonly>
              </div>

              <div class="mb-3">
                  <label class="form-label">Booking Date</label>
                  <input type="date" name="booking_date" class="form-control" required>
              </div>

              <div class="mb-3">
                  <label class="form-label">Booking Time</label>
                  <input type="time" name="booking_time" class="form-control" required>
              </div>

              <div class="mb-3">
                  <label class="form-label">Notes / Special Request</label>
                  <textarea name="notes" class="form-control" rows="3" placeholder="Optional"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Confirm Booking</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php else: ?>
    <p class="text-danger">❌ Hotel not found or not approved.</p>
<?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const bookingBtns = document.querySelectorAll(".bookRoomBtn");
    const bookingModalEl = document.getElementById("bookingModal");
    const bookingModal = new bootstrap.Modal(bookingModalEl);

    bookingBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            document.getElementById("modal_room_id").value = this.dataset.room_id;
            document.getElementById("modal_room_type").value = this.dataset.room_type;
            bookingModal.show();
        });
    });
});
</script>
</body>
</html>
