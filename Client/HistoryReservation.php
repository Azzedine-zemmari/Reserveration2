<?php
require "./Reservation.php";
if (!isset($_SESSION['user_id']) || (!($_SESSION['role'] == 'user' || $_SESSION['role'] == 'admin'))) {
    echo "u shouldnot be here get out ";
    exit();
}
$id = $_SESSION['user_id'];

$cls = new Reservation();
$history = $cls->historyReservation($id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header class="flex justify-between px-2 py-3 bg-gray-800">
        <img src="./images/logo-white.png" class="w-40" alt="">
        <div class="flex gap-3 items-center">
            <img src="./images/avatar.png" class="w-10 h-10" alt="">
            <p class="text-white font-bold  " id="adminMenu">Hi,Admin</p>
        </div>
    </header>
    <div id="smallMenu" class=" hidden  absolute right-2 z-50 bg-gray-800 text-white border border-grey-200 rounded-lg w-24 md:hidden">
        <ul class=" pl-1">
            <li class="mt-1"><a class="font-bold border-b-2 border-b-green-600" href="#">client</a></li>
            <li class="mt-2"><a class="font-bold border-b-2 border-b-red-600" href="./Activite/activite.php">activite</a></li>
            <li class="my-2"><a class="font-bold border-b-2 border-b-yellow-600" href="./Reserve/reservation.php">reservation</a></li>
        </ul>
    </div>
    <main class="flex">
        <aside class ="hidden md:flex flex-col shadow-sm w-56 bg-gray-800 h-screen">
        <!-- <div class="flex gap-5 items-center pl-3 py-2 border-b-2 border-green-600">
                <img src="./images/hire.png" class="w-8 h-8" alt="">
                <a href="./index.php" class="w-20 text-white">Admins</a>
            </div>
            <div class="flex gap-5 items-center pl-3 py-2 border-b-2 border-red-600">
                <img src="./images/travel-bag.png" class="w-8 h-8" alt="">
                <a href="./Activite/activite.php" class="w-20 text-white">Register</a>
            </div> -->
        </aside>
        <section class="w-screen md:w-[calc(100%-224px)]">
        <div class="bg-gradient-to-r from-[#2f88da] to-[#07075a] px-5 py-3 flex justify-between w-full rounded-bl-lg rounded-br-lg">
            <h1 class="text-white font-bold">Client table</h1>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr>
                        <th class="px-2 md:px-6 py-3">#</th>
                        <th class="px-2 md:px-6 py-3">titre</th>
                        <th class="px-2 md:px-6 py-3">status</th>
                        <th class="px-2 md:px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($history as $c): ?>
                    <tr class="border-b">
                        <td class="px-2 md:px-6 py-3"><?php echo $c['id_reservation'] ?></td>
                        <td class="px-2 md:px-6 py-3"><?php echo $c['titre'] ?></td>
                        <td class="px-2 md:px-6 py-3"><?php echo $c['status'] ?></td>
                        <td class="px-2 md:px-6 py-3 flex space-x-2">
                            <a class="bg-blue-400 text-white p-3 rounded-lg" href="./UpdateReservationPage.php?idReservation=<?php echo $c['id_reservation'] ?>">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </section>
    </main>
    <script>
        const adminMenu = document.getElementById("adminMenu");
        const smallMenu = document.getElementById("smallMenu");
        adminMenu.addEventListener("click",()=>{
            smallMenu.classList.toggle("hidden")
        })
    </script>
</body>
</html>