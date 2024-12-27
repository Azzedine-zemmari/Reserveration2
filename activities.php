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
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">' . htmlspecialchars($activite['titre']) . '</h2>
                    <p class="text-gray-600 mb-4">' . htmlspecialchars($activite['description']) . '</p>
                    <form method="POST">
                        <button type="submit" name="reservation" class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none transition-all duration-300">
                            Réservation
                        </button>
                    </form>
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

    <!-- Navigation -->
    <nav class="bg-blue-600 p-4 text-white">
        <ul class="flex space-x-4 justify-center">
            <li><a href="#" class="hover:text-gray-200">Home</a></li>
            <li><a href="#activities" class="hover:text-gray-200">Activités</a></li>
            <li><a href="#contact" class="hover:text-gray-200">Contact</a></li>
        </ul>
    </nav>

    <!-- Contenu de la page -->
    <section id="activities" class="p-8">
        <h1 class="text-4xl text-center font-bold mb-10 text-gray-800">Nos Activités</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php 
            // Afficher les activités
            $display->showActivites($activites);
            ?>
        </div>
    </section>

    <!-- Future Activities -->
    <section class="py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-12">Future Activities</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Surfing" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Surfing</h3>
                    <p class="text-gray-600 text-sm">Explore the waves with exciting surfing experiences on stunning beaches.</p>
                </div>
            </div>
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img4.jpg" alt="Skydiving" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Skydiving</h3>
                    <p class="text-gray-600 text-sm">Feel the thrill of freefalling from thousands of feet in the sky.</p>
                </div>
            </div>
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Party" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Party</h3>
                    <p class="text-gray-600 text-sm">Join exciting party events with vibrant music and dancing.</p>
                </div>
            </div>
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Dessert Tasting" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Dessert Tasting</h3>
                    <p class="text-gray-600 text-sm">Indulge in an exclusive tasting experience of gourmet desserts.</p>
                </div>
            </div>
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Vegetarian Cooking" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Vegetarian Cooking</h3>
                    <p class="text-gray-600 text-sm">Learn to prepare delicious and healthy vegetarian dishes.</p>
                </div>
            </div>
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Yoga Classes" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Yoga Classes</h3>
                    <p class="text-gray-600 text-sm">Relax and rejuvenate with expert-led yoga sessions for all levels.</p>
                </div>
            </div>
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl hover:translate-y-2 duration-300 ease-in-out">
                <img src="./images/img7.jpg" alt="Hiking Adventures" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Hiking Adventures</h3>
                    <p class="text-gray-600 text-sm">Discover breathtaking landscapes on guided hiking tours.</p>
                </div>
            </div>
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

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-6 text-center">
        <p>&copy; 2024 Notre Agence - Tous droits réservés</p>
    </footer>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->closeConnection();
?>
