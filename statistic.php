<?php
include "echo.php";
include "sqlConnection.php";
function fetchquery($type, $rating)
{
    $rs = query("SELECT COUNT(*) as sum FROM questions WHERE type = '$type' AND rating = '$rating'");
    $rc = mysqli_fetch_assoc($rs);
    $num = $rc['sum'];
    return $num;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard - Statistic</title>
    <?php echoLinkHeader(); ?>
    <link rel="stylesheet" type="text/css" href="sequences.css"/>
    <script>
        // $(document).ready(function () {
        //     $(document).on("click", "#switch", function () {
        //         moveBar();
        //     });
        // });
        /*
        *
        * */
        var record = [{
            y: 'Easy',
            a: <?php echo fetchquery("Logic error", "Easy"); ?>,
            b: <?php echo fetchquery("Syntax error", "Easy"); ?>,
            c: <?php echo fetchquery("Reorder", "Easy"); ?>,
            d: <?php echo fetchquery("Tracing program", "Easy"); ?>
        },
            {
                y: 'Normal',
                a: <?php echo fetchquery("Logic error", "Normal"); ?>,
                b: <?php echo fetchquery("Syntax error", "Normal"); ?>,
                c: <?php echo fetchquery("Reorder", "Normal"); ?>,
                d: <?php echo fetchquery("Tracing program", "Normal"); ?>
            },
            {
                y: 'Hard',
                a: <?php echo fetchquery("Logic error", "Hard"); ?>,
                b: <?php echo fetchquery("Syntax error", "Hard"); ?>,
                c: <?php echo fetchquery("Reorder", "Hard"); ?>,
                d: <?php echo fetchquery("Tracing program", "Hard"); ?>
            }
            ,
            {
                y: 'Expert',
                a: <?php echo fetchquery("Logic error", "Expert"); ?>,
                b: <?php echo fetchquery("Syntax error", "Expert"); ?>,
                c: <?php echo fetchquery("Reorder", "Expert"); ?>,
                d: <?php echo fetchquery("Tracing program", "Expert"); ?>
            },
            {
                y: 'Nightmare',
                a: <?php echo fetchquery("Logic error", "Nightmare"); ?>,
                b: <?php echo fetchquery("Syntax error", "Nightmare"); ?>,
                c: <?php echo fetchquery("Reorder", "Nightmare"); ?>,
                d: <?php echo fetchquery("Tracing program", "Nightmare"); ?>
            }];
        var labels = ['Logical Error', 'Syntax Error', 'Reorder', 'Tracing'];
        var barColors = ["#D73B3B", "#1DAAA2", "#C61671", "#6A6E8A"];

        function moveBar() {
            $("#bar-example").html("");
            record.forEach(function (x) {
                var buf = x.a;
                x.a = x.b;
                x.b = x.c;
                x.c = x.d;
                x.d = buf;
            });
            var buf = labels[0];
            labels[0] = labels[1];
            labels[1] = labels[2];
            labels[2] = labels[3];
            labels[3] = buf;
            buf = barColors[0];
            barColors[0] = barColors[1];
            barColors[1] = barColors[2];
            barColors[2] = barColors[3];
            barColors[3] = buf;
            Morris.Bar({
                element: 'bar-example',
                data: record,
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd'],
                labels: labels,
                barColors: barColors,
                hideHover: true,
                horizontal: true,
                stacked: true,
                resize: true
            });
        }
    </script>
    <style>
        #xaxis .domain {
            fill: none;
            stroke: #000;
        }

        #xaxis text, #yaxis text {
            font-size: 12px;
        }
    </style>
</head>

<body>

<div id="wrapper">


    <?php echoBar(); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Statistic</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Completed Quest Statistics
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <script>var data1 = "";
                            var data2 = "";</script>
                        <?php


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
                        $SQL = "SELECT $timeSel,q.rating,r.countHints,COUNT(*) FROM record r,questions q WHERE r.questionId=q.questionId AND r.status='done' GROUP BY 0.5*(5+$timeSel+ABS(5-$timeSel)) ,q.rating,0.5*(3+r.countHints+ABS(3-r.countHints));";
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
                        <center>
                            <div id="bar" style="width: 100%;overflow: scroll"></div>
                            <script>

                                var margin = {top: 20, right: 20, bottom: 70, left: 40},
                                    width = 1000 - margin.left - margin.right,
                                    height = 300 - margin.top - margin.bottom;

                                // Parse the date / time
                                var parseDate = d3.time.format("%Y-%m").parse;

                                var x = d3.scale.ordinal().rangeRoundBands([0, width], .05);

                                var y = d3.scale.linear().range([height, 0]);

                                var xAxis = d3.svg.axis()
                                    .scale(x)
                                    .orient("bottom")
                                    .tickFormat(d3.time.format("%Y-%m"));

                                var yAxis = d3.svg.axis()
                                    .scale(y)
                                    .orient("left")
                                    .ticks(10);

                                var svg = d3.select("#bar").append("svg")
                                    .attr("width", width + margin.left + margin.right)
                                    .attr("height", height + margin.top + margin.bottom)
                                    .append("g")
                                    .attr("transform",
                                        "translate(" + margin.left + "," + margin.top + ")");


                                //d3.csv("bar-data.csv", function (error, data) {fn(data)});
                                barData = [];
                                d3.csv.parse(data1, function (d) {
                                    barData.push(d);
                                });
                                fn(barData);

                                function fn(data) {
                                    data.forEach(function (d) {
                                        d.date = parseDate(d.date);
                                        d.value = +d.value;
                                    });

                                    x.domain(data.map(function (d) {
                                        return d.date;
                                    }));
                                    y.domain([0, d3.max(data, function (d) {
                                        return d.value;
                                    })]);

                                    svg.append("g")
                                        .attr("class", "x axis")
                                        .attr("transform", "translate(0," + height + ")")
                                        .call(xAxis)
                                        .selectAll("text")
                                        .style("text-anchor", "end")
                                        .attr("dx", "-.8em")
                                        .attr("dy", "-.55em")
                                        .attr("transform", "rotate(-90)");

                                    svg.append("g")
                                        .attr("class", "y axis")
                                        .call(yAxis)
                                        .append("text")
                                        .attr("transform", "rotate(-90)")
                                        .attr("y", 6)
                                        .attr("dy", "1em")
                                        .style("text-anchor", "end");

                                    svg.selectAll("bar")
                                        .data(data)
                                        .enter().append("rect")
                                        .style("fill", "steelblue")
                                        .attr("x", function (d) {
                                            return x(d.date);
                                        })
                                        .attr("width", x.rangeBand())
                                        .attr("y", function (d) {
                                            return y(d.value);
                                        })
                                        .attr("height", function (d) {
                                            return height - y(d.value);
                                        });

                                }

                            </script>
                        </center>
                    </div>
                    <!-- /.panel-body -->
                </div>

            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Existing Questions Status
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
<!--                        <div style="float:right">-->
<!--                            <button id="switch" class="btn-primary btn">switch</button>-->
<!--                        </div>-->
<!--                        <br>-->
                        <div id="pPie" style="display: none">

                        </div>
                        <div id="pBar">
                            <div id="bar-example" style="height: 300px"></div>
                            <script src="bar_detail.js"></script>
                            <script>
                                moveBar();
                            </script>
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
<?php echoLinkFooter() ?>
<?php mysqli_close($conn); ?>
</body>

</html>