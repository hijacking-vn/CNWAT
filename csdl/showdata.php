<?php
        include "connect.php";
        $sql = "SELECT * FROM user";
        $result = $conn->query($sql);

        // constant
        $rowsPerPage = 3;
        $numPage = ceil($result->num_rows / $rowsPerPage);

        if (!isset($_GET["page"])) {
            $page = 1;
        } else {
            $s = $_GET["page"];
            if (is_numeric($s))
                $page = $s;
        }
        $firstRow = ($page - 1) * $rowsPerPage;
        $sql = "SELECT * FROM user LIMIT $firstRow, $rowsPerPage";
        $result = $conn->query($sql);

        // retrieve the selected results 
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo "<td>" . $row["id"] . "</td><td>" . $row["username"] . "</td><td>" . $row["password"] . "</td>";
                echo '<td><a href="#">Cập nhật</a>&nbsp&nbsp&nbsp<a href="#">Xóa</a></td>';
                echo '</tr>';
            }
        } else {
            echo "<tr>0 results</tr>";
        }
        $conn->close();
        ?>
    </table>

    <?php
    if ($page == 1) echo "Trang đầu&nbsp&nbsp";
    else {
        echo "<a href= \"?page=1\">";
        echo "Trang đầu</a>";
    }

    if ($page == 1) echo "Trang trước&nbsp&nbsp";
    else {
        echo "<a href = \"?page=";
        echo $page - 1;
        echo "\">";
        echo "Trang trước";
        echo "</a>";
    }
    for ($i = 1; $i <= $numPage; $i++) {
        if ($i == $page) echo $i . '&nbsp&nbsp';
        else {
            echo "<a href = \"?page=";
            echo $i;
            echo "\">";
            echo $i;
            echo "</a>";
        }
    }
    
    if ($page == $numPage) echo "Trang sau&nbsp&nbsp";
    else {
        echo "<a href = \"?page=";
        echo $page + 1;
        echo "\">";
        echo "Trang sau";
        echo "</a>";
    }

    if ($page == $numPage) echo "Trang cuối";
    else {
        echo "<a href = \"?page=";
        echo $numPage;
        echo "\">";
        echo "Trang cuối";
        echo "</a>";
    }

    ?>