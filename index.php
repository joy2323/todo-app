<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todolist");

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
    }
    // for deleting task
    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
    
        mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
        header('location: index.php');
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div class="heading">
        <h2 style="font-style: 'Hervetica';">ToDo List Application</h2>
    </div>
    <form method="post" action="index.php" class="input_form">
        <?php if (isset($errors)) { ?>
	        <p><?php echo $errors; ?></p>
        <?php } ?>
        <input type="text" name="task" class="task_input">
        <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
    </form>

    <table>
        <thead>
            <tr>
                <th style="width: 10px;">No.</th>
                <th style="width: 90px;">Tasks</th>
                <th style="width: 50px;">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            // select all tasks if page is visited or refreshed
            $tasks = mysqli_query($db, "SELECT * FROM tasks");

            $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                <tr>
                    <td> <?php echo $i; ?> </td>
                    <td class="task"> <?php echo $row['task']; ?> </td>
                    <td class="delete"> 
                        <a href="index.php?del_task=<?php echo $row['id'] ?>">Delete</a> 
                    </td>
                </tr>
            <?php $i++; } ?>	
        </tbody>
    </table>

</body>
</html>