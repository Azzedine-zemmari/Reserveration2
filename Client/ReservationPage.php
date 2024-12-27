<?php 
require "./Reservation.php";
if (!isset($_SESSION['user_id']) || (!($_SESSION['role'] == 'user' || $_SESSION['role'] == 'admin'))) {
    echo "u shouldnot be here get out ";
    exit();
}
$cls = new connection();
$connection = $cls->getConnection();

if(isset($_SESSION['user_id'])){
    $userID = $_SESSION['user_id'];
}
else{
    $this->userId = null;
}

$sql = "select idActivite, titre from activite ";
$stmt = $connection->prepare($sql);
if ($stmt->execute()) {
    $activites = $stmt->fetchAll();
} else {
    echo "errrror in show the option for the select";
}

if(isset($_POST['submit'])){
    $menu = $_POST['menu'];

    $cls = new Reservation();
    $obj = $cls->createReservation($userID,$menu);
    if($obj){
        header("Location: ./HistoryReservation.php");
    }
    else{
        echo "not okay";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Marcellus&display=swap');
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'primary': ["Marcellus", "serif"],
                    },
                }
            }
        }
    </script>
</head>
<body>
<div 
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" 
    id="pop_up">
    <div class="bg-white rounded-lg w-1/2 p-6 relative">
        <h3 class="text-xl font-primary mb-4">Reservation</h3>
        <p class="text-gray-600 mb-6">
            Thank you for choosing us. Please provide your details below to complete your reservation.
        </p>
        <form   action="" method="POST">
            <div class="flex gap-5">
                <div class="flex flex-col">
                    <label for="menu" class="text-[#C0A677] font-primary font-semibold">Menu</label>
                    <select name="menu" id="menu">
                    <?php  
                    foreach($activites as $activite):  ?>                   
                            
                    <option value="<?php echo $activite['idActivite'];?>"><?php echo $activite['titre']; ?></option>
                            
                    <?php endforeach; ?>

                    </select>
                </div>
                <button name="submit" class="justify-end bg-black px-3 py-2 rounded-md text-white">submit</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

