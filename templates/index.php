<?php
require_once ("./../init.php");
require_once ("./../helpers.php");
function getprofile($con, $userid)
{
    $sql = "SELECT * FROM profile_link where user_id = $userid";
    $result = mysqli_query($con,$sql);
    if(!$result){
        $error = myqli_error($con);
        echo "Ошибка MySQL".$error;
        die;

    }
       $results = mysqli_fetch_all($result, MYSQLI_ASSOC)
        $profile = [];

     foreach ($results as $result){
         $profile[] =$results;

     }
    return $profile;
}


$profiles = getprofile($con,$_SESSION['user']['id']);



?>


<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>


</head>
<body>

<table>
<?php foreach ($profiles as $profile): ?>
    <tr>

        <?= $profile['user_link'] ?>


    </tr>



</table>


<form method="POST" enctype="multipart/form-data" action="index.php">
    <div class="form-group">
        <label for="user_link">Аккаунт</label>
        <input name="user_link" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
               placeholder="Enter email" value="<?= $user_link['user_link'] ?? '' ?>"
    </div>


    <button type="submit" class="btn btn-primary">Submit</button>

</form>


</body>


</html>
