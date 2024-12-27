<?php
require "./Activite.php";
$ClsConn = new connection();
$conn = $ClsConn->getConnection();

$id = $_GET['activite_id'];

$sql = "select * from activite where idActivite = '$id' ";
$stmt = $conn->prepare($sql);
if ($stmt->execute()) {
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "errrror in show the option for the select";
}

if(isset($_POST['submit'])){
    $idP = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $type = $_POST['type'];
    $places_disponibles = $_POST['places_disponibles'];

    $activite = new Activite();
    $obj = $activite->update($idP,$titre,$description,$prix,$date_debut,$date_fin,$type,$places_disponibles);
    if($obj){
        header("Location: ./ActiviteDash.php");
    }
    else{
        echo "error in this update";
    }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <main class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
            <!-- Logo -->
            <div class="flex justify-center">
                <img src="./image/ochef-removebg-preview.png" alt="Logo" class="h-20 w-auto">
            </div>

            <!-- Form -->
            <form id="signupForm" action="" method="POST" class="mt-8 space-y-6">
            <input type="hidden" id="id" name="id" value="<?php echo $data['idActivite']; ?>"
            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">    
            <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            titre
                        </label>
                        <input type="text" id="titre" name="titre" value = "<?php echo $data['titre']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="nameError">Invalid title (only letters allowed).</small>
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            description
                        </label>
                        <input type="text" id="description" name="description" value = "<?php echo $data['description']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="firstNameError">Invalid description (only letters allowed).</small>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            prix
                        </label>
                        <input type="text" id="prix" name="prix" value = "<?php echo $data['prix']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="emailError">Invalid email address.</small>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            date_debut
                        </label>
                        <input type="date" id="date_debut" name="date_debut" value = "<?php echo $data['date_debut']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="passwordError">Password must be at least 6 characters long.</small>
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            date_fin
                        </label>
                        <input type="date" id="date_fin" name="date_fin" value = "<?php echo $data['date_fin']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="passwordError">Password must be at least 6 characters long.</small>
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            type
                        </label>
                        <select name="type" id="">
                            <?php 
                                $sql_types = "select distinct type from activite";
                                $stmt = $conn->prepare($sql_types);
                                if($stmt->execute()){
                                    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($types as $type){
                                        $selected = ($data['type'] == $types['type']) ? 'selected' : '';
                                        echo "<option value = \"" . $types['type'] . "\" $selected>".$type['type'] . "</option>";
                                    }
                                }
                                else{
                                    echo "<option>error fetching</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            places_disponibles
                        </label>
                        <input type="number" id="places_disponibles" name="places_disponibles" value = "<?php echo $data['places_disponibles']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        name="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Sign up
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>