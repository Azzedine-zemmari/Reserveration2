<?php
require "./Activite.php";
$ActiviteClass = new Activite();
$activitFn = $ActiviteClass->getActivite();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Activités</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header class="flex justify-between px-2 py-3 bg-gray-800">
        <img src="./images/logo-white.png" class="w-40" alt="Logo">
        <div class="flex gap-3 items-center">
            <img src="./images/avatar.png" class="w-10 h-10" alt="Avatar">
            <p class="text-white font-bold" id="adminMenu">Hi, Admin</p>
        </div>
    </header>
    <main class="flex">
        <aside class="hidden md:flex flex-col shadow-sm w-56 bg-gray-800 h-screen">
            <div class="flex gap-5 items-center pl-3 py-2 border-b-2 border-green-600">
                <img src="./images/hire.png" class="w-8 h-8" alt="">
                <a href="./index.php" class="w-20 text-white">Admins</a>
            </div>
            <div class="flex gap-5 items-center pl-3 py-2 border-b-2 border-red-600">
                <img src="./images/travel-bag.png" class="w-8 h-8" alt="">
                <a href="./Activite/activite.php" class="w-20 text-white">Activités</a>
            </div>
        </aside>
        <section class="w-screen md:w-[calc(100%-224px)]">
            <div class="bg-gradient-to-r from-[#2f88da] to-[#07075a] px-5 py-3 flex justify-between w-full rounded-bl-lg rounded-br-lg">
                <h1 class="text-white font-bold">Table des Activités</h1>
                <a class="bg-green-400 text-white px-2 py-1 rounded-md" href="./FormAddActivite.php">Ajouter une activité</a>
            </div>
            <div class="overflow-x-auto">
                <?php if (isset($_GET['success'])): ?>
                    <p class="text-green-500 text-center py-2">Activité supprimée avec succès.</p>
                <?php elseif (isset($_GET['error'])): ?>
                    <p class="text-red-500 text-center py-2">Erreur lors de la suppression de l'activité.</p>
                <?php endif; ?>
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr>
                            <th class="px-2 md:px-6 py-3">#</th>
                            <th class="px-2 md:px-6 py-3">Titre</th>
                            <th class="px-2 md:px-6 py-3">Description</th>
                            <th class="px-2 md:px-6 py-3">Prix</th>
                            <th class="px-2 md:px-6 py-3">Date début</th>
                            <th class="px-2 md:px-6 py-3">Date fin</th>
                            <th class="px-2 md:px-6 py-3">Type</th>
                            <th class="px-2 md:px-6 py-3">Places disponibles</th>
                            <th class="px-2 md:px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activitFn as $act): ?>
                        <tr class="border-b">
                            <td class="px-2 md:px-6 py-3"><?php echo $act['idActivite']; ?></td>
                            <td class="px-2 md:px-6 py-3"><?php echo $act['titre']; ?></td>
                            <td class="px-2 md:px-6 py-3"><?php echo $act['description']; ?></td>
                            <td class="px-2 md:px-6 py-3"><?php echo $act['prix']; ?></td>
                            <td class="px-2 md:px-6 py-3"><?php echo $act['date_debut']; ?></td>
                            <td class="px-2 md:px-6 py-3"><?php echo $act['date_fin']; ?></td>
                            <td class="px-2 md:px-6 py-3"><?php echo $act['type']; ?></td>
                            <td class="px-2 md:px-6 py-3"><?php echo $act['places_disponibles']; ?></td>
                            <td class="px-2 md:px-6 py-3 flex space-x-2">
                                <a class="bg-blue-400 text-white p-3 rounded-lg" href="./FormUpdateActivite.php?activite_id=<?php echo $act['idActivite']; ?>">Modifier</a>
                                <a class="bg-red-400 text-white p-3 rounded-lg" href="./deleteActivite.php?activite_id=<?php echo $act['idActivite']; ?>">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
