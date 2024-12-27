<?php
    require "./Admin.php";
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $class = new Admins();
        $obj = $class->loginAdmin($email,$password);
        if($obj){
            echo "welecome home";
        }
        else{
            echo "error";
        }
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        echo "u shouldnot be here get out ";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: #888  ;
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
            box-shadow: 2px 5px #7f7f7f ;
            border: transparent;
            border-radius: 10px;
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn {
            background-color: #3949AB;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #283593;
        }
    </style>
</head>
<body class="bg-gray-50">
    <main class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
            <!-- Logo -->
            <div class="flex justify-center">
                <img src="./image/ochef-removebg-preview.png" alt="Logo" class="h-20 w-auto">
            </div>

            <!-- Header -->
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Sign up</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Already have an account? 
                    <a href="" class="font-medium text-indigo-600 hover:text-indigo-500">Sign up here</a>
                </p>
            </div>

            <!-- Form -->
            <form action="" id="loginForm" method="POST" class="mt-8 space-y-6">
                <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="text" id="email" name="email"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <small class="text-red-500 hidden" id="emailError"></small>
                        </div>

                    <!-- Password -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" id="password" name="password"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <small class="text-red-500 hidden" id="passwordError"></small>

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
        const loginForm = document.getElementById("loginForm")
        loginForm.onsubmit = function(){
            let isValid = true;
            const email = document.getElementById("email")
            const password = document.getElementById("password")
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            

            if(email.value.trim() === ""){
                isValid = false;
                const emailError = document.getElementById("emailError");
                emailError.textContent = "email is required"
                emailError.classList.remove("hidden")
            }
            else if(!emailRegex.test(email.value.trim())){
                emailError.textContent = "Invalid email format."
                emailError.classList.remove("hidden")
            }
            else{
                emailError.classList.add("hidden")
            }
            if(password.value.trim() === ""){
                isValid = false
                const passwordError = document.getElementById("passwordError")
                passwordError.textContent = "password is required"
                passwordError.classList.remove("hidden")
            }
            else{
                passwordError.classList.add("hidden")
            }
            return isValid;
        }
    </script>
</body>
</html>