<?php
require "./Admin.php";

//get class Admin

if(isset($_POST['submit'])){
    $name =htmlspecialchars(trim( $_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $Cls = new Admins();
    $method = $Cls->registerAdmin($name,$prenom,$email,$password);
    if($method){
        header("Location: ./Admin.php");
    }
    else{
        echo "errrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrror";
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
                <img src="./images/ochef-removebg-preview.png" alt="Logo" class="h-20 w-auto">
            </div>

            <!-- Header -->
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Sign up</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Already have an account? 
                    <a href="./login.php" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in here</a>
                </p>
            </div>

            <!-- Form -->
            <form id="signupForm" action="" method="POST" class="mt-8 space-y-6">
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Name
                        </label>
                        <input type="text" id="name" name="nom"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <small class="text-red-500 hidden" id="nameError">Invalid name (only letters allowed).</small>
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            First Name
                        </label>
                        <input type="text" id="firstName" name="prenom"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <small class="text-red-500 hidden" id="firstNameError">Invalid first name (only letters allowed).</small>
                        </div>

                    <!-- Email -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email" id="email" name="email"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <small class="text-red-500 hidden" id="emailError">Invalid email address.</small>
                        </div>

                    <!-- Password -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" id="password" name="password"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <small class="text-red-500 hidden" id="passwordError">Password must be at least 6 characters long.</small>
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
    <script>
        const signupForm = document.getElementById("signupForm");
        signupForm.onsubmit = function(){
            let isValid = true;

            const nameInput = document.getElementById("name");
            const nameError = document.getElementById("nameError");
            const nameRegex = /^[A-Za-z\s]+$/;
            
            if(!nameRegex.test(nameInput.value)){
                isValid = false;
                nameError.classList.remove("hidden");
            }
            else{
                nameError.classList.add("hidden");
            }

            const firstName = document.getElementById("firstName");
            const firstNameError = document.getElementById("firstNameError")

            if(!nameRegex.test(firstName.value)){
                isValid = false;
                firstNameError.classList.remove("hidden")
            }
            else{
                firstNameError.classList.add("hidden")
            }

            const adress = document.getElementById("adress");
            const adreesError = document.getElementById("adreesError");
            const addressRegex = /^[a-zA-Z0-9\s.,'-/#]+$/;

            if(!addressRegex.test(adress.value)){
                isValid = false;
                adreesError.classList.remove("hidden")
            }
            else{
                adreesError.classList.add("hidden")
            }
            const tel = document.getElementById("tel");
            const phoneError = document.getElementById("phoneError")

            const phoneRegex = /^\d{10}$/;
            if(!phoneRegex.test(tel.value)){
                isValid = false
                phoneError.classList.remove("hidden")
            }
            else{
                phoneError.classList.add("hidden")
            }

            const email = document.getElementById("email");
            const emailError = document.getElementById("emailError")

            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/


            if(!emailRegex.test(email.value)){
                isValid = false;
                emailError.classList.remove("hidden")
            }
            else{
                emailError.classList.add("hidden");
            }

            const password = document.getElementById("password")
            const passwordError = document.getElementById("passwordError")

            if(password.value < 6){
                isValid = false
                passwordError.classList.remove("hidden");
            }
            else{
                passwordError.classList.add("hidden")
            }

            return isValid

        }
    </script>
</body>
</html>