<?php
session_start();
error_reporting(0);
include("class/AdminClass.php");


if (!$_SESSION["unm"]) {
    echo "<script>window.location='LoginPage.php'</script>";
}

$res = $admin->select("select AlbumName,AlbumCover from albumsinfo where AlbumID='" . $_REQUEST["ID"] . "'");

while ($row = mysqli_fetch_array($res)) {
    $AlbumName = $row["AlbumName"];
    $AlbumCover = $row["AlbumCover"];
}

include("../BeatsMusic/Class/AlbumClass.php");

if (isset($_POST["save"])) 
{
    $fname = $_FILES["CoverPhoto"]["name"];

    if ($fname == substr($AlbumCover, 23)) 
    {
        $filename = $AlbumCover;
    } 
    else 
    {
        $tname = $_FILES["CoverPhoto"]["tmp_name"];

        if (file_exists("../BeatsMusic/UploadsData/AlbumCover/" . $fname)) 
        {
            $filename = "UploadsData/AlbumCover/" . time() . "_" . $fname;
        } 
        else 
        {
            $filename = "UploadsData/AlbumCover/" . $fname;
        }

        move_uploaded_file($tname,"../BeatsMusic/".$filename);

        unlink("../BeatsMusic/".$AlbumCover);
    }

    $result = $album->editAlbum($_POST["AlbumName"], $filename, $_REQUEST["ID"]);

    if($result)
    {
        echo "<script>alert('Album Details Updated Successfully')</script>";
        echo "<script>window.location='AlbumsDetails.php'</script>";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Album - BeatsAdmin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" href="img/Beats.png">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <?php include("includes/sidebar.php"); ?>
        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php include("includes/navmenu.php"); ?>
            <!-- Navbar End -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4 d-flex justify-content-center">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h2 class="mb-4">Edit Album</h2>
                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Album Name</label>
                                    <input type="text" class="form-control" name="AlbumName" value="<?php echo $AlbumName; ?>">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Cover Photo</label>
                                    <input class="form-control bg-dark" type="file" name="CoverPhoto">
                                </div>
                                <input type="submit" class="form-control bdr bg-primary text-white" name="save" value="Save Changes">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>


    <script>
        const fileInput = document.querySelector('input[type="file"]');

        const myFile = new File(['File'], '<?php echo $AlbumCover; ?>');

        const dataTransfer = new DataTransfer();

        dataTransfer.items.add(myFile);

        fileInput.files = dataTransfer.files;
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>