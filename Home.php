<?php
//making connection with the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes app";

    $conn = mysqli_connect($servername,$username,$password,$database);

    if (isset($_GET['delete'])) 
    {
        $sno = $_GET['delete'];
        $sql = "DELETE FROM `mynotes` WHERE `mynotes`.`S.No.` = $sno";
        $result = mysqli_query($conn,$sql);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (isset($_POST['snoEdit'])) {
            $sno = $_POST["snoEdit"];
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];

            $sql = "UPDATE `mynotes` SET `Title` = '$title' , `Description` = '$description',`TimeOfIssue`= current_timestamp() WHERE `mynotes`.`S.No.` = $sno;";
            $result = mysqli_query($conn,$sql);
        }
        else {
            $title = $_POST["title"];
            $description = $_POST["description"];

            $sql = "INSERT INTO `mynotes` ( `Title`, `Description`) VALUES ( '$title', '$description');";
            $result = mysqli_query($conn,$sql);
        }
    }
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css ">
    <title>MyNotes App</title>

</head>

<body>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/project/Home.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="snoEdit" name="snoEdit">
                        <div class="form-group">
                            <label for="titleEdit">Title Of Note</label>
                            <input type="text" class="form-control" id="titleEdit" aria-describedby="titleEdit"
                                name="titleEdit">
                        </div>
                        <div class="form-group">
                            <label for="descriptionEdit">Description of Note</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="#">MyNotes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/project">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">About <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Contact<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- <?php
        //for making the request

    ?> -->

    <div class="container ">
        <h3 style="text-align: center;" class="my-3">MyNotes...</h3>
        <form action="/project/Home.php" method="POST">
            <div class="form-group">
                <label for="title">Title Of Note</label>
                <input type="text" class="form-control" id="title" aria-describedby="title" name="title"
                    placeholder="Enter the title of your note">
            </div>
            <div class="form-group">
                <label for="description">Description of Note</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Describe your note"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <hr>
    </div>

    <div class="container my-3">

        <table class="table table-bordered" id="myTable">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                    <th scope="col">Time Of Issue</th>
                </tr>
            </thead>
            <tbody>
                <?php
            // We are displaying the records in the website
            $sql = "SELECT * FROM `mynotes`";
            $result = mysqli_query($conn,$sql);
            $sno = 1;
            
            while ($row = mysqli_fetch_assoc($result) ) {
                // echo $row['S.No.'].$row['Title'].$row['Description'].$row['TimeOfIssue'];

                echo "<tr>
                <th scope='row'>".$sno."</th>
                <td>".$row['Title']."</td>
                <td>".$row['Description']."</td>
                <td>"."<button class='edit btn btn-sm btn-primary ' style='margin: 10px; width: 61px;' id=".$row['S.No.']." >Edit</button>"."<button class='delete btn btn-sm btn-primary' id=d".$row['S.No.']." style='margin: 10px;'>Delete</button>"."</td>
                <td>".$row['TimeOfIssue']."</td>
                </tr>" ;
                $sno++;
            }


        ?>
            </tbody>
        </table>


    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        let edits = document.getElementsByClassName("edit");
        // console.log(edits);

        for (let element of edits) {
            element.addEventListener("click", (e) => {

                let tr = e.target.parentNode.parentNode;
                let title = tr.getElementsByTagName("td")[0].innerText;
                let description = tr.getElementsByTagName("td")[1].innerText;
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;

                $('#editModal').modal('toggle');


            })
        }

        //For grabbing element having class delete
        let deletes = document.getElementsByClassName("delete");

        for (let element of deletes) {
            element.addEventListener("click", (e) => {
                let sno = e.target.id.substr(1,);
                console.log(sno);

            if(confirm("Are you sure you want to delete this note?"))
            {
                window.location = `/project/Home.php?delete=${sno}`;
            }
            else
            {
                console.log("No");
            }
            
            })
        }
    </script>
</body>

</html>