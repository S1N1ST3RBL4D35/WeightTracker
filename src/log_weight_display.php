<?php
session_start();

include 'conn.php';

//Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

//Fetch user details from session
$user = $_SESSION['user'];

//Fetch the weight logs from the DB
$stmt = $conn->prepare('SELECT log_date, weight, unit FROM weight_logs WHERE user_id = ? ORDER BY log_date DESC');
$stmt->bind_param('i', $user['id']);
$stmt->execute();
$stmt->bind_result($logDate, $weight, $unit);

$weightLogs = [];
while ($stmt->fetch()) {
    $weightLogs[] = ['log_date' => $logDate, 'weight' => $weight, 'unit' => $unit];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="log_weight.css">
    <title>Log Weight</title>
</head>

<body>
    <header>
        <h1>Your Weight Tracker</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="contact.php">Contact Us</a>
            <a href="log_weight_display.php">Log Weight</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main :class="{ 'first-log-background': isFirstLog, 'light-green-background': isLoss, 'light-red-background': isGain }">
        <section id="log-weight-form">
            <div id="log-weight-app">
                <div v-if="showForm" class="log-form">
                    <form @submit.prevent="submitLog">
                        <label for="logDate">Date:</label>
                        <input type="date" id="logDate" v-model="logDate" :max="today" required>

                        <label for="weight">Weight(numeric number):</label>
                        <input type="number" id="weight" v-model="weight" required>

                        <label for="unit">Unit:</label>
                        <select id="unit" v-model="unit">
                            <option value="kg">Kg</option>
                            <option value="lbs">Lbs</option>
                            <option value="stone">Stone</option>
                        </select>

                        <button type="submit">Log Weight</button>
                    </form>
                </div>
                <div v-else class="message">
                    <p>{{ message }}</p>
                </div>
                <button v-if="!showForm && logs.length > 0" @click="showTrends">Show Trends></button>
                <div v-if="showTrends" class="trends">
                    <!-- display trends here -->
                    <p>Initial Weight: {{ trends.initialWeight }} {{ unit }}</p>
                    <p>Total Loss/Gain: {{ trends.totalLossGain }} {{ unit }}</p>
                    <p>Loss Since Last Weigh In: {{ trends.lossSinceLast }} {{ unit }}</p>
                </div>
            </div>
        </section>
    </main>
    <table v-if="logs.length > 0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="log in logs" :key="log.log_date">
                <td>{{ log.log_date }}</td>
                <td>{{ log.weight }}</td>
                <td>{{ log.unit }}</td>
            </tr>
        </tbody>
    </table>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="log_weight.js"></script>
</body>

</html>