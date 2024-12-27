<?php


class Connection {
    private $host = "localhost";
    private $dbName = "Rev2";
    private $userName = "root";
    private $userPass = "";
    private $db;


    public function __construct() {
        $this->db = $this->getConnection();
    }
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
    public function closeConnection() {
        $this->db = null;
    }
}

class Activite {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllActivites() {
        $stmt = $this->db->prepare('SELECT * FROM activite');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchActivites($search) {
        $stmt = $this->db->prepare("SELECT * FROM activite WHERE titre LIKE '%$search%'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Display {
    //afficher une activité
    public function showActivites($activites) {
        if (empty($activites)) {
            echo '<p class="text-center text-xl text-gray-600">Aucune activité trouvée pour votre recherche.</p>';
            return;
        }
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
$conn = new Connection();
$db = $conn->getConnection();

$search = "";
if (isset($_POST['searchTerm'])) {
    $search = $_POST['searchTerm'];
}


$activiteObj = new Activite($db);
if($search){
    $activites = $activiteObj->searchActivites($search);

} else {
    // Otherwise, get all activities
    $activites = $activiteObj->getAllActivites();
}

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
    <header class="flex justify-around px-2 py-3 bg-gray-800 text-white">
        <img src="./images/logo-white.png" class="w-40" alt="Logo">
        <div class="flex  gap-3 items-center">
                <ul class="flex space-x-4 justify-center">
                    <li class="p-2"><a href="#" class="hover:text-gray-200">Home</a></li>
                    <li class="p-2"><a href="#activities" class="hover:text-gray-200">Activités</a></li>
                    <li class="p-2"><a href="activities.php#reviews-contact">Contact</a></li>
                    <li class="p-2"><a href="activities.php#about-us">About Us</a></li>
                    <li class="p-2"><a href="LoginAdmin.php">Login</a></li>
                </ul>
                <!-- <label for="Recherche" class="p-2 w-[160px] bg-gray-300 rounded-2xl text-black">Recherche</label> -->
                <form method="POST" action="" class="flex items-center h">
                    <input name="searchTerm" type="text" class="w-[200px] p-2 bg-gray-200 rounded-l-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Recherche">
                    <button class="bg-blue-600 text-white p-2 rounded-r-lg hover:bg-blue-800 transition duration-300">Recherche</button>
                </form>

            </div>
    </header>

    <section id="activities" class="p-8">
        <h1 class="text-4xl text-center font-bold mb-10 text-gray-800">Nos Activités</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php 
            // Afficher les activités
            $display->showActivites($activites); ?>
        </div>
    </section>
    <div class="flex justify-center">
        <hr class="w-[80%] border-2 rounded-lg border-gray-500">
    </div>

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
<section id="reviews-contact" class="py-16 m-2 rounded-lg bg-red-100" style="background-image: url('./images/voyag.jpg');">
    <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Ce que disent nos clients</h2>
            <div class="space-y-6">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <p class="text-gray-600 italic">"Great website! Easy to use, quick booking, and great prices. I will definitely use it again!"</p>
                    <div class="mt-4">
                        <h4 class="text-lg font-bold text-gray-800">Marie Dupont</h4>
                        <p class="text-sm text-gray-500">⭐⭐⭐⭐⭐</p>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <p class="text-gray-600 italic">"The booking process was okay, but I had some trouble with the date selection. Otherwise, everything worked fine."</p>
                    <div class="mt-4">
                        <h4 class="text-lg font-bold text-gray-800">Jean Martin</h4>
                        <p class="text-sm text-gray-500">⭐⭐⭐⭐⭐</p>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <p class="text-gray-600 italic">"The site was hard to navigate on mobile, and I had trouble with the reservation details. Needs improvement."</p>
                    <div class="mt-4">
                        <h4 class="text-lg font-bold text-gray-800">Sophie Leblanc</h4>
                        <p class="text-sm text-gray-500">⭐⭐⭐⭐⭐</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="bg-gray-800 text-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold mb-6">Contactez-nous</h2>
            <p class="text-gray-300 mb-8">
                Vous avez des questions ou souhaitez réserver une table ? Envoyez-nous un message, et nous vous répondrons rapidement.
            </p>
            <form action="process_contact.php" method="POST">
                <div class="mb-6">
                    <label for="name" class="block text-white mb-2">Nom complet</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="Email :"
                        class="w-full px-4 py-2 bg-gray-300 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-primary" 
                        required>
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-white mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        placeholder="Email :"
                        class="w-full px-4 py-2 bg-gray-300 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-primary" 
                        required>
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-white mb-2">Message</label>
                    <textarea 
                        id="message" 
                        name="message" 
                        placeholder="Email :"
                        rows="4" 
                        class="w-full px-4 py-2 bg-gray-300 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-primary" 
                        required></textarea>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="w-[50%] py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-primary-dark transition-colors">
                        Envoyer
                    </button>
                    </div>
            </form>
        </div>
    </div>
</section>
<!-- About Us Section -->
<section id="about-us" class="py-16 px-16 bg-gray-100">
    <div class="container mx-auto text-center">
        <!-- Introduction -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">À propos de notre site</h2>
        <p class="text-lg text-gray-600 leading-relaxed mb-12">
            Bienvenue sur notre site de voyages ! Nous avons créé cette plateforme pour offrir une expérience simplifiée, moderne et agréable, permettant à nos utilisateurs de réserver des activités et des offres touristiques en toute facilité. Que ce soit pour un week-end aventure ou des vacances relaxantes, notre objectif est de rendre chaque réservation aussi simple que possible.
        </p>

        <!-- Mission Section -->
        <div class="mb-16">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Notre Mission</h3>
            <p class="text-gray-600 text-lg leading-relaxed">
                Nous nous engageons à fournir une plateforme où vous pouvez découvrir des activités passionnantes et réserver facilement vos séjours, excursions, et événements touristiques. Notre mission est de vous permettre de planifier des voyages inoubliables avec une expérience de réservation fluide et sans tracas.
            </p>
        </div>

        <!-- Team Section -->
        <div class="mb-16 p-2 rounded-lg bg-black text-gray-300">
            <h3 class="text-2xl font-bold text-white mb-6">Notre Équipe</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <img src="./images/chefs-01.jpg" alt="Responsable Marketing" class="w-44 h-44 mx-auto rounded-full mb-4">
                    <h4 class="text-xl font-bold text-white">Sophie, Responsable Marketing</h4>
                    <p class="text-gray-300">Sophie est en charge de la gestion des offres et des partenariats touristiques.</p>
                </div>
                <div class="text-center">
                    <img src="./images/chefs-02.jpg" alt="Développeur Web" class="w-44 h-44 mx-auto rounded-full mb-4">
                    <h4 class="text-xl font-bold text-white">Marc, Développeur Web</h4>
                    <p class="text-gray-300">Marc travaille sur le développement de la plateforme et l'optimisation de l'expérience utilisateur.</p>
                </div>
                <div class="text-center">
                    <img src="./images/chefs-03.jpg" alt="Support Client" class="w-44 h-44 mx-auto rounded-full mb-4">
                    <h4 class="text-xl font-bold text-white">Claire, Support Client</h4>
                    <p class="text-gray-300">Claire s'assure que chaque client ait une expérience exceptionnelle avec notre support personnalisé.</p>
                </div>
            </div>
        </div>

        <!-- Image Section -->
        <div class="mb-16">
            <img src="./images/voyag.jpg" alt="Réservation de voyages" class="w-full h-96 object-cover rounded-lg shadow-lg">
        </div>

        <!-- Final Statement -->
        <div>
            <p class="text-lg text-gray-600 leading-relaxed">
                Notre site est conçu pour vous aider à planifier des vacances parfaites et à réserver des activités touristiques selon vos préférences. Que vous soyez à la recherche d'une aventure, d'une escapade tranquille ou d'un événement spécial, nous sommes là pour vous guider tout au long du processus de réservation. Explorez nos offres et préparez-vous à partir à la découverte du monde !
            </p>
        </div>
    </div>
</section>


<!-- Footer -->
<footer class="bg-gray-800 text-white p-6 text-center">
    <p>&copy; 2024 Notre Agence - Tous droits réservés</p>
</footer>

</body>
</html>

<?php $conn->closeConnection();?>
