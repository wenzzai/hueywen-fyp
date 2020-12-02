<?php

session_start();
error_reporting(0);
include('inc-admin/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:index.php');
}
else{
// code for block staff
    if(isset($_GET['inid']))
    {
        $id=$_GET['inid'];
        $status=0;
        $sql = "update tbl_staffs set Status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        $query -> bindParam(':status',$status, PDO::PARAM_STR);
        $query -> execute();
        $msg="User status change to Block successfully." ;
    }
//code for active staff
    if(isset($_GET['id']))
    {
        $id=$_GET['id'];
        $status=1;
        $sql = "update tbl_staffs set Status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        $query -> bindParam(':status',$status, PDO::PARAM_STR);
        $query -> execute();
        $msg="User status change to Active successfully." ;
    }

    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sun-U Experts</title>
        <!-- ICON  -->
        <link rel="icon" type="image/png" href="assets-admin/assets/icons/sunway.ico"/>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="assets-admin/assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONT AWESOME STYLE  -->
        <link href="assets-admin/assets/css/font-awesome.css" rel="stylesheet" />
        <!--extra add for icon -->
        <link type="text/css" href="../assets/assets/images/icons/css/font-awesome.css" rel="stylesheet">
        <!-- DATATABLE STYLE  -->
        <link href="assets-admin/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        <!-- CUSTOM STYLE  -->
        <link href="assets-admin/assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head>
    <body>


    <div class="content-wrapper">

        <div class="container-fluid">
            <a class="btn btn-primary" href="manage.php" role="button">Back</a>
        </div>
        <br><br>
        <div class="container-fluid">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Staffs</h4>
                </div>




                <div class="row">
                    <?php if($_SESSION['error']!="")
                    {?>
                        <div class="col-md-6">
                            <div class="alert alert-danger" >
                                <strong>Error :</strong>
                                <?php echo htmlentities($_SESSION['error']);?>
                                <?php echo htmlentities($_SESSION['error']="");?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($_SESSION['msg']!="")
                    {?>
                        <div class="col-md-6">
                            <div class="alert alert-success" >
                                <strong>Success :</strong>
                                <?php echo htmlentities($_SESSION['msg']);?>
                                <?php echo htmlentities($_SESSION['msg']="");?>
                            </div>
                        </div>
                    <?php } ?>



                    <?php if($_SESSION['delmsg']!="")
                    {?>
                        <div class="col-md-6">
                            <div class="alert alert-success" >
                                <strong>Success :</strong>
                                <?php echo htmlentities($_SESSION['delmsg']);?>
                                <?php echo htmlentities($_SESSION['delmsg']="");?>
                            </div>
                        </div>
                    <?php } ?>

                </div>


                <?php if($error){?><div class="alert alert-danger"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div><?php }
                else if($msg){?><div class="alert alert-success"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div><?php }?>


            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Staffs List
                            <a href="create-user.php"><button type="submit"  class="btn btn-primary btn- update" style="float: right;"> <i class="fa fa-plus"></i></button></a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>staff ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Faculty</th>
                                        <th>Department</th>
                                        <th>Registered Date</th>
                                        <th>Status</th>
                                        <th>Change Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $sql = "SELECT * from tbl_staffs order by id ";
                                    $query = $dbh -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $result)
                                        {?>
                                            <tr class="odd gradeX">
                                                <td class="center"><?php echo htmlentities($cnt);?></td>
                                                <td class="center"><a href="update-staff.php?id=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->StaffId);?></a></td>
                                                <td class="center"><?php echo htmlentities($result->firstName);?></td>
                                                <td class="center"><?php echo htmlentities($result->lastName);?></td>
                                                <td class="center"><?php echo htmlentities($result->email);?></td>
                                                <td class="center"><?php echo htmlentities($result->faculty);?></td>
                                                <td class="center"><?php echo htmlentities($result->department);?></td>
                                                <td class="center"><?php echo htmlentities($result->created_on); ?></td>

                                                <td class="center"><?php if($result->status==1)
                                                    {
                                                        ?>
                                                        <span class="label label-success">Active</span>
                                                        <?php
                                                    } else{
                                                        ?>
                                                        <span class="label label-danger">Blocked</span>
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td class="center">
                                                    <?php if($result->status==1)
                                                    {?>
                                                        <a href="manage-stafflist.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to block this staff?');"" >  <button class="btn btn-primary btn-xs"> Change</button>
                                                    <?php } else {?>
                                                        <a href="manage-stafflist.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to active this staff?');""><button class="btn btn-warning btn-xs"> Change</button>
                                                    <?php } ?>

                                                </td>

                                            </tr>
                                            <?php $cnt=$cnt+1;}} ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>

        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('inc-admin/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets-admin/assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets-admin/assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets-admin/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets-admin/assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets-admin/assets/js/custom.js"></script>
    </body>
    </html>
<?php } ?>




?>
