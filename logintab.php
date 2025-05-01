<?php 

if (isset($_GET['error'])) {
	switch ($_GET['error']) {
   		case 'Invalid_credentials':
	  		$error = "Invalid username or password";
	  		break;
   		case 'login_error':
	  		$error = "Login error";
	  		break;
   		default:
	  		$error = "Login error";
		  	break;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS Gadgets - Login & Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #000000 100%);
        }
        .card-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .input-field:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
        .toggle-form {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }
        .toggle-form input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #1e3a8a;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #000000;
        }
        input:checked + .slider:before {
            transform: translateX(30px);
        }
        .btn-primary {
            background: linear-gradient(90deg, #1e40af 0%, #1e3a8a 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #1e3a8a 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.4);
        }
        .social-btn {
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="container mx-auto max-w-4xl relative">
        <div class="absolute top-4 left-4">
            <a href="index.php" class="flex items-center text-white bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
        <div class="flex flex-col md:flex-row rounded-xl overflow-hidden shadow-2xl">
            <!-- Brand Section -->
            <div class="w-full md:w-1/3 bg-black p-8 flex flex-col items-center justify-center">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-6">
                        <i class="fas fa-microchip text-4xl text-blue-600 mr-3"></i>
                        <h1 class="text-3xl font-bold text-white">NEXUS<br>Gadgets</br></h1>
                    </div>
                    <p class="text-gray-300 mb-6">The future of technology at your fingertips</p>
                    <div class="flex justify-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-white text-xl"></i>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center">
                            <i class="fas fa-laptop text-white text-xl"></i>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center">
                            <i class="fas fa-headphones text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Section -->
            <div class="w-full md:w-2/3 p-8 card-glass">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-white" id="form-title">Login</h2>
                    <div class="flex items-center">
                        <span class="text-white mr-2">Login</span>
                        <label class="toggle-form">
                            <input type="checkbox" id="form-toggle">
                            <span class="slider"></span>
                        </label>
                        <span class="text-white ml-2">Sign Up</span>
                    </div>
                </div>
                
                <!-- Login Form -->
                <form id="login-form" class="space-y-6">
                    <div>
                        <label for="login-email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="login-email" class="w-full pl-10 pr-3 py-2 rounded-lg text-white input-field focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="your@email.com" required>
                        </div>
                    </div>
                    <div>
                        <label for="login-password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="login-password" class="w-full pl-10 pr-3 py-2 rounded-lg text-white input-field focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                <i class="fas fa-eye-slash text-gray-400 hover:text-gray-300" id="toggle-login-password"></i>
                            </div>
                        </div>
                        <div class="flex justify-end mt-1">
                            <a href="#" class="text-sm text-blue-400 hover:text-blue-300">Forgot password?</a>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-2 px-4 rounded-lg text-white font-semibold btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Login
                    </button>
                    <div class="flex items-center justify-center space-x-4">
                        <div class="w-full h-px bg-gray-600"></div>
                        <span class="text-gray-400 text-sm">OR</span>
                        <div class="w-full h-px bg-gray-600"></div>
                    </div>
                    <div class="flex justify-center space-x-4">
                        <button type="button" class="w-10 h-10 rounded-full bg-white flex items-center justify-center social-btn">
                            <i class="fab fa-google text-red-500"></i>
                        </button>
                        <button type="button" class="w-10 h-10 rounded-full bg-white flex items-center justify-center social-btn">
                            <i class="fab fa-facebook-f text-blue-600"></i>
                        </button>
                        <button type="button" class="w-10 h-10 rounded-full bg-white flex items-center justify-center social-btn">
                            <i class="fab fa-apple text-gray-800"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Signup Form -->
                <form id="signup-form" class="space-y-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="signup-firstname" class="block text-sm font-medium text-gray-300 mb-1">First Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="signup-firstname" class="w-full pl-10 pr-3 py-2 rounded-lg text-white input-field focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="John" required>
                            </div>
                        </div>
                        <div>
                            <label for="signup-lastname" class="block text-sm font-medium text-gray-300 mb-1">Last Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="signup-lastname" class="w-full pl-10 pr-3 py-2 rounded-lg text-white input-field focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Doe" required>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="signup-email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="signup-email" class="w-full pl-10 pr-3 py-2 rounded-lg text-white input-field focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="your@email.com" required>
                        </div>
                    </div>
                    <div>
                        <label for="signup-password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="signup-password" class="w-full pl-10 pr-3 py-2 rounded-lg text-white input-field focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                <i class="fas fa-eye-slash text-gray-400 hover:text-gray-300" id="toggle-signup-password"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="signup-confirm-password" class="block text-sm font-medium text-gray-300 mb-1">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="signup-confirm-password" class="w-full pl-10 pr-3 py-2 rounded-lg text-white input-field focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                        </div>
                    </div>
  
                    <button type="submit" class="w-full py-2 px-4 rounded-lg text-white font-semibold btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle between login and signup forms
        const formToggle = document.getElementById('form-toggle');
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');
        const formTitle = document.getElementById('form-title');

        formToggle.addEventListener('change', function() {
            if (this.checked) {
                loginForm.classList.add('hidden');
                signupForm.classList.remove('hidden');
                formTitle.textContent = 'Sign Up';
            } else {
                loginForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
                formTitle.textContent = 'Login';
            }
        });

        // Toggle password visibility
        function setupPasswordToggle(passwordId, toggleId) {
            const passwordInput = document.getElementById(passwordId);
            const toggleButton = document.getElementById(toggleId);
            
            toggleButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleButton.classList.remove('fa-eye-slash');
                    toggleButton.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    toggleButton.classList.remove('fa-eye');
                    toggleButton.classList.add('fa-eye-slash');
                }
            });
        }

        setupPasswordToggle('login-password', 'toggle-login-password');
        setupPasswordToggle('signup-password', 'toggle-signup-password');

        // Form submission
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login functionality would be implemented here');
            // You would typically send a request to your backend here
        });

        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Signup functionality would be implemented here');
            // You would typically send a request to your backend here
        });
    </script>
</body>
</html>