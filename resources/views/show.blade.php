<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Reset some default styles */
    body, h1, h2, p, ul, li, a {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Basic Styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    /* Profile Container */
    .profile-container {
        background-color: #ffffff;
        width: 100%;
        max-width: 900px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    /* Profile Header Section */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .profile-picture {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-info {
        flex-grow: 1;
    }

    .name {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .job-title {
        font-size: 18px;
        color: #555;
        margin-bottom: 15px;
    }

    .bio {
        font-size: 16px;
        color: #777;
    }

    /* Contact Info Section */
    .contact-info h2, .social-links h2 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }

    .contact-info ul, .social-links ul {
        list-style-type: none;
        margin-top: 10px;
    }

    .contact-info li, .social-links li {
        font-size: 16px;
        color: #555;
        margin-bottom: 8px;
    }

    /* Social Links */
    .social-links a {
        color: #007bff;
        text-decoration: none;
        font-size: 16px;
    }

    .social-links a:hover {
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
        }

        .profile-info {
            margin-top: 20px;
        }

        .name {
            font-size: 28px;
        }

        .job-title {
            font-size: 16px;
        }
    }

</style>
<body>

<!-- Main Container -->
<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-info">
            <h1 class="name"> 
                {{ $user->name ?? 'Not Entered' }} 
            </h1>
            <p class="job-title">
                {{ $info->title ?? 'Not Entered' }}
            </p>
            <p class="bio">
                {{ $info->description ?? 'Not Entered' }}
            </p>
            <p> 
                <button onclick="window.history.back()" style="color:blue; padding:5px; margin-top:10px;">
                    Go Back
                </button> 
            </p>
        </div>
    </div>
</div>


    <!-- Contact Info Section -->
   
</div>

</body>
</html>
