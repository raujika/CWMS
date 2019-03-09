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
    <link rel="stylesheet" type="text/css" href="bootstrap-treeview.css"/>


</head>

<body>

<div id="wrapper">
    <?php echoBar(); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Journey Management</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i>Dialogue List
                        <!---->

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="tree" style="height: 420px;overflow: scroll"></div>
                        <a href="#" class="btn btn-default btn-block">Add new</a>
                        <a href="#" class="btn btn-default btn-block">Delete</a>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-5 -->
            <div class="col-lg-7">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Journey Detail
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <label>Start NPC</label>
                                <input id="snpc" name="snpc" width="30%" class="form-control"
                                       type="text" value=""/>
                            </div>
                            <div class="col-lg-6">
                                <label>Journey Name</label>
                                <input id="jname" name="jname" width="30%" class="form-control"
                                       type="text" value=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Dialogue Detail
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Type</label><br>
                                <select name="rating" class="form-control"
                                        id="type" class="form-group">
                                    <option value="Dialogue" >
                                        Normal Dialogue
                                    </option>
                                    <option value="Collectitem" >
                                        CollectItem
                                    </option>
                                    <option value="RQuest" >
                                        RandomQuest
                                    </option>
                                    <option value="SQuest" >
                                        SpecificQuest
                                    </option>
                                    <option value="Toast" >
                                        Toast Text
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-4" id="spk">
                                <label>Speaker Id</label>
                                <input id="spkid" name="spkid" width="30%" class="form-control"
                                       type="text" value=""/>
                            </div>
                            <div class="col-lg-4" id="did">
                                <label>Preivous Dialogue Id</label>
                                <input id="PreivousId" name="PreivousId" width="30%" class="form-control"
                                       type="text" value=""/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="dcontent">
                                <label>Dialog Content</label>
                                <div>
                                        <textarea class="form-control" rows="8" style="margin-bottom: 10px; width:100%"
                                                  id="dc"
                                                  name="dc"></textarea>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-default btn-block">Save</a>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-7 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php echoLinkFooter() ?>
<script src="bootstrap-treeview.js"></script>
<script>
    $(function () {
        function gett() {
            return [
                {
                    text: "[0001]hi",
                    nodes: [
                        {
                            text: "[0002]Hi, do u want some quest?",
                            nodes: [
                                {
                                    text: "[0003]yes",
                                    nodes: [
                                        {
                                            text: "[0004]i just need some help, can u bring me some code and i will bring u a challenge, i need u to fix my meachine",
                                            nodes: [
                                                {
                                                    text: "[0006]yes",
                                                    nodes: [
                                                        {
                                                            text: "[0007]start quest XXXX"
                                                        }
                                                    ]

                                                },
                                                {
                                                    text: "[0008]no",
                                                    nodes: [
                                                        {
                                                            text: "[0009]ok fine, have a nice day"
                                                        }
                                                    ]

                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    text: "[000A]no",
                                    nodes: [
                                        {
                                            text: "[000B]ok fine, have a nice day"
                                        }
                                    ]
                                }
                            ]
                        }
                    ]
                }];
        }

        $('#tree').treeview({data: gett()});
    });

</script>
<?php mysqli_close($conn); ?>
</body>

</html>
