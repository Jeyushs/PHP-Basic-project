<?php
// INSERT INTO `notes` (`sno`, `Title`, `description`, `tstamp`) VALUES (NULL, 'Go to buy books', 'Please buy books from store', CURRENT_TIMESTAMP);
$insert = false;
$update = false;
$delete = false;
//conect to database
$severname = "localhost";
$username = "root";
$password = "newpassword";
$database = "notes";

$conn = mysqli_connect($severname, $username, $password, $database);
if (!$conn) {
  die("Sorry we failed to connect:" . mysqli_connect_error());
}
// echo $_SERVER['REQUEST_METHOD'];

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = '$sno'";
  $result = mysqli_query($conn,$sql);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset( $_POST['snoEdit'])){
    // update the recorc
    
   $sno = $_POST["snoEdit"];
   $title = $_POST["titleEdit"];
   $description = $_POST['descriptionEdit'];


  $sql = "UPDATE `notes` SET `Title` = '$title',`description` = '$description' WHERE `notes`.`sno` = '$sno' ";
   $result = mysqli_query($conn,$sql);
   if($result){
    $update = true;
   }

  }
  else{

   $title = $_POST["title"];
   $description = $_POST['description'];

  //  $sql = "INSERT INTO `notes`(`title`,`description`)VALUES(`$title`,`$description`)";
  $sql = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title', '$description')";
   $result = mysqli_query($conn,$sql);

   if($result){
    // echo "The record has been inserted successfully!<br>";
    $insert = true;
   }
   else{
    echo "The record was not inserted succesfully because of this error-->". mysqli_error($conn);
   }
  }
}
?>
<!doctype html> 
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
 
 
  <title>Notes - Notes taking make easy</title>

</head>

<body>
  <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/project1/index.php" method="POST">
      <div class="modal-body">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="mb-3 my-4">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
          </div>
    
          <div class="form-group">
            <label for="description">Note Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
    
          
        </div>
        <div class="modal-footer d-block mr-auto">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="/project1/logo.svg" height="28px" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
          <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li> -->
          <!-- <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
              </li> -->
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
  <div class="container">
    <h2 class="my-4">Add a Note</h2>
    <form action="/project1/index.php" method="POST">
      <div class="mb-3 my-4">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
      </div>

      <div class="form-group">
        <label for="description">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary my-4">Add Note</button>
    </form>
  </div>

  <div class="container my-4">

    
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
    $sql = "SELECT * FROM `notes`";
    $result = mysqli_query($conn, $sql);
    $sno =0;
    while ($rows = mysqli_fetch_array($result)) {
      $sno++;
      echo "<tr>
      <th scope='row'>". $sno."</th>
      <td>". $rows['Title']."</td>
      <td>". $rows['description']."</td>
      <td><button class='edit btn btn-sm btn-primary' id=".$rows['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$rows['sno'].">Delete</button> </td>
    </tr>";
    
    }
    
    
    ?>
        
      </tbody>
    </table>
  </div>  
  <hr>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
    crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
   let table = new DataTable('#myTable');
  </script>
   <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
     element.addEventListener("click",(e)=>{
       console.log("edit",);
       tr = e.target.parentNode.parentNode;
       title = tr.getElementsByTagName("td")[0].innerText;
       description = tr.getElementsByTagName("td")[1].innerText;
       console.log(title, description);
       titleEdit.value = title;
       descriptionEdit.value = description;
       snoEdit.value = e.target.id;
       console.log(e.target.id);
       $('#editModal').modal('toggle');
     })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
     element.addEventListener("click",(e)=>{
       console.log("delete",);
       sno = e.target.id.substr(1,);

       if(confirm("Are you sure wamt to delete this note!")){
        console.log("yes");
        window.location = `/project1/index.php?delete=${sno}`;
        //not to do window.url it will directly sent to url which may leads to hack
        //To do: Create a form and Use post request to submit a form
       }
       else{
        console.log("no");
       }
       
     })
    })
    </script>
</body>

</html>