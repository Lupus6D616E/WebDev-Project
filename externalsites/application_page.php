<?php

include '../includes/db_connect.php';
session_start();

if(isset($_POST['jobid'])) {
    $jobid = $_POST['jobid'];
} else {
    echo "<script>alert('No job ID provided.');</script>";
    header("Location: jobs.php");
    exit();
}

$sql = "SELECT * FROM jobs WHERE jobid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jobid); 
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600;800&display=swap" rel="stylesheet">
    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        }

        :root {
            --top-bar-height: 68px;
            --dark-green:#008F05;
            --light-green:#00c81b;
            --very-light-green:#0af312;
            --bg-color:#F8F8F8;
            --dark-color:#333;
            --white-color:white;
            --other-white: #E5F5E5;
        }

        body{
            background-color: #F8F8F8;
            font-family: "Poppins", sans-serif;
            display: flex;
            flex-direction: column;
        }

        .top-menu {
            overflow: hidden;
            height: var(--top-bar-height);
            color: black;
            background-color:var(--white-color);
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 100;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .top-menu .las-pinas{
            display: flex;
            align-items: center;
            gap: 15px;
            margin-right: 27px;
        }

        .top-menu .las-pinas i {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-color);
            vertical-align: middle;
        }

        .top-menu .las-pinas h2{
            font-size: 1.5rem;
            font-weight: 650;
            color: var(--dark-color);
            margin-left: 10px;
        }

        .top-menu ul{
            list-style: none;
            display: flex;
            height: 50px;
            align-items: center;
            margin: 0;
        }

        .top-menu ul li {
            width: 100%;
            height: auto;
            text-align: center;
            display: inline-block;
            position: relative;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .top-menu ul li:hover{
            color: var(--dark-green);
            background-color: var(--bg-color);
            border-radius: 5px;
        }

        .top-menu ul li .active {
            color: var(--dark-green);
            background-color: var(--bg-color);
            border-radius: 5px;
        }

        .top-menu ul a:hover {
            color: var(--dark-green);
            background-color: var(--bg-color);
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .top-menu ul li a {
            color: black;
            text-decoration: none;
            font-size: large;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .top-menu .right-side {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: 12px;
        }

        /* Right side buttons */
        .top-menu .right-side button {
            background-color: var(--dark-green);
            color: var(--white-color);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }

        .top-menu .right-side .sign-btn:hover {
            background-color: var(--light-green);
        }
        .top-menu .right-side .login-btn:hover {
            background-color: #c4d2c4;
            color: var(--dark-color);
        }

        .top-menu .right-side .login-btn {
            background-color: var(--other-white);
            color: var(--dark-color);
            border: 1px solid var(--other-white);
            padding: 10px 20px;
        }

        .main-section {
            max-width: 700px;
            margin: 24px auto 0 auto;
            padding: 24px 16px 16px 16px;
            border-radius: 0;
            box-shadow: none;
            box-sizing: border-box;
            width: 100%;
        }

        .main-section img {
            width: 100%;
            height: auto;
            border-radius: 16px;
            margin-bottom: 20px;
        }

        .main-section h1, .main-section h3 {
            color: #222;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 18px;
        }
        .main-section h1 {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 18px;
        }
        .main-section h3 {
            margin-top: 18px;
            margin-bottom: 10px;
        }
        .main-section p {
            font-size: 1.05rem;
            color: var(--dark-color);
            line-height: 1.6;
            margin-bottom: 18px;
        }
        
        .main-section .closingdate{
            color: #008F05;
        }

        /* Apply Button */
        .main-section .apply-btn{
            background-color: var(--dark-green);
            color: var(--white-color);
            margin-top: 30px;
            border: none;
            padding: 15px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }

        .main-section .apply-btn:hover{
             background-color: var(--light-green);
        }

        /* FOOTER */
        footer{
            color: var(--light-green);
            text-align: center;
            justify-content: center;
        }

        footer p {
            font-size: 1rem;
            margin: 10px 0;
            font-weight: 600;
        }
        

        footer .footer-links {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 20px;
            padding: 20px;
            margin-bottom: 50px;
        }

        footer .footer-links ul{
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: row;
            gap: 150px;
        }

        footer .footer-links ul li{
            margin: 0 10px;
            display: inline-block;
            font-size: 1rem;
            margin: 0 10px;
        }

        footer .footer-links a{
            text-decoration: none;
            color: var(--light-green);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        footer .footer-links a:hover {
            color: var(--dark-green);
            text-decoration: underline;
            text-shadow: 0 0 12px rgba(10, 243, 18, 0.28), 0 0 24px rgba(10, 243, 18, 0.18);
        }

        .main-section form {
            width: 85%;
            margin: 0;
            box-sizing: border-box;
            gap: 18px;
        }
        .personal-section, .doc-upload-section {
            margin-bottom: 18px;
        }
        .personal-label, .doc-upload-label {
            display: block;
            font-size: 0.93rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: #222;
        }
        .personal-input, .upload-btn {
            width: 87%;
            min-width: 0;
            max-width: 100%;
            border: none;
            outline: none;
            background: #E5F5E5;
            border-radius: 6px;
            padding: 9px 12px;
            font-size: 0.97rem;
            margin-bottom: 22px;
            font-family: inherit;
            color: #222;
            box-sizing: border-box;
            transition: box-shadow 0.2s;
        }
        .personal-input:focus {
            box-shadow: 0 0 0 2px var(--light-green);
        }
        textarea.personal-input {
            min-height: 70px;
            resize: vertical;
        }
        .upload-btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            background: #E5F5E5;
            color: #4D994F;
            font-weight: 500;
            cursor: pointer;
            padding: 9px 12px;
            margin-bottom: 22px;
            border-radius: 6px;
            font-size: 0.97rem;
            border: none;
            position: relative;
        }
        .upload-btn input[type="file"] {
            display: none;
        }
        .submit-btn {
            width: 100%;
            background: var(--dark-green);
            color: var(--white-color);
            border: none;
            border-radius: 16px;
            padding: 8px 0;
            font-size: 0.95rem;
            font-weight: 500;
            margin-top: 18px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .submit-btn:hover {
            background: var(--light-green);
        }
        label.personal-label {
            margin-bottom: 0;
        }

        .upload-indicator {
            margin-left: 10px;
            font-size: 1rem;
            font-weight: 600;
            vertical-align: middle;
        }

        .remove-file-btn {
            background: none;
            border: none;
            color: #e53935;
            font-size: 1rem;
            margin-left: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        .remove-file-btn:hover {
            color: #b71c1c;
        }

        .back-btn-jobdetails {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            margin: 24px 0 18px 32px;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            color: #008F05;
            background-color: #e5f5e5;
            border: 1.5px solid #008F05;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s, border 0.2s;
        }
        .back-btn-jobdetails:hover {
            background-color: #008F05;
            color: #fff;
            border-color: #008F05;
        }

        /* Remove box shadow and border radius for minimal look */
        /* ...existing code... */
        @media (max-width: 700px) {
            .main-section {
                max-width: 98vw;
                padding: 10px 2vw;
                width: 100vw;
            }
        }
    </style>
</head>
<body>
    <div class="top-menu">
         <div class="las-pinas">
            <i class="bi bi-bank2"></i>
            <h2> Las Piñas Job Portal</h2>
         </div>
         <div class="tabs">
            <ul>
                <li><a href="jportal.php">Home</a></li>
                <li><a href="jobs.php" class="active">Jobs</a></li>
                <li><a href="about.php" >About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
         </div>
        
         <!-- <div class="right-side">
            <button class="sign-btn" id="sign-up">Sign Up</button>
            <button class="login-btn" id="login-btn">Login</button>
         </div> -->

    </div>

    <div class="main-section">
        <a href="job_details.php?job_id=<?=$jobid?>" class="back-btn-jobdetails">
            <svg viewBox="0 0 24 24" width="20" height="20" style="vertical-align:middle;margin-right:6px;">
                <path d="M15 18l-6-6 6-6" stroke="#008F05" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back
        </a>
        <h1>Apply For <?php echo $data['role']; ?></h1>
        <form action="../includes/recruitment.php" enctype="multipart/form-data"  method="post">
            <input type="hidden" value="<?php echo $data['jobid'] ?>" name="jobid">
            <input type="hidden" name="timestamp" value="<?php echo time(); ?>">
            <div class="personal-section">
                <h3>Personal Information</h3>
                <div>
                    <label class="personal-label" for="fn">
                        First Name
                        <input class="personal-input" type="text" name="fn" placeholder="First Name">
                    </label>
                </div>
                <div>
                    <label class="personal-label" for="ln">
                        Last Name
                        <input class="personal-input" type="text" name="ln" placeholder="Last Name">
                    </label>
                </div>

                <div>
                    <label class="personal-label" for="email">Email Address
                        <input class="personal-input" type="email" name="email" placeholder="email@email.com">
                    </label>
                </div>

            </div>
            
            <div class="doc-upload-section">
                <h3>Document Uploads</h3>
                <div>
                    <div class="doc-upload-label">Personal Data Sheet (PDS)</div>
                    <label class="upload-btn">
                        Upload PDS
                        <input type="file" name="pds" class="upload-input" required onchange="showUploadIndicator(this)">
                        <span class="upload-indicator" ></span>
                    </label>
                </div>
                <div>
                    <div class="doc-upload-label">Resume</div>
                    <label class="upload-btn">
                        Upload Resume
                        <input type="file" name="resume" class="upload-input" required onchange="showUploadIndicator(this)">
                        <span class="upload-indicator"></span>
                    </label>
                </div>
                <div>
                    <div class="doc-upload-label">Transcript of Records (TOR)</div>
                    <label class="upload-btn">
                        Upload TOR
                        <input type="file" name="tor" class="upload-input" required onchange="showUploadIndicator(this)">
                        <span class="upload-indicator"></span>
                    </label>
                </div>
                <button type="submit" class="submit-btn">Submit Application</button>
            </div>
        </form>
    </div>

    <script>
        function showUploadIndicator(input) {
            const indicator = input.parentElement.querySelector('.upload-indicator');
            if (input.files && input.files.length > 0) {
                indicator.innerHTML = `✔️ ${input.files[0].name} <button type="button" class="remove-file-btn" onclick="removeSelectedFile(this)">✖</button>`;
                indicator.style.color = "#008F05";
            } else {
                indicator.textContent = "";
            }
        }
        function removeSelectedFile(btn) {
            const indicator = btn.parentElement;
            const input = indicator.parentElement.querySelector('input[type=\"file\"]');
            input.value = ""; // Clear the file input
            indicator.innerHTML = "";
        }

        
    </script>
</body>
</html>