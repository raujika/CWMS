<?php
include "echo.php";
include "sqlConnection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard - Record</title>
    <?php echoLinkHeader(); echoLinkFooter(); ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        table.table td .add {
            display: none;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {                $('[data-toggle="tooltip"]').tooltip();
            //var actions = $("table td:last-child").html();
            var actions=
                "<a class='add new' title='Add' data-toggle='tooltip'><i class='material-icons'>&#xE03B;</i></a>" +
                "<a class='edit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>" +
                "<a class='delete new' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a><div id=\"mark\"></div>";
            // Append table with add row form on add new button click
            $(".add-new").click(function () {
                $(this).attr("disabled", "disabled");
                var index = $("table tbody tr:last-child").index();
                var row = '<tr>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td>' + actions + '</td>' +
                    '</tr>';
                $("table").append(row);
                $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
                $('[data-toggle="tooltip"]').tooltip();
                var elmnt = document.getElementById("mark");
                elmnt.scrollIntoView();
            });
            // Add row on add button click
            $(document).on("click", ".add", function () {
                var empty = false;
                var input = $(this).parents("tr").find('input[type="text"]');
                input.each(function () {
                    if (!$(this).val()) {
                        $(this).addClass("error");
                        empty = true;
                    } else {
                        $(this).removeClass("error");
                    }
                });
                $(this).parents("tr").find(".error").first().focus();
                if (!empty) {
                    var fruits = [];
                    input.each(function () {
                        $(this).parent("td").html($(this).val());
                        fruits.push($(this).val());
                    });
                    if($(this).hasClass("new"))
                    {
                        url="addRecord.php";
                    }
                    else
                    {
                        url="updateRecord.php";
                    }
                    window.location.href=url+"?recordId="+fruits[0]+"&questionId="+fruits[1]+"&characterName="+fruits[2]+
                        "&npcId="+fruits[3]+"&status="+fruits[4]+"&countHints="+fruits[5]+"&lastStartTime="+fruits[6]+
                        "&timeCount="+fruits[7];
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");
                }
            });
            // Edit row on edit button click
            $(document).on("click", ".edit", function () {
                $(this).parents("tr").find("td:not(:last-child)").each(function () {
                    $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
                });

                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").attr("disabled", "disabled");
            });
            // Delete row on delete button click
            $(document).on("click", ".delete", function () {
                window.location.href="deleteRecord.php?recordId="+$(this).parent().siblings(":first").text();
                $(".add-new").removeAttr("disabled");
            });
        });
    </script>
</head>

<body>

<div id="wrapper">


    <?php echoBar(); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Game Status Record</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Record
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <div style="width:100%; height:450px; overflow:scroll;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>record Id</th>
                                    <th>question Id</th>
                                    <th>character Name</th>
                                    <th>npc Id</th>
                                    <th>question Status</th>
                                    <th>Hints count</th>
                                    <th>Last start Time</th>
                                    <th>Time Count</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?PHP
                                $rs = query("SELECT * FROM record;");
                                while ($rc = mysqli_fetch_assoc($rs)) {
                                    echo "<tr><td>";
                                    echo $rc['recordId'];
                                    echo "</td><td>";
                                    echo $rc['questionId'];
                                    echo "</td><td>";
                                    echo $rc['characterName'];
                                    echo "</td><td>";
                                    echo $rc['npcId'];
                                    echo "</td><td>";
                                    echo $rc['status'];
                                    echo "</td><td>";
                                    echo $rc['countHints'];
                                    echo "</td><td>";
                                    echo $rc['lastStartTime'];
                                    echo "</td><td>";
                                    echo $rc['timeCount'];
                                    echo "</td><td>";
                                    echo "<a class='add' title='Add' data-toggle='tooltip'><i class='material-icons'>&#xE03B;</i></a>";
                                    echo "<a class='edit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>";
                                    echo "<a class='delete' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>";
                                    echo "</td></tr>";
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-info add-new" style="margin:10px;float: right;"><i class="fa fa-plus"></i>Add New</button>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php mysqli_close($conn); ?>
</body>

</html>