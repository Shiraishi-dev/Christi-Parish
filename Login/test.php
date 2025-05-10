<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Wedding Date Picker</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
    }

    .date-label {
      font-size: 18px;
      margin-bottom: 10px;
    }

    input {
      font-size: 16px;
      padding: 8px;
      width: 200px;
    }

    /* Red styling for disabled (booked or weekend) days */
    .flatpickr-day.disabled {
      background-color: #f8d7da !important;
      color: #721c24 !important;
      border-color: #f5c6cb !important;
      cursor: not-allowed;
    }
  </style>
</head>
<body>

  <div>
    <label for="wedding_date" class="date-label">Choose a Wedding Date:</label><br>
    <input type="text" id="wedding_date" name="wedding_date" required>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    const approvedDates = [
      "2025-05-15",
      "2025-05-20",
      "2025-06-01"
    ];

    flatpickr("#wedding_date", {
      dateFormat: "Y-m-d",
      minDate: "today",
      disable: [
        function(date) {
          // Disable Saturdays (6) and Sundays (0)
          return (date.getDay() === 0 || date.getDay() === 6);
        },
        ...approvedDates
      ],
      onDayCreate: function(dObj, dStr, fp, dayElem) {
        const date = dayElem.dateObj.toISOString().split("T")[0];
        if (approvedDates.includes(date) || dayElem.dateObj.getDay() === 0 || dayElem.dateObj.getDay() === 6) {
          dayElem.title = "Not available";
        }
      }
    });
  </script>

</body>
</html>
