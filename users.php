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
                    <th>Role</th>
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
                                <!-- <button id="deleteBtn" onclick="deleteUser(<?= $row['id']; ?>)">Delete</button> -->
                                <button id="deleteBtn" onclick="openModal(<?= $row['id']; ?>)">Delete</button>
                                <button>Update</button>
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
        let currentUserId;
        let tableNode;

        document.addEventListener("DOMContentLoaded", () => {
            modal = document.getElementById("modal")
            tableNode = document.getElementById("table")

        })

        function closeModal() {
            modal.style.display = "none"
        }

        function openModal(userId) {
            modal.style.display = "block"
            currentUserId = userId
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
            <h3>Are you sure you want to delete this user ?</h3>

            <div>
                <button onclick="closeModal()">Cancel</button>
                <button style="background-color: red; color: white;" onclick="confirmDelete()">Confirm</button>
            </div>
        </div>
    </div>

</body>

</html>