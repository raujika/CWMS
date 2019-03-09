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
    <title>Dashboard - YesNo Test</title>
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
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            //var actions = $("table td:last-child").html();
            var actions=
                "<a class='add new' title='Add' data-toggle='tooltip'><i class='material-icons'>&#xE03B;</i></a>" +
                "<a class='edit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>" +
                "<a class='delete new' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>";
            // Append table with add row form on add new button click
            $(".add-new").click(function () {
                $(this).attr("disabled", "disabled");
                var index = $("table tbody tr:last-child").index();
                var row = '<tr>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><input type="text" class="form-control"></td>' +
                    '<td><select class="form-control"><option value="1" >Yes</option><option value="0" selected>No</option></select></td>' +
                    '<td>' + actions + '</td>' +
                    '</tr>';
                $("table").append(row);
                $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
                $('[data-toggle="tooltip"]').tooltip();
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
                        url="addYesNoTest.php";
                    }
                    else
                    {
                        url="updateYesNoTest.php";
                    }
                    window.location.href=url+"?yesnotestId="+fruits[0]+"&npcId="+fruits[1]+"&question="+fruits[2]+
                        "&yes="+$(this).parents("tr").find('select').val();
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");
                }
            });
            // Edit row on edit button click
            $(document).on("click", ".edit", function () {
                $i=1;
                $(this).parents("tr").find("td:not(:last-child)").each(function () {
                    if($i == 4){
                        if($(this).text() == "No"){
                            $str = "<option value='1' >Yes</option><option value='0' selected>No</option>";
                        }else{
                            $str = "<option value='1' selected>Yes</option><option value='0'>No</option>";
                        }
                        $(this).html("<select class='form-control'>"+$str+"</select>");
                    }else{
                        $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
                    }
                    $i++;
                });


                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").attr("disabled", "disabled");
            });
            // Delete row on delete button click
            $(document).on("click", ".delete", function () {
                window.location.href="deleteYesNoTest.php?yesnotestId="+$(this).parent().siblings(":first").text();
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
                <h1 class="page-header">YesNo Test Record</h1>
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

                        <div style="width:100%; height:60%; overflow:auto;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NPC ID</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?PHP
                                $rs = query("SELECT * FROM yesnotest");
                                while ($rc = mysqli_fetch_assoc($rs)) {
                                    $str = "Yes";
                                    if($rc['yes'] == 0)
                                        $str = "No";
                                    echo "<tr><td>";
                                    echo $rc['yesnotestId'];
                                    echo "</td><td>";
                                    echo $rc['npcId'];
                                    echo "</td><td>";
                                    echo $rc['question'];
                                    echo "</td><td>";
                                    echo $str;
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
                        <button type="button" class="btn btn-info add-new" style="float: right;"><i class="fa fa-plus"></i>Add New</button>
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