<?php
/**
 * Created by PhpStorm.
 * User: hueywen
 * Date: 30/10/2018
 * Time: 3:06 AM
 */

include('../inc/config.php');

$title = "School of Science and Technology";

$description = "The School of Science and Technology offers students a superior learning experience through excellent
                teaching, good administrative support and personalised attention. Our team of dedicated and experienced
                academics imparts knowledge and skills in the field of science and technology, and along the way equip
                students with good values and professionalism to serve the community.
                <br><br>

                All our undergraduate programmes are validated by Lancaster University, UK and we constantly grow our
                range of offerings at both undergraduate and postgraduate levels to better serve the needs of the community.
                <br><br>

                The School engages in active research in support of the University’s strategic ambitions, successfully
                attracting significant research funding both internal and external. Our academics contribute to research
                scholarship through extensively publishing books, book chapters, as well as in high impact Web of Science
                and Scopus refereed journal and conference papers.</p>";

$department_list = array();
array_push($department_list,"Department of Biological Sciences");
array_push($department_list,"Department of Computing and Information System");
array_push($department_list,"Department of Psychology");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js">

    <link rel="icon" type="image/png" href="../assets/assets-login/images/icons/sunway.ico"/>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../assets/assets/css/carousel.css" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Sunway</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Academic School
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="arts.php">School of Arts</a>
                        <a class="dropdown-item" href="healthcare.php">School of Healthcare and Medical Science</a>
                        <a class="dropdown-item" href="business.php">School of Business</a>
                        <a class="dropdown-item" href="technology.php">School of Science and Technology</a>
                        <a class="dropdown-item" href="hospitality.php">School of Hospitality</a>
                        <a class="dropdown-item" href="mathematicalScience.php">School of Mathematical Science</a>

                    </div>
                </li>

            </ul>

        </div>
    </nav>



</header>

<main role="main">
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3"><?php echo $title?></h1>
            <p><?php echo $description;?></p>
        </div>
    </div>

    <?php
    $printed = false;
    foreach ($department_list as $data){

        //DB Obtain Start
        $sql= "SELECT * FROM `tbl_staffs` WHERE `department` = :department"; // Ensure the id matches with the user_ID

        try {
            $query = $dbh->prepare($sql);
            $query->bindParam(':department',$data,PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)==0){ // if no such data

            } else{
                if($printed == false){
                    echo "
                            <div class='container'>
                            <h3>$data</h3>
                            <br><br>
                            <div class='row'>";

                    $printed == true;
                }
            }

            foreach($result as $output) {
                $firstname = $output["firstName"];
                $lastname = $output["lastName"];
                $faculty = $output["faculty"];
                $department = $output["department"];
                $id = $output["StaffId"];
                $profile_picture = $output["profile_picture"];
                
                $image = "https://cdn1.iconfinder.com/data/icons/unique-round-blue/93/user-512.png";
                
                if(strcasecmp($profile_picture,"")==0 || strcasecmp($profile_picture,"none")==0){
                    $image = "https://cdn1.iconfinder.com/data/icons/unique-round-blue/93/user-512.png";
                } else{
                    $image = "../".$profile_picture;
                }

                echo "
                        <div class='col-lg-4'>
                            <div class='col-lg-12'>
                                 <img class='rounded-circle' src='$image' alt='Generic placeholder image' width='140' height='140'>
                                    <h2>$firstname $lastname</h2>
                                        <p>$faculty</p>
                                        <p>$department</p>
                                        <p><a class='btn btn-secondary' href='user.php?id=$id' role='button'>View details &raquo;</a></p>
                            </div>
                        </div>
                        ";
            }
        }
        catch(PDOException $e) {
            echo $e;
        }

        //DB Obtain End
        echo"
                </div>
                <hr>
                </div>
                ";
    }

    ?>
    <br><br><br>



    <!-- FOOTER -->
    <hr>
    <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; hueywen &middot; 2018</p>
    </footer>
</main>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
