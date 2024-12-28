<?php


class Connection {
    private $host = "localhost";
    private $dbName = "Rev2";
    private $userName = "root";
    private $userPass = "Azzedine2004";
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
            <div class="relative bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="p-8 space-y-6">
                    <!-- Header Section -->
                    <div class="space-y-2">
                        <h2 class="text-xl font-medium text-gray-800">' . $activite['titre'] . '</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">' . $activite['description'] . '</p>
                    </div>
                    
                    <!-- Details Section -->
                    <div class="space-y-4 border-t border-gray-100 pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Prix</span>
                            <span class="text-sm font-medium text-gray-800">' . $activite['prix'] . ' €</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Période</span>
                            <span class="text-sm text-gray-800">
                                ' . $activite['date_debut'] . ' - ' . $activite['date_fin'] . '
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Type</span>
                            <span class="text-sm font-medium text-gray-800">' . $activite['type'] . '</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Places disponibles</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                ' . $activite['places_disponibles'] . '
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="pt-4">
                        <a href="./Client/ReservationPage.php" 
                           name="reservation" 
                           class="block w-full text-center px-6 py-3 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                            Réserver
                        </a>
                    </div>
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
    <header class="bg-gray-800 text-white px-4 py-3 relative">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <img src="./images/logo-white.png" class="h-8 w-auto md:h-10" alt="Logo">
                
                <!-- Burger Menu Button -->
                <button id="burger-menu" class="md:hidden p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"/>
                    </svg>
                </button>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center justify-between flex-1 ml-8">
                    <nav>
                        <ul class="flex space-x-6">
                            <!-- <li><a href="#" class="hover:text-gray-200 transition-colors">Home</a></li> -->
                            <li><a href="#activities" class="hover:text-gray-200 transition-colors">Activités</a></li>
                            <li><a href="activities.php#reviews-contact" class="hover:text-gray-200 transition-colors">Contact</a></li>
                            <li><a href="./Client/HistoryReservation.php" class=" hover:text-gray-200 transition-colors py-2">ReservationDash</a></a></li>
                            <li><a href="./logout.php" class="hover:text-gray-200 transition-colors">logout</a></li>
                        </ul>
                    </nav>

                    <form method="POST" action="" class="flex ml-6">
                        <input
                            name="searchTerm"
                            type="text"
                            class="w-48 p-2 bg-gray-200 rounded-l-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Recherche"
                        >
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-800 transition duration-300">
                            Recherche
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <nav class="space-y-3">
                    <ul class="flex flex-col space-y-2">
                        <!-- <li><a href="#" class="block hover:text-gray-200 transition-colors py-2">Home</a></li> -->
                        <li><a href="#activities" class="block hover:text-gray-200 transition-colors py-2">Activités</a></li>
                        <li><a href="activities.php#reviews-contact" class="block hover:text-gray-200 transition-colors py-2">Contact</a></li>
                        <li><a href="./Client/HistoryReservation.php" class="block hover:text-gray-200 transition-colors py-2">ReservationDash</a></a></li>
                        <li><a href="LoginAdmin.php" class="block hover:text-gray-200 transition-colors py-2">Login</a></li>
                    </ul>
                    <form method="POST" action="" class="flex flex-col space-y-2">
                        <input
                            name="searchTerm"
                            type="text"
                            class="w-full p-2 bg-gray-200 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Recherche"
                        >
                        <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition duration-300">
                            Recherche
                        </button>
                    </form>
                </nav>
            </div>
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
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const burgerMenu = document.getElementById('burger-menu');
            const mobileMenu = document.getElementById('mobile-menu');
            
            burgerMenu.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                
                const svg = burgerMenu.querySelector('svg');
                if (mobileMenu.classList.contains('hidden')) {
                    svg.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"/>
                    `;
                } else {
                    svg.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    `;
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) { // md breakpoint
                    mobileMenu.classList.add('hidden');
                    const svg = burgerMenu.querySelector('svg');
                    svg.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"/>
                    `;
                }
            });
        });
    </script>
</body>
</html>

<?php $conn->closeConnection();?>
