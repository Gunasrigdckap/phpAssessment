<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <link rel="stylesheet" href="/assests/css/style.css">
</head>
<body>
    <div class="container">
        <form id="studentForm">
            <h2>Student Registration Form</h2>
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" required>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Submit</button>
        </form>
    </div>
    <div class="studentRecords">
        <input type="text" id="searchInput" placeholder="Search by name...">
        <button id="sorting">click-to-sort</button>
        <h2>Student Records</h2>
        <table id="studentTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows added here -->
            </tbody>
        </table>
    </div>
    <script src="/assests/js/main.js"></script>
</body>
</html>
