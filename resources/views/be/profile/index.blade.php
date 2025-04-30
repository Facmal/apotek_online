<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Animated gradient background */
        .animated-bg {
            background: linear-gradient(45deg, #4f46e5, #3b82f6, #06b6d4, #10b981);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Floating labels */
        .form-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 12px 12px 12px 40px;
        }

        .form-input+label {
            position: absolute;
            top: 12px;
            left: 40px;
            transition: .2s ease all;
            pointer-events: none;
            color: #9CA3AF;
        }

        .form-input:focus+label,
        .form-input:not(:placeholder-shown)+label {
            transform: translateY(-24px) scale(0.85);
            color: #3b82f6;
        }
    </style>
</head>

<body class="animated-bg flex items-center justify-center min-h-screen p-6">
    <div class="bg-white bg-opacity-90 backdrop-blur-md p-8 rounded-2xl shadow-xl w-full max-w-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Edit Profile</h1>
            <!-- Dark Mode Toggle -->
            <button id="themeToggle" class="p-2 rounded-full hover:bg-gray-200 transition">
                <svg id="iconSun" xmlns="https://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2m-14 0H3m15.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414m0-13.364l1.414 1.414M17.95 17.95l1.414 1.414" />
                </svg>
                <svg id="iconMoon" xmlns="https://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                </svg>
            </button>
        </div>

        <form id="profileForm" class="space-y-5">
            <!-- Avatar Upload and Preview -->
            <div class="flex flex-col items-center">
                <div class="relative">
                    <img id="avatarPreview" src="https://via.placeholder.com/120" alt="Avatar" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg transition-transform hover:scale-105" />
                    <label for="avatarInput" class="absolute bottom-0 right-0 bg-blue-600 p-2 rounded-full cursor-pointer hover:bg-blue-700 transition">
                        <svg xmlns="https://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 4h6v2H7V7zm-3 4h6v2H4v-2z" />
                        </svg>
                        <input type="file" id="avatarInput" accept="image/*" class="hidden" />
                    </label>
                </div>
            </div>

            <!-- Inputs with icons and floating labels -->
            <div class="space-y-4">
                <!-- Username -->
                <div class="relative form-group">
                    <input type="text" id="username" name="username" placeholder=" " required
                        class="form-input border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
                    <label for="username">Username</label>
                </div>
                <!-- Email -->
                <div class="relative form-group">
                    <input type="email" id="email" name="email" placeholder=" " required
                        class="form-input border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
                    <label for="email">Email Address</label>
                </div>
                <!-- Bio -->
                <div class="relative form-group">
                    <textarea id="bio" name="bio" rows="4" placeholder=" "
                        class="form-input border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 resize-none"></textarea>
                    <label for="bio">Tell us about yourself</label>
                </div>
            </div>

            <!-- Save Button -->
            <div class="text-center">
                <button type="submit" id="saveBtn"
                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-transform hover:scale-105">
                    <span>Save Changes</span>
                    <svg xmlns="https://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        // Avatar preview
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        avatarInput.addEventListener('change', () => {
            const file = avatarInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => avatarPreview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        });

        // Form submission (simulate)
        document.getElementById('profileForm').addEventListener('submit', e => {
            e.preventDefault();
            const btn = document.getElementById('saveBtn');
            btn.disabled = true;
            btn.classList.add('opacity-50');
            setTimeout(() => {
                alert('Profile updated successfully!');
                btn.disabled = false;
                btn.classList.remove('opacity-50');
            }, 1000);
        });

        // Dark mode toggle
        const toggle = document.getElementById('themeToggle');
        const htmlEl = document.documentElement;
        const iconSun = document.getElementById('iconSun');
        const iconMoon = document.getElementById('iconMoon');
        toggle.addEventListener('click', () => {
            htmlEl.classList.toggle('dark');
            iconSun.classList.toggle('hidden');
            iconMoon.classList.toggle('hidden');
            document.body.classList.toggle('animated-bg');
        });
    </script>
</body>

</html>