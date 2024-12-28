<?php
session_start();
require "./Activite.php";
$ClsConn = new connection();
$conn = $ClsConn->getConnection();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'superAdmin')) {
    echo "Access denied!";
    exit();
}

$id = $_GET['activite_id'];

$sql = "SELECT * FROM activite WHERE idActivite = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Error: Activity not found.";
    exit;
}

if (isset($_POST['submit'])) {
    $idP = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $type = $_POST['type'];
    $places_disponibles = $_POST['places_disponibles'];

    $activite = new Activite();
    $obj = $activite->update($idP, $titre, $description, $prix, $date_debut, $date_fin, $type, $places_disponibles);
    if ($obj) {
        header("Location: ./ActiviteDash.php");
        exit;
    } else {
        echo "Error in updating this activity.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Activity</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <main class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
            <!-- Form -->
            <form id="signupForm" action="" method="POST" class="mt-8 space-y-6">
                <input type="hidden" id="id" name="id" value="<?php echo $data['idActivite']; ?>"
                class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Title
                        </label>
                        <input type="text" id="titre" name="titre" value="<?php echo $data['titre']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <input type="text" id="description" name="description" value="<?php echo $data['description']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Price
                        </label>
                        <input type="text" id="prix" name="prix" value="<?php echo $data['prix']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Start Date
                        </label>
                        <input type="date" id="date_debut" name="date_debut" value="<?php echo $data['date_debut']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            End Date
                        </label>
                        <input type="date" id="date_fin" name="date_fin" value="<?php echo $data['date_fin']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Type
                        </label>
                        <select name="type" id="type" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <?php 
                                $sql_types = "SELECT DISTINCT type FROM activite";
                                $stmt = $conn->prepare($sql_types);
                                if ($stmt->execute()) {
                                    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($types as $type) {
                                        $selected = ($data['type'] == $type['type']) ? 'selected' : '';
                                        echo "<option value='" . $type['type'] . "' $selected>" . $type['type'] . "</option>";
                                    }
                                } else {
                                    echo "<option>error fetching types</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Available Places -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Available Places
                        </label>
                        <input type="number" id="places_disponibles" name="places_disponibles" value="<?php echo $data['places_disponibles']; ?>"
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" name="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Update Activity
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
