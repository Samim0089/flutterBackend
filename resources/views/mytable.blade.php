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
const apiUrl = "{{ url('/api/mytable') }}";

// Fetch and display users
async function loadUsers() {
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
            </tr>
        `;
    });
}

// Add new user
async function addUser() {
    const name = document.getElementById('name').value;
    const lastName = document.getElementById('lastName').value;
    await fetch(apiUrl, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({name, lastName})
    });
    document.getElementById('name').value = '';
    document.getElementById('lastName').value = '';
    loadUsers();
}

// Update user
async function updateUser(id) {
    const name = document.getElementById(`name-${id}`).value;
    const lastName = document.getElementById(`lastName-${id}`).value;
    await fetch(`${apiUrl}/${id}`, {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({name, lastName})
    });
    loadUsers();
}

// Delete user
async function deleteUser(id) {
    if(confirm('Are you sure you want to delete this user?')) {
        await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
        loadUsers();
    }
}

// Initial load
loadUsers();
</script>

</body>
</html>
