<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
        }

        table,
        table th,
        table td {
            border: solid 1px #000;
        }

        a {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <h3>Danh sách người dùng</h3>
    <table>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>password</th>
            <th>Action</th>
        </tr>
        <?php
            include 'showdata.php'; 
        ?>
</body>

</html>