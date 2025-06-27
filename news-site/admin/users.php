

<?php
include "header.php";
include "config.php";
?>


<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">Add User</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = 3;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        }
                        else{
                            $page = 1;
                        }
                        // $page = $_GET['page'];
                        $offset = ($page - 1) * $limit;
                        $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset},{$limit}";
                        $result = mysqli_query($conn, $sql) or die("Query Failed.");

                        if (mysqli_num_rows($result) > 0) {
                            $serial = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td class='id' ><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo ($row['role'] == 1) ? 'Admin' : 'Normal'; ?></td>
                            <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                            <td onclick="deleteUser(<?php echo $row['user_id']; ?>)" class='delete'><i class='fa fa-trash-o'></i></td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No Users Found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                $sql1 = "SELECT * FROM user";
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed");


                if (mysqli_num_rows($result1) > 0) {

                    $total_records = mysqli_num_rows($result1);
                    $limit = 3;
                    $total_page = ceil($total_records / $limit);

                    echo '<ul class="pagination admin-pagination">';
                    for ($i=1; $i <= $total_page ; $i++) { 
                        if ($i == $page) {
                           $active = "active";
                        } else {
                            $active = "";
                        }
                      echo '<li class="'.$active.'" ><a href="users.php?page='.$i.'" >'.$i.'</a></li>';
                    }
                    echo '</ul>';
                }
                
                ?>


                <!-- <ul class='pagination admin-pagination'>
                    <li class="active"><a>1</a></li>
                    <li><a>2</a></li>
                    <li><a>3</a></li>
                </ul> -->
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
function deleteUser(userId) {
  if (confirm("Are you sure you want to delete this user?")) {
    fetch('delete-user.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `id=${userId}`
    })
    .then(response => response?.text() )
    .then(data => {
      console.log(data);
      // Optionally, remove row from table
    //   location.reload(); // or remove element from DOM
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
}
</script>
