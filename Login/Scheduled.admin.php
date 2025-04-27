<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Real Event Calendar</title>
  <link rel="stylesheet" href="styles/schedule.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="side-header">
      <img src="includes/logo.jpg" alt="logo">
      <h2 class="title-a">Corpus Christi Parish</h2>
    </div>

    <ul class="sidebar-links">
      <h4><span>Book Request</span></h4>
      <li><a href="wedding.admin.php"><span class="material-symbols-outlined">concierge</span>Wedding</a></li>
      <li><a href="baptismal.admin.php"><span class="material-symbols-outlined">concierge</span>Baptismal</a></li>
      <li><a href="burial.admin.php"><span class="material-symbols-outlined">concierge</span>Burial</a></li>
      <h4><span>Menu</span></h4>
      <li><a href="pending.book.admin.php"><span class="material-symbols-outlined">pending_actions</span>Pending Booked</a></li>
      <li><a href="Scheduled.admin.php"><span class="material-symbols-outlined">event</span>Events Schedule</a></li>
      <li><a href="index.php"><span class="material-symbols-outlined">logout</span>Logout</a></li>
    </ul>

    <div class="user-account">
      <div class="user-profile">
        <img src="includes/profile.jpg" alt="profile-img">
        <div class="user-detail">
          <h3>Escobido, Kim L.</h3>
          <span>Admin</span>
        </div>
      </div>
    </div>
  </aside>

  <div class="top1"></div>

  <!-- Calendar -->
  <div class="calendar-container">
    <div class="calendar-header">
      <button id="prevMonth">&lt;</button>
      <h2 id="monthYear"></h2>
      <button id="nextMonth">&gt;</button>
    </div>
    <div class="calendar" id="calendar"></div>
  </div>

  <!-- Modal -->
  <div class="modal" id="eventModal">
    <div class="modal-content">
      <span class="close-button" id="closeEventModal">&times;</span>
      <h3 id="modalDate">Events on </h3>
      <ul id="eventList"></ul>
    </div>
  </div>

  <script>
    const calendar = document.getElementById('calendar');
    const modal = document.getElementById('eventModal');
    const closeModal = document.getElementById('closeEventModal');
    const modalDate = document.getElementById('modalDate');
    const eventList = document.getElementById('eventList');
    const monthYear = document.getElementById('monthYear');
    const prevMonth = document.getElementById('prevMonth');
    const nextMonth = document.getElementById('nextMonth');

    const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    let currentDate = new Date();

    const events = {
      "2025-04-30": ["Event End April"],
      "2025-05-05": ["Wedding Ceremony"],
      "2025-05-10": ["Baptismal Service"],
      "2025-05-27": ["Youth Camp"],
      "2025-06-01": ["Start of June Event"]
    };

    function renderCalendar(date) {
      calendar.innerHTML = "";

      // Day names
      dayNames.forEach(name => {
        const dayName = document.createElement('div');
        dayName.className = 'day-name';
        dayName.textContent = name;
        calendar.appendChild(dayName);
      });

      const year = date.getFullYear();
      const month = date.getMonth();

      monthYear.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

      const firstDay = new Date(year, month, 1);
      const startDay = firstDay.getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      // Empty cells before 1st
      for (let i = 0; i < startDay; i++) {
        const empty = document.createElement('div');
        calendar.appendChild(empty);
      }

      for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement('div');
        dayDiv.className = 'day';
        const dateStr = `${year}-${(month+1).toString().padStart(2,'0')}-${day.toString().padStart(2,'0')}`;
        dayDiv.dataset.date = dateStr;
        dayDiv.textContent = day;

        if (events[dateStr]) {
          const dot = document.createElement('div');
          dot.className = 'event-dot';
          dayDiv.appendChild(dot);
        }

        if (new Date().toDateString() === new Date(year, month, day).toDateString()) {
          dayDiv.classList.add('today');
        }

        dayDiv.addEventListener('click', function() {
          if (events[dateStr]) {
            modalDate.textContent = `Events on ${dateStr}`;
            eventList.innerHTML = '';
            events[dateStr].forEach(ev => {
              const li = document.createElement('li');
              li.textContent = ev;
              eventList.appendChild(li);
            });
            modal.style.display = 'flex';
          }
        });

        calendar.appendChild(dayDiv);
      }
    }

    closeModal.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target == modal) {
        modal.style.display = 'none';
      }
    });

    prevMonth.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar(currentDate);
    });

    nextMonth.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
  </script>

</body>
</html>
