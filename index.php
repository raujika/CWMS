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
    <link rel="stylesheet" type="text/css" href="sequences.css"/>
</head>

<body>

<div id="wrapper">


    <?php echoBar(); ?>
    <script>var data1 = "";
        var data2 = "";</script>
    <?php
    include "sqlConnection.php";

    //get data1
    $rows = "date,value\\r\\n";
    $dateSel = "CONCAT(CONVERT(YEAR(lastStartTime),CHAR(4)),'-', RIGHT(CONCAT('0',CONVERT(MONTH(lastStartTime),CHAR(2))),2))";
    $SQL = "SELECT $dateSel,COUNT(*) FROM record WHERE status='done' GROUP BY $dateSel ORDER BY $dateSel;";
    $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    while ($rc = mysqli_fetch_array($rs)) {
        $date = $rc[0];
        $count = $rc[1];
        $rows .= $date . "," . $count . "\\r\\n";
    }
    $rows = substr($rows, 0, strlen($rows) - 4);
    echo "<script>data1=\"$rows\";</script>";

    //get data2
    $rows = "";
    $timeSel = "CAST(FLOOR(r.timeCount/60/60/24) AS SIGNED)";
    $SQL = "SELECT $timeSel,q.rating,r.countHints,COUNT(*) FROM record r,questions q WHERE r.questionId=q.questionId AND r.status='done' GROUP BY 0.5*(5+$timeSel+ABS(5-$timeSel)) ,q.rating,0.5*(3+r.countHints+ABS(3-r.countHints)),r.countHints;";
    $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    while ($rc = mysqli_fetch_array($rs)) {
        $days = $rc[0];
        $rating = $rc[1];
        $hints = $rc[2];
        $count = $rc[3];
        if ($days == '0')
            $days = "<1 day";
        else if ($days == '1')
            $days = "1-2 days";
        else if ($days == '2')
            $days = "2-3 days";
        else if ($days == '3')
            $days = "3-4 days";
        else
            $days = ">4 days";
        if (intval($hints) >= 3)
            $hints = ">=3";
        $hints .= " hints";
        //$rating.=" rating";

        $rows .= $rating . "_" . $days . "_" . $hints . "," . $count . "\\r\\n";
    }
    $rows = substr($rows, 0, strlen($rows) - 4);
    $data2 = $rows;
    echo "<script>data2=\"$rows\";</script>";

    mysqli_close($conn);
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Welcome
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <img width="80%"
                             src="https://media.indiedb.com/images/downloads/1/111/110641/Desura_profile_large.1.png">
                        <h1>Welcome to Code Wonderland Management System!</h1><br>
                        This website is made by: Yuen, Ham, Ming, Yi<br>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> The Overview Statistic
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table>
                            <tr>
                                <td>
                                    <div id="main">
                                        <div id="sequence"></div>
                                        <div id="chart">
                                            <div id="explanation">
                                                <span id="percentage"></span><br/>
                                                move cusor to see more detail
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div id="sidebar">
                                        <input type="checkbox" id="togglelegend"> Legend<br/>
                                        <div id="legend" style="visibility: hidden;"></div>
                                    </div>
                                    <script><?php include "sequences.js"; ?></script>
                                    <!--<script type="text/javascript" src="sequences.js" data2="<?php echo $data2; ?>"></script>-->
                                    <script type="text/javascript">
                                        // Hack to make this example display correctly in an iframe on bl.ocks.org
                                        d3.select(self.frameElement).style("height", "700px");
                                    </script>
                                </td>
                            </tr>
                        </table>
                        <a href="#" class="btn btn-default btn-block">View Detail Statistic</a>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-7 -->
            <div class="col-lg-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Recent Record
                        <!---->
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                <i class="fa fa-comment fa-fw"></i>characterName finished questXX
                                <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-twitter fa-fw"></i>characterName entered questXX phaseX
                                <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="fa fa-envelope fa-fw"></i>characterName started questXX
                                <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                    </span>
                            </a>
                        </div>
                        <!-- /.list-group -->
                        <a href="#" class="btn btn-default btn-block">View All Record</a>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Reference Link
                        <!---->
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <a>Our Git</a><br>
                        <a>Stendhal Offical Website</a><br>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-5 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php echoLinkFooter() ?>
<?php mysqli_close($conn); ?>
</body>

</html>
