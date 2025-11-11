<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mytable CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-100">

<h1 class="text-3xl font-bold mb-6">Mytable CRUD</h1>

<!-- Add User Form -->
<div class="mb-6 p-4 bg-white rounded shadow">
    <h2 class="font-bold mb-2">Add New User</h2>
    <input type="text" id="name" placeholder="Name" class="border p-2 mr-2">
    <input type="text" id="lastName" placeholder="Last Name" class="border p-2 mr-2">
    <button onclick="addUser()" class="bg-blue-500 text-white px-4 py-2 rounded">Add</button>
</div>

<!-- Users Table -->
<div class="p-4 bg-white rounded shadow">
    <h2 class="font-bold mb-2">Users</h2>
    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
        <tr class="bg-gray-200">
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Last Name</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody id="usersTable">
        <!-- Users will appear here -->
        </tbody>
    </table>
</div>

<script>
const apiUrl = "/api/mytable"; // Use relative path on Railway

// Fetch and display users
async function loadUsers() {
    try {
        const res = await fetch(apiUrl);
        const data = await res.json();
        const table = document.getElementById('usersTable');
        table.innerHTML = '';
        data.data.forEach(user => {
            table.innerHTML += `
            <tr class="text-center">
                <td class="border px-4 py-2">${user.id}</td>
                <td class="border px-4 py-2"><input type="text" value="${user.name}" id="name-${user.id}" class="border p-1 w-full"></td>
                <td class="border px-4 py-2"><input type="text" value="${user.lastName}" id="lastName-${user.id}" class="border p-1 w-full"></td>
                <td class="border px-4 py-2">
                    <button onclick="updateUser(${user.id})" class="bg-green-500 text-white px-2 py-1 rounded mr-2">Update</button>
                    <button onclick="deleteUser(${user.id})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </td>
            </tr>`;
        });
    } catch (err) {
        alert("Failed to load users: " + err.message);
        console.error(err);
    }
}

// Add new user
async function addUser() {
    const name = document.getElementById('name').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    if (!name || !lastName) {
        alert("Please enter both name and last name!");
        return;
    }

    try {
        const res = await fetch(apiUrl, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({name, lastName})
        });

        if (!res.ok) {
            const err = await res.json();
            alert("Failed to add user: " + (err.message || JSON.stringify(err)));
            return;
        }

        const data = await res.json();
        console.log("Added user:", data);
        document.getElementById('name').value = '';
        document.getElementById('lastName').value = '';
        loadUsers();
    } catch (err) {
        alert("Error adding user: " + err.message);
        console.error(err);
    }
}

// Update user
async function updateUser(id) {
    const name = document.getElementById(`name-${id}`).value.trim();
    const lastName = document.getElementById(`lastName-${id}`).value.trim();

    if (!name || !lastName) {
        alert("Please enter both name and last name!");
        return;
    }

    try {
        const res = await fetch(`${apiUrl}/${id}`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({name, lastName})
        });

        if (!res.ok) {
            const err = await res.json();
            alert("Failed to update user: " + (err.message || JSON.stringify(err)));
            return;
        }

        const data = await res.json();
        console.log("Updated user:", data);
        loadUsers();
    } catch (err) {
        alert("Error updating user: " + err.message);
        console.error(err);
    }
}

// Delete user
async function deleteUser(id) {
    if (!confirm('Are you sure you want to delete this user?')) return;

    try {
        const res = await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
        if (!res.ok) {
            const err = await res.json();
            alert("Failed to delete user: " + (err.message || JSON.stringify(err)));
            return;
        }
        console.log("Deleted user:", id);
        loadUsers();
    } catch (err) {
        alert("Error deleting user: " + err.message);
        console.error(err);
    }
}

// Initial load
loadUsers();
</script>

</body>
</html>
