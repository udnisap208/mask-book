<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location:index.php');
}
?>
<!DOCTYPE html>

<head>
  <title>My Posts</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="icons/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>


  <?php
  $homelink = "";
  $mypostslink = "active";
  $u = $_SESSION['user'];
  include('navigation.php');
  ?>
  <div class="mx-4">
    <div class="card mx-2 mt-2 mb-2">
      <div class="card-body">
        <form action="dbh/newpost.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Unmask Your Thoughts</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="desc" required minlength="10" maxlength="200"></textarea>
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
              </svg> Attach Images </label>
            <input class="form-control" type="file" name="img_file" id="img_file">
          </div>
          <button type="submit" name="plink" value="myposts.php" class="btn btn-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mastodon" viewBox="0 0 16 16">
              <path d="M11.19 12.195c2.016-.24 3.77-1.475 3.99-2.603.348-1.778.32-4.339.32-4.339 0-3.47-2.286-4.488-2.286-4.488C12.062.238 10.083.017 8.027 0h-.05C5.92.017 3.942.238 2.79.765c0 0-2.285 1.017-2.285 4.488l-.002.662c-.004.64-.007 1.35.011 2.091.083 3.394.626 6.74 3.78 7.57 1.454.383 2.703.463 3.709.408 1.823-.1 2.847-.647 2.847-.647l-.06-1.317s-1.303.41-2.767.36c-1.45-.05-2.98-.156-3.215-1.928a3.614 3.614 0 0 1-.033-.496s1.424.346 3.228.428c1.103.05 2.137-.064 3.188-.189zm1.613-2.47H11.13v-4.08c0-.859-.364-1.295-1.091-1.295-.804 0-1.207.517-1.207 1.541v2.233H7.168V5.89c0-1.024-.403-1.541-1.207-1.541-.727 0-1.091.436-1.091 1.296v4.079H3.197V5.522c0-.859.22-1.541.66-2.046.456-.505 1.052-.764 1.793-.764.856 0 1.504.328 1.933.983L8 4.39l.417-.695c.429-.655 1.077-.983 1.934-.983.74 0 1.336.259 1.791.764.442.505.661 1.187.661 2.046v4.203z" />
            </svg> Post</button>
        </form>
      </div>
    </div>

    <?php
    include('dbh/dbdata.php');
    $con = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
    $sql = "SELECT id,description,date,email,imgid FROM masks WHERE email='$u' ORDER BY date DESC";
    $result = $con->query($sql);
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
    ?>
      <div class="card mb-3 mx-3">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="dbh/uploads/<?php echo ($row['imgid']) ?>" class="img-fluid rounded-start mx-3 my-3">
            <div class="d-flex flex-row-reverse position-absolute top-0 end-0 mx-2 my-2"> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo ($id) ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                </svg> Delete</button>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h3 class="card-title"><?php echo ($row['description']); ?></h3>
              <p class="card-text">Someone with the email <cite title="Source Title"><?php echo ($row['email']) ?></cite></p>
              <div class="position-absolute bottom-0 end-0">
                <p class="card-text"><small class="text-muted me-2"><?php echo ($row['date']) ?></small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="staticBackdrop<?php echo ($id) ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Confirm Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are You Sure You Want To Delete Your Post?<?php echo ($id) ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <form action="dbh/deletepost.php" method="POST">
                <button type="submit" name="id" value="<?php echo ($id); ?>" class="btn btn-danger">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php
    }
    $con->close();
    ?>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </div>
</body>

</html>