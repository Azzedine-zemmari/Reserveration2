<?php

// Classe de connexion à la base de données
class Connection {
    private $host = "localhost";
    private $dbName = "Rev2";
    private $userName = "root";
    private $userPass = "";
    private $db;

    // Méthode pour obtenir la connexion
    public function getConnection() {
        try {
            if (!$this->db) {
                $this->db = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->dbName,
                    $this->userName,
                    $this->userPass
                );
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return $this->db;
        } catch (PDOException $e) {
            die("La connexion a échoué: " . $e->getMessage());
        }
    }

    // Méthode pour fermer la connexion
    public function closeConnection() {
        $this->db = null;
    }
}

// Classe pour gérer les activités
class Activite {
    private $db;

    // Constructeur qui prend la connexion en paramètre
    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour obtenir toutes les activités
    public function getAllActivites() {
        $stmt = $this->db->prepare('SELECT * FROM activite');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Classe pour afficher les données
class Display {
    // Méthode pour afficher une activité
    public function showActivites($activites) {
        foreach ($activites as $activite) {
            echo '
            <div class="mb-16 bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-3xl font-bold text-primary mb-6 border-b-2 border-primary pb-2">
                    ' . htmlspecialchars($activite['titre']) . '
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="border rounded-lg p-4 shadow-md hover:scale-105 transition-transform duration-300 ease-in-out">
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4 text-center">
                            ' . htmlspecialchars($activite['titre']) . '
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">' . htmlspecialchars($activite['description']) . '</p>';
            
            if (!empty($activite['image'])) {
                echo '
                        <img 
                            src="' . htmlspecialchars($activite['image']) . '" 
                            alt="' . htmlspecialchars($activite['titre']) . '" 
                            class="w-full h-32 object-cover rounded-md mt-4"
                        >';
            }
            
            echo '
                        <form method="POST">
                            <button type="submit" name="reservation" class="w-[50%] py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                Réservation
                            </button>
                        </form>
                    </div>
                </div>
            </div>';
        }
    }
}

// Code principal
$conn = new Connection();  // Créer une instance de Connection
$db = $conn->getConnection();  // Obtenir la connexion à la base de données

// Créer une instance d'Activite et récupérer les activités
$activiteObj = new Activite($db);
$activites = $activiteObj->getAllActivites();

// Créer une instance de Display pour afficher les activités
$display = new Display();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Nos Activités</title>
</head>
<body class="bg-gray-50">

    <!-- Contenu de la page -->
    <section class="p-8">
        <h1 class="text-4xl text-center font-bold mb-10 text-gray-800">Nos Activités</h1>

        <?php 
        // Afficher les activités
        $display->showActivites($activites);
        ?>

    </section>

    <section class="py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-12">Future Activities</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Activity Card 1 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Surfing" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Surfing</h3>
                    <p class="text-gray-600 text-sm">Explore the waves with exciting surfing experiences on stunning beaches.</p>
                </div>
            </div>
            <!-- Activity Card 2 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img4.jpg" alt="Skydiving" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Skydiving</h3>
                    <p class="text-gray-600 text-sm">Feel the thrill of freefalling from thousands of feet in the sky.</p>
                </div>
            </div>
            <!-- Activity Card 3 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Party" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Party</h3>
                    <p class="text-gray-600 text-sm">Join exciting party events with vibrant music and dancing.</p>
                </div>
            </div>
            <!-- Activity Card 4 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Dessert Tasting" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Dessert Tasting</h3>
                    <p class="text-gray-600 text-sm">Indulge in an exclusive tasting experience of gourmet desserts.</p>
                </div>
            </div>
            <!-- Activity Card 5 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Vegetarian Cooking" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Vegetarian Cooking</h3>
                    <p class="text-gray-600 text-sm">Learn to prepare delicious and healthy vegetarian dishes.</p>
                </div>
            </div>
            <!-- Activity Card 6 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Yoga Classes" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Yoga Classes</h3>
                    <p class="text-gray-600 text-sm">Relax and rejuvenate with expert-led yoga sessions for all levels.</p>
                </div>
            </div>
            <!-- Activity Card 7 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Hiking Adventures" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Hiking Adventures</h3>
                    <p class="text-gray-600 text-sm">Discover breathtaking landscapes on guided hiking tours.</p>
                </div>
            </div>
            <!-- Activity Card 8 -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Beach Volleyball" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Beach Volleyball</h3>
                    <p class="text-gray-600 text-sm">Join a fun-filled game of volleyball at the beach with friends.</p>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->closeConnection();
?>
