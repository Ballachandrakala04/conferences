<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timer Example</title>
    <style>
        #timer {
            padding: 10px;
            font-size: 24px;
            text-align: center;
            border: 1px solid #ccc;
            width: 100px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<div id="timer">0 mins</div>
<input type="hidden" id="time_spent" value="0">

<script>
    const timerDiv = document.getElementById('timer');
    const timeSpent = document.getElementById('time_spent');

    let minutes = 0;

    function updateTimer() {
        minutes++;
        timerDiv.textContent = `${minutes} mins`;
        timeSpent.value = `${minutes}`;

        if (minutes <= 3) {
            timerDiv.style.backgroundColor = 'green';
        } else if (minutes <= 5) {
            timerDiv.style.backgroundColor = 'orange';
        } else {
            timerDiv.style.backgroundColor = 'red';
        }
    }

    setInterval(updateTimer, 10000);
</script>

</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJAX Search with PHP</title>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .search-results {
      max-height: 200px;
      overflow-y: auto;
    }
  </style>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-md mx-auto">
    <input type="text" id="search" class="w-full p-2 border border-gray-300 rounded" placeholder="Search..." oninput="search()">
    <div id="results" class="mt-2 search-results bg-white border border-gray-300 rounded p-2"></div>
  </div>

  <script>
    let typingTimer;
    const typingInterval = 300; // milliseconds

    function search() {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(() => {
        const query = document.getElementById('search').value;
        if (query.length > 0) {
          const xhr = new XMLHttpRequest();
          xhr.open("GET", "search.php?q=" + query, true);
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              document.getElementById('results').innerHTML = xhr.responseText;
            }
          };
          xhr.send();
        } else {
          document.getElementById('results').innerHTML = '';
        }
      }, typingInterval);
    }
  </script>
</body>
</html>
