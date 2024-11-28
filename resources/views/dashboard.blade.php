<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Scheduler & API Caching</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
  <div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <header class="mb-6">
      <h1 class="text-3xl font-bold text-gray-700">Task Scheduler & API Caching</h1>
      <p class="text-gray-600">Manage and monitor API caching and log cleaning tasks.</p>
    </header>

    <!-- Cached Data Section -->
    <section class="mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Cached Data</h2>
      <div id="cached-data" class="p-4 bg-white rounded shadow">
        <p class="text-gray-600">Loading cached data...</p>
      </div>
    </section>

    <!-- Actions Section -->
    <section class="mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Actions</h2>
      <div class="flex space-x-4">
        <button id="refresh-cache" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
          Refresh Cache
        </button>
        <button id="clear-logs" class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600">
          Clear Old Logs
        </button>
      </div>
    </section>

    <!-- Logs Section -->
    <section>
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Logs</h2>
      <div id="logs" class="p-4 bg-white rounded shadow">
        <p class="text-gray-600">Fetching logs...</p>
      </div>
    </section>
  </div>

  <script>
    // Fetch and display cached data
    async function fetchCachedData() {
      const cachedDataContainer = document.getElementById('cached-data');
      try {
        const response = await fetch('/fetch');
        const data = await response.json();
        cachedDataContainer.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
      } catch (error) {
        cachedDataContainer.innerHTML = '<p class="text-red-500">Failed to fetch cached data.</p>';
      }
    }

    // Fetch and display logs
    async function fetchLogs() {
      const logsContainer = document.getElementById('logs');
      try {
        const response = await fetch('/api/logs'); // Ensure this route returns logs
        const logs = await response.json();
        logsContainer.innerHTML = logs
          .map(
            (log) =>
              `<div class="mb-2">
                <p><strong>Endpoint:</strong> ${log.endpoint}</p>
                <p><strong>Response:</strong> <pre>${log.response}</pre></p>
                <p><strong>Requested At:</strong> ${log.requested_at}</p>
              </div>`
          )
          .join('');
      } catch (error) {
        logsContainer.innerHTML = '<p class="text-red-500">Failed to fetch logs.</p>';
      }
    }

    // Trigger refresh cache action
    document.getElementById('refresh-cache').addEventListener('click', async () => {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        await fetch('/refresh-cache', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,  // Add CSRF token here
        },
        });

        alert('Cache refreshed successfully!');
        fetchCachedData(); // Reload cached data
    } catch (error) {
        alert('Failed to refresh cache.');
    }
    });

    // Trigger clear logs action
    document.getElementById('clear-logs').addEventListener('click', async () => {
      try {
        await fetch('/api/clear-logs', { method: 'POST' });
        alert('Old logs cleared successfully!');
        fetchLogs(); // Reload logs
      } catch (error) {
        alert('Failed to clear logs.');
      }
    });

    // Initialize page
    fetchCachedData();
    fetchLogs();
  </script>
</body>
</html>
