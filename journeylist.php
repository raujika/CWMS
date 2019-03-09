<?php
include "echo.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard - Main</title>
    <?php echoLinkHeader(); ?>



</head>

<body>

<div id="wrapper">
    <?php echoBar(); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Journey List</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Journey List
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div style="width:100%; height:450px; overflow:scroll;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Journey Id</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <input type="submit" style="margin-top: 10px" class="btn btn-default btn-block"/>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.col-lg-4 -->

            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Quest Reference List
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div style="width:100%; height:140px; overflow:scroll;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Quest Id</th>
                                    <th>Type</th>
                                    <th>Npc Name</th>
                                    <th>Rating</th>
                                    <th>Detail</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Journey Detail
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <label>Journey Name</label>
                        <input name="jname" class="form-control" type="text" value=""/>
                        <div style="width:100%; height:150px; overflow:scroll;margin-top: 10px">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Dialog Id</th>
                                    <th>Quest Id</th>
                                    <th>Speak before start</th>
                                    <th>Speak after done</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="submit" style="margin-top: 10px" class="btn btn-default btn-block"/></div>
                            <div class="col-lg-6">
                                <button type="button" style="margin-top: 10px" class="btn btn-info btn-block add-new"><i
                                            class="fa fa-plus"></i>Add New Dialogue Line
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php mysqli_close($conn); ?>
<?php echoLinkFooter(); ?>
</body>

</html>