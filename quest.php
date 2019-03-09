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
    <title>Dashboard - Questions Management</title>
    <?php echoLinkHeader();
    echoLinkFooter(); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function clear() {
            $("#code").val("");
            $("#cOutput").val("");
            $("#eOutput").val("");
            $("#answer").val("");
            $("#qid").val("");
            $("#questionType option[value='Logic error']").attr('selected', 'selected');
            $("#questionType").change();
            $("#rating option[value='Easy']").attr('selected', 'selected');
            $("#npcid").val("");
            $("#exp").val(0);
            $("#money").val(0);
            $("#karma").val(0);
            $("#hintsText").val("");
            $("#item").val("");
            $("#mainForm").attr('action', "addQuestion.php");
        }

        $(document).ready(function () {
            $("#content-tab").click();

            $(".edit").click(function () {
                $(this).parents("tr").find("td:first-child").each(function () {
                    window.location.href = "quest.php?questionId=" + $(this).text();
                });
            });
            // Delete row on delete button click
            $(".delete").click(function () {
                window.location.href = "deleteQuestion.php?questionId=" + $(this).parent().siblings(":first").text();
                $(".add-new").removeAttr("disabled");
            });
            $("#questionType").change(function (event) {
                var type = $("#questionType").val();
                if (type == "Reorder") {
                    $("#code").show();
                    $("#cOutputDiv").hide();
                    $("#eOutputDiv").hide();
                    $("#answer").show();
                } else if (type == "Tracing program") {
                    $("#code").show();
                    $("#cOutputDiv").show();
                    $("#eOutputDiv").hide();
                    $("#answer").show();
                } else {
                    $("#code").show();
                    $("#cOutputDiv").show();
                    $("#eOutputDiv").show();
                    $("#answer").show();
                }

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
                <h1 class="page-header">Questions Management</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Add/Modify Quest
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form method="post" id="mainForm" action="<?php
                        if (empty($_GET["questionId"])) {
                            echo "addQuestion.php";
                        } else {
                            echo "updateQuestion.php";
                            $rs = query("SELECT * FROM questions where questionId=" . $_GET["questionId"] . ";");
                            $rc = mysqli_fetch_assoc($rs);
                            $GLOBALS['type'] = $rc['type'];
                            $GLOBALS['questionId'] = $_GET['questionId'];

                            $rs = query("SELECT * FROM questions WHERE questionId = '$questionId';");
                            $GLOBALS['npcId'] = $rc['npcId'];
                            $GLOBALS['rating'] = $rc['rating'];

                            $rs = query("SELECT code FROM code WHERE questionId = '$questionId';");
                            $codeArr = array();
                            while ($rc = mysqli_fetch_assoc($rs)) {
                                $codeArr[] = $rc['code'];
                            }
                            $GLOBALS['code'] = implode("&#13;&#10;", $codeArr);

                            $rs = query("SELECT answer FROM answer WHERE questionId = '$questionId';");
                            $answerArr = array();
                            while ($rc = mysqli_fetch_assoc($rs)) {
                                $answerArr[] = $rc['answer'];
                            }
                            $GLOBALS['answer'] = implode("&#13;&#10;", $answerArr);

                            $rs = query("SELECT output FROM currentOutput WHERE questionId = '$questionId';");
                            $coArr = array();
                            while ($rc = mysqli_fetch_assoc($rs)) {
                                $coArr[] = $rc['output'];
                            }
                            $GLOBALS['co'] = implode("&#13;&#10;", $coArr);

                            $rs = query("SELECT output FROM expectedOutput WHERE questionId = '$questionId';");
                            $eoArr = array();
                            while ($rc = mysqli_fetch_assoc($rs)) {
                                $eoArr[] = $rc['output'];
                            }
                            $GLOBALS['eo'] = implode("&#13;&#10;", $eoArr);

                            $rs = query("SELECT money,karma,experience FROM questions WHERE questionId = '$questionId';");
                            $GLOBALS['quantity'] = array();
                            while ($rc = mysqli_fetch_assoc($rs)) {
                                $GLOBALS['quantity'][0] = $rc['experience'];
                                $GLOBALS['quantity'][1] = $rc['money'];
                                $GLOBALS['quantity'][2] = $rc['karma'];
                            }

                            $rs = query("SELECT hints FROM hints WHERE questionId = '$questionId';");
                            $hintsArr = array();
                            while ($rc = mysqli_fetch_assoc($rs)) {
                                $hintsArr[] = $rc['hints'];
                            }
                            $GLOBALS['hints'] = implode("&#13;&#10;", $hintsArr);

                            $rs = query("SELECT itemCount,itemName FROM rewarditem WHERE questionId = '$questionId';");
                            $itemArr = array();
                            while ($rc = mysqli_fetch_assoc($rs)) {
                                $itemArr[] = $rc['itemName'] . "," . $rc['itemCount'];
                            }
                            $GLOBALS['items'] = implode("&#13;&#10;", $itemArr);
                            //$GLOBALS[''];
                        } ?>">
                            <input type="hidden" id="qid" name="questionId" value="<?PHP echo $_GET['questionId']; ?>">
                            <script>
                                $(document).ready(function () {
                                    $("#questionType option[value='<?php echo $type;?>']").attr('selected', 'selected');
                                    $("#questionType").change();
                                });
                            </script>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="content-tab" data-toggle="tab" href="#content"
                                       role="tab" aria-controls="content" aria-selected="true">Content</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reward-tab" data-toggle="tab" href="#reward" role="tab"
                                       aria-controls="reward" aria-selected="false">Reward</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="hints-tab" data-toggle="tab" href="#hints"
                                       role="tab" aria-controls="hints" aria-selected="false">Hints</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="content" role="tabpanel"
                                     aria-labelledby="content-tab" style="padding:10px">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>Question Type</label>
                                            <select style="margin-bottom: 10px" name="questionType"
                                                    id="questionType"
                                                    class="form-group">
                                                <option value="Logic error" <?php if ($type == "Logic error") echo "selected"; ?>>
                                                    Logic
                                                    error
                                                </option>
                                                <option value="Syntax error" <?php if ($type == "Syntax error") echo "selected"; ?>>
                                                    Syntax error
                                                </option>
                                                <option value="Tracing program" <?php if ($type == "Tracing program") echo "selected"; ?>>
                                                    Tracing program
                                                </option>
                                                <option value="Reorder" <?php if ($type == "Reorder") echo "selected"; ?>>
                                                    Reorder
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Rating</label>
                                            <select style="margin-bottom: 10px;width:150px" name="rating"
                                                    id="rating" class="form-group">
                                                <option value="Easy" <?php if ($rating == "Easy") echo "selected" ?>>
                                                    Easy
                                                </option>
                                                <option value="Normal" <?php if ($rating == "Normal") echo "selected" ?>>
                                                    Normal
                                                </option>
                                                <option value="Hard" <?php if ($rating == "Hard") echo "selected" ?>>
                                                    Hard
                                                </option>
                                                <option value="Expert" <?php if ($rating == "Expert") echo "selected" ?>>
                                                    Expert
                                                </option>
                                                <option value="Nightmare" <?php if ($rating == "Nightmare") echo "selected" ?>>
                                                    Nightmare
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Npc Id</label>
                                            <input maxlength="30" id="npcid" name="npcid" placeholder=""
                                                   style="margin-bottom: 10px"
                                                   type="text" value="<?php echo $npcId; ?>"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Question Coding</label>
                                            <div>
                                        <textarea class="form-control" rows="8" style="margin-bottom: 10px; width:100%;" id="code"
                                                  name="QuestionCode"><?PHP if (isset($code)) echo $code; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Answer</label>
                                            <div>
                                        <textarea class="form-control" rows="8" style="margin-bottom: 10px; width:100%" id="answer"
                                                  name="answer"><?PHP if (isset($answer)) echo $answer; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6" id="eOutputDiv">
                                            <label>Expect Output</label>
                                            <div>
                                        <textarea class="form-control" rows="8" style="margin-bottom: 10px; width:100%" id="eOutput"
                                                  name="expectOutput"><?PHP if (isset($eo)) echo $eo; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-6" id="cOutputDiv">
                                            <label>Current Output</label>
                                            <div>
                                        <textarea class="form-control" rows="8" style="margin-bottom: 10px; width:100%;" id="cOutput"
                                                  name="currentOutput"><?PHP if (isset($co)) echo $co; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="reward" role="tabpanel" aria-labelledby="reward"
                                     style="padding:10px">
                                    <label>Reward</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            Experience: <input type="number" id="exp" name="experience"
                                                               style="width: 140px;"
                                                               value="<?PHP echo $quantity[0]; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            Money : <input type="number" id="money" name="money" style="width: 140px;"
                                                           value="<?PHP echo $quantity[1]; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            Karma : <input type="number" id="karma" name="karma" style="width: 140px;"
                                                           value="<?PHP echo $quantity[2]; ?>">
                                        </div>
                                    </div>
                                    Items:<br>
                                    <textarea class="form-control" rows="8" style="width:100%;" id="item"
                                              name="item" placeholder="item, qty"><?PHP echo $items; ?></textarea>
                                </div>
                                <div class="tab-pane fade" id="hints" role="tabpanel" aria-labelledby="hints"
                                     style="padding:10px">
                                    <label>Hints</label>
                                    <div>
                                            <textarea class="form-control" rows="8" style="margin-bottom: 10px; width:100%;height: 350px"
                                                      name="hints" id="hintsText"><?PHP echo $hints; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <p><input type="submit" value="Submit" class="btn btn-primary"></p>
                        </form>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.col-lg-9 -->
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Quest List
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div style="width:100%; height:450px; overflow:scroll;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>question Id</th>
                                    <th>type</th>
                                    <th>actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $rs = query("SELECT * FROM questions;");
                                while ($rc = mysqli_fetch_assoc($rs)) {
                                    echo "<tr><td>";
                                    echo $rc['questionId'];
                                    echo "</td><td>";
                                    echo $rc['type'];
                                    echo "</td><td>";
                                    echo "<a class='edit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>";
                                    echo "<a class='delete' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>";
                                    echo "</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="javascript:clear();" class="btn btn-default btn-block">Create Question</a>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php mysqli_close($conn); ?>
</body>

</html>

