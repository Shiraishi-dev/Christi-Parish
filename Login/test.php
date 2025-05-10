<?php
// Simulate booked slots for different dates
$booked_slots = [
    '2025-05-12' => ['09:00', '13:00'], // Booked slots for May 12
    '2025-05-15' => ['08:00', '15:00'], // Booked slots for May 15
];

$time_slots = [
    '08:00' => '8:00 AM - 9:00 AM',
    '09:00' => '9:00 AM - 10:00 AM',
    '13:00' => '1:00 PM - 2:00 PM',
    '15:00' => '3:00 PM - 4:00 PM',
];

$available_dates = array_keys($booked_slots);
?>

<form method="POST">
    <label for="wedding_date">Select Date:</label>
    <select name="wedding_date" id="wedding_date" required onchange="updateTimeSlots()">
        <option value="">-- Choose a date --</option>
        <?php foreach ($available_dates as $date): ?>
            <option value="<?= $date ?>"><?= $date ?></option>
        <?php endforeach; ?>
    </select>

    <label for="time_slot">Select Time Slot:</label>
    <select name="time_slot" id="time_slot" required>
        <option value="">-- Choose a time --</option>
    </select>

    <button type="submit">Submit</button>
</form>

<script>
function updateTimeSlots() {
    var selectedDate = document.getElementById('wedding_date').value;
    var timeSlotSelect = document.getElementById('time_slot');
    timeSlotSelect.innerHTML = '<option value="">-- Choose a time --</option>';

    var bookedSlots = <?= json_encode($booked_slots) ?>;
    var allTimeSlots = <?= json_encode($time_slots) ?>;

    if (selectedDate && bookedSlots[selectedDate]) {
        Object.keys(allTimeSlots).forEach(function(slot) {
            if (bookedSlots[selectedDate].includes(slot)) {
                timeSlotSelect.innerHTML += `<option value="" disabled style="color:red;">${allTimeSlots[slot]} (Booked)</option>`;
            } else {
                timeSlotSelect.innerHTML += `<option value="${slot}">${allTimeSlots[slot]}</option>`;
            }
        });
    } else {
        Object.keys(allTimeSlots).forEach(function(slot) {
            timeSlotSelect.innerHTML += `<option value="${slot}">${allTimeSlots[slot]}</option>`;
        });
    }
}

// Ensure function runs when page loads (for default selections)
document.addEventListener("DOMContentLoaded", function() {
    updateTimeSlots();
});
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_date = $_POST['wedding_date'] ?? '';
    $selected_time = $_POST['time_slot'] ?? '';

    if (!empty($selected_date) && !empty($selected_time)) {
        echo "<p>You selected: <strong>" . htmlspecialchars($selected_date) . " - " . htmlspecialchars($time_slots[$selected_time]) . "</strong></p>";
    }
}
?>
