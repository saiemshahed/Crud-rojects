
<?php
$info='';
require_once "inc/functions.php";
$task=$_GET['task']?? 'report';
$error=$_GET['error']?? '0';
if('delete'==$task){
    $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);
    if($id>0){
        deleteStudents($id);
    }

}


if('seed'==$task){
    seed();
    $info="seeding is complete";
}

    $fname='';
    $lname='';
    $roll='';
    if(isset($_POST['submit'])){
    $fname=filter_input(INPUT_POST,'fname',FILTER_SANITIZE_STRING);
    $lname=filter_input(INPUT_POST,'lname',FILTER_SANITIZE_STRING);
    $roll=filter_input(INPUT_POST,'roll',FILTER_SANITIZE_STRING);
    $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);
    if($id){
        //update existing student
        if($fname!='' && $lname!='' && $roll!=''){
           $result= updateStudent($id,$fname,$lname,$roll);
            if($result){
                header('location:/crud/index.php?task=report\n');
            }else{
                $error=1;
            }
        }
    }else{
        // add a new student
        if($fname!='' && $lname!='' && $roll!=''){
            $result= addstudent($fname,$lname,$roll);
            if($result){
                header('location:/crud/index.php?task=report\n');
            }else{
                $error=1;
            }
        }


    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Example</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <style>
        body {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="column column-60 column-offset-20">
            <h2>Project 2 - CRUD</h2>
            <p>A sample project to perform CRUD operations using plain files and PHP</p>

            <?php include_once ('inc/templates/nav.php');?>
        </hr>
            <?php if($info!=''){
                echo "<p> {$info}</p>";
            } ?>

        </div>
    </div>

    <?php if('1'==$error):?>    //bujhi nai
        <div class="row">
            <div class="column column-60 column-offset-20">
               <blockquote>
                   duplicate rollnumber;

               </blockquote>
            </div>
        </div>
    <?php endif;?>



    <?php if('report'==$task):?>
    <div class="row">
        <div class="column column-60 column-offset-20">
            <?php generateReport();?>
        </div>
    </div>
    <?php endif;?>

    <?php if('add'==$task):?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="/crud/index.php?task=add" method="post">
                    <label for="fname">FirstName</label>
                    <input type="text" name="fname" id="fname"<?php echo $fname;?> >
                    <label for="lname">LastName</label>
                    <input type="text" name="lname" id="lname" <?php echo $lname;?>>
                    <label for="roll">roll</label>
                    <input type="number"name="roll" id="roll" <?php echo $roll;?>>
                    <button type="submit"class="button-primary" value="save" name="submit"> Save </button>

                </form>
            </div>
        </div>
    <?php endif;?>


    <?php if('edit'==$task):
        $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
        $student=getStudent($id);
        if($student):

        ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form  method="post" task='edit'>
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <label for="fname">FirstName</label>
                    <input type="text" name="fname" id="fname"<?php echo $student['fname'];?> >
                    <label for="lname">LastName</label>
                    <input type="text" name="lname" id="lname" <?php echo $student['lname'];?>>
                    <label for="roll">roll</label>
                    <input type="number"name="roll" id="roll" <?php echo $student['roll'];?>>
                    <button type="submit"class="button-primary" value="save" name="submit"> Update </button>

                </form>
            </div>
        </div>
    <?php
        endif;
        endif;
        ?>

</div>

<script src="assets/js/script.js"></script>
</body>
</html>
