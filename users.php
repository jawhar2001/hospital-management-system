<?php
session_start();

include './includes/db.inc.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System | Users</title>
    <link rel="stylesheet" href="./styles/styles.css">

    <style>
        .text-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            gap: 20px;
            justify-content: space-between;
            /* align-items: center; */
            margin-bottom: 10px;
        }

        .group {
            flex: 1;
        }

        .delete-btn {
            background-color: red;
            border: 0;
            color: white;
            padding: 10px 20px;
        }

        .update-btn {
            background-color: green;
            border: 0;
            color: white;
            padding: 10px 20px;
        }
    </style>

</head>

<body>
    <?php include "./partials/navbar.php"; ?>

    <div class="contact-page-container">
        <h1 style="display: block; margin-bottom: 30px;">Users</h1>

        <div>
            <table id="table">
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th></th>
                </tr>

                <?php

                $query = "SELECT * FROM users";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['firstName']; ?></td>
                            <td><?= $row['lastName']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['role']; ?></td>
                            <td>
                                <button id="deleteBtn" class="delete-btn" onclick="openModal(<?= $row['id']; ?>)">Delete</button>
                                <button id="updateBtn" class="update-btn" onclick="openUpdateModal(<?= $row['id']; ?>, '<?= $row['firstName']; ?>', '<?= $row['lastName']; ?>', '<?= $row['email']; ?>', '<?= $row['username']; ?>', '<?= $row['role']; ?>')">Update</button>
                            </td>
                        </tr>

                <?php

                    }
                } else {
                    echo '0 Rows';
                }
                mysqli_close($conn);

                ?>
            </table>

        </div>
    </div>

    <?php include "./partials/footer.php"; ?>

    <script>
        let modal;
        let updateModal;
        let currentUserId;
        let tableNode;

        document.addEventListener("DOMContentLoaded", () => {
            modal = document.getElementById("modal")
            updateModal = document.getElementById("updateModal")
            tableNode = document.getElementById("table")

        })

        function closeModal() {
            modal.style.display = "none"
        }

        function openModal(userId) {
            modal.style.display = "block"
            currentUserId = userId
        }

        function openUpdateModal(userId, firstName, lastName, email, username, role) {
            updateModal.style.display = "block"
            currentUserId = userId

            document.getElementById('firstName').value = firstName;
            document.getElementById('lastName').value = lastName;
            document.getElementById('email').value = email;
            document.getElementById('username').value = username;
            document.getElementById('role').value = role;
        }

        function confirmDelete() {
            closeModal()
            deleteUser(currentUserId)

            const allUsers = Array.from(document.querySelectorAll('table tr'))

            const filteredUsers = allUsers.filter(userNode => {
                const id = Array.from(userNode.children)[0].innerText
                return id != currentUserId;
            })

            const frag = document.createDocumentFragment();
            filteredUsers.forEach(userRow => frag.appendChild(userRow));

            tableNode.innerText = "";
            tableNode.appendChild(frag)
        }



        function deleteUser(id) {
            fetch(`delete-user.php?id=${id}`).then(console.log).catch(console.log)
        }

        function closeUpdateModal() {
            updateModal.style.display = "none";
        }

        function confirmUpdate() {
            const formData = {
                id: currentUserId,
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                username: document.getElementById('username').value,
                role: document.getElementById('role').value
            };

            closeUpdateModal()
            updateUser(formData)
        }

        function updateUser(formData) {
            fetch('update-user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the table row with new values
                        updateTableRow(formData);
                    }
                    console.log(data)
                })
                .catch(console.error);
        }

        function updateTableRow(data) {
            const row = Array.from(document.querySelectorAll('table tr')).find(row => {
                return row.children[0].innerText == data.id;
            });

            if (row) {
                row.children[1].innerText = data.firstName;
                row.children[2].innerText = data.lastName;
                row.children[3].innerText = data.email;
                row.children[4].innerText = data.username;
                row.children[5].innerText = data.role;
            }
        }
    </script>

    <div class="modal" id="modal">
        <div class="overlay"></div>
        <div class="content">
            <h3>Are you sure you want to delete this user ?</h3>

            <div>
                <button onclick="closeModal()">Cancel</button>
                <button style="background-color: red; color: white;" onclick="confirmDelete()">Confirm</button>
            </div>
        </div>
    </div>


    <div class="updateModal" id="updateModal">
        <div class="overlay"></div>
        <div class="content">
            <h3>Update this User</h3>

            <div>
                <div class="row">
                    <div class="group">
                        <label for="firstName">First Name</label>
                        <input id="firstName" type="text" class="text-input">
                    </div>
                    <div class="group">
                        <label for="lastName">Last Name</label>
                        <input id="lastName" type="text" class="text-input">
                    </div>
                </div>

                <div class="row">
                    <div class="group">
                        <label for="email">Email</label>
                        <input id="email" type="text" class="text-input">
                    </div>
                    <div class="group">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="text-input">
                    </div>

                </div>

                <select name="role" id="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div>
                <button onclick="closeUpdateModal()">Cancel</button>
                <button style="background-color: red; color: white;" onclick="confirmUpdate()">Confirm</button>
            </div>
        </div>
    </div>

</body>

</html>