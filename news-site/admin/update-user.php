

<?php
include "header.php";
include "config.php";

if (isset($_POST['submit'])) {

    $user_id = $_POST['user_id'];
    $fname = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['l_name']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // check username is not duplicate except current user
    $check_sql = "SELECT * FROM user WHERE username = '{$user}' AND user_id != {$user_id}";
    $check_result = mysqli_query($conn, $check_sql) or die("Query Failed.");


    if (mysqli_num_rows($check_result) > 0) {
        echo "<p style='color:red;text-align:center;margin:10px 0;'>Username Already Exists.</p>";
    } else {
        $sql = "UPDATE user SET first_name = '{$fname}', last_name = '{$lname}', username = '{$user}', role = '{$role}' WHERE user_id = {$user_id}";

        // echo $sql;
        // die("fail");

        if (mysqli_query($conn, $sql)) {
            header("Location: {$hostname}/admin/users.php");
            exit;
        } else {
            echo "Update Failed: " . mysqli_error($conn);
        }
    }
}

?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">

              <?php
                include "config.php";
                $user_id = $_GET['id'];
                $sql = "SELECT * FROM user WHERE user_id = {$user_id}";
                $result = mysqli_query($conn, $sql) or die ("Query Failed");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
              ?>

                  <!-- Form Start -->
                  <form  action="" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id'] ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'] ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'] ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role">
                          <option value="0" <?php if ($row['role'] == 0) echo 'selected'; ?>>Normal User</option>
                          <option value="1" <?php if ($row['role'] == 1) echo 'selected'; ?>>Admin</option>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->

                <?php 
                   }
                 } 
                ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
