<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>
    <link   rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <div class="logo-circle" onclick="hideSections()">
                <img src="images/logo.svg" id="logo">
            </div>
        </div>
        <div class="nav-right">
            <button class="navbarbuttons" onclick="showSection('create')">Create</button>
            <button class="navbarbuttons" onclick="showSection('read')">Read</button>
            <button class="navbarbuttons" onclick="showSection('update')">Update</button>
            <button class="navbarbuttons" onclick="showSection('delete')">Delete</button>
        </div>
    </nav>
    <section id="home" class="homecontent"> 
        <h1 class="splash">Welcome to Student Management System</h1>
        <h2 class="splash">A Project in Integrative Programming Technologies</h2>
    </section>
    
    <!-- CREATE SECTION -->
    <section id="create" class="content">
        <h1 class="contenttitle"> Insert New Student </h1>

    <form action="includes/insert.php" method="POST">
        <label for="surname" class="label">Surname</label>
        <input type="text" name="surname" id="surname" class="field" required oninput="this.value=this.value.replace(/[0-9]/g,'')"><br/>

        <label for="name" class="label">Name</label>
        <input type="text" name="name" id="name" class="field" required oninput="this.value=this.value.replace(/[0-9]/g,'')"><br/>

        <label for="middlename" class="label">Middle name</label>
        <input type="text" name="middlename" id="middlename" class="field" oninput="this.value=this.value.replace(/[0-9]/g,'')"><br/>

        <label for="address" class="label">Address</label>
        <input type="text" name="address" id="address" class="field"><br/>

        <label for="contact" class="label">Mobile Number</label>
        <input type="text" name="contact" id="contact" class="field" maxlength="20" oninput="this.value=this.value.replace(/[^0-9+\-]/g,'')"><br/>

        <div id="btncontainer">
            <button type="button" id="clrbtn" class="btns" onclick="clearFields()">Clear Fields</button><br/>
            <button type="submit" id="savebtn" class="btns">Save</button>
        </div>

        <div id="success-toast" class="toast-hidden">
            Registration Successful!
        </div>
    </form>   

    </section>

    <!-- READ SECTION -->
    <section id="read" class="content">
        <h1 class="contenttitle"> View Students </h1>

        <table class="student-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Middle Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once 'includes/db.php';
                    try {
                        $sql = "SELECT * FROM students ORDER BY id ASC";
                        $stmt = $pdo->query($sql);
                        $students = $stmt->fetchAll();

                        if (count($students) > 0) {
                            foreach ($students as $student) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($student['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($student['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($student['surname']) . "</td>";
                                echo "<td>" . htmlspecialchars($student['middlename'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($student['address'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($student['contact_number'] ?? '') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;'>No records found</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='6' style='text-align:center;'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </section>

    <!-- UPDATE SECTION -->
    <section id="update" class="content">
        <h1 class="contenttitle"> Update Student Record </h1>

        <form id="selectStudentForm">
            <label for="select_id" class="label">Student ID</label>
            <input type="number" name="select_id" id="select_id" class="field" required>
            <button type="button" id="fetchbtn" class="btns" onclick="fetchStudent()">Fetch Student</button><br/>
        </form>

        <br/>

        <form action="includes/update.php" method="POST" id="updateForm" style="display:none;">
            <input type="hidden" name="update_id" id="update_id">

            <label for="update_surname" class="label">Surname</label>
            <input type="text" name="update_surname" id="update_surname" class="field" required oninput="this.value=this.value.replace(/[0-9]/g,'')"><br/>

            <label for="update_name" class="label">Name</label>
            <input type="text" name="update_name" id="update_name" class="field" required oninput="this.value=this.value.replace(/[0-9]/g,'')"><br/>

            <label for="update_middlename" class="label">Middle name</label>
            <input type="text" name="update_middlename" id="update_middlename" class="field" oninput="this.value=this.value.replace(/[0-9]/g,'')"><br/>

            <label for="update_address" class="label">Address</label>
            <input type="text" name="update_address" id="update_address" class="field"><br/>

            <label for="update_contact" class="label">Mobile Number</label>
            <input type="text" name="update_contact" id="update_contact" class="field" maxlength="20" oninput="this.value=this.value.replace(/[^0-9+\-]/g,'')"><br/>

            <div id="btncontainer">
                <button type="button" class="btns" onclick="clearUpdateFields()">Clear Fields</button><br/>
                <button type="submit" class="btns">Update</button>
            </div>
        </form>
    </section>

    <!-- DELETE SECTION -->
    <section id="delete" class="content">
        <h1 class="contenttitle"> Delete Student Record </h1>

        <form action="includes/delete.php" method="POST" id="deleteForm">
            <label for="delete_id" class="label">Student ID</label>
            <input type="number" name="delete_id" id="delete_id" class="field" required><br/>

            <div id="student-info-display" style="display:none;">
                <p class="label" style="width:auto;"><strong>Student found:</strong> <span id="delete_student_name"></span></p>
            </div>

            <div id="btncontainer">
                <button type="button" class="btns" onclick="previewDeleteStudent()">Search Student</button><br/>
                <button type="submit" id="deletebtn" class="btns" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
            </div>
        </form>
    </section>

    <!-- Toast messages -->
    <div id="update-toast" class="toast-hidden">
        Record Updated Successfully!
    </div>
    <div id="delete-toast" class="toast-hidden">
        Record Deleted Successfully!
    </div>

    <script src="script.js"></script>
</body>
</html>
