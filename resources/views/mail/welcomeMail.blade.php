<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .email-wrapper {
            border: 1px solid #eeeeee;
            border-radius: 12px;
            overflow: hidden;
            margin: 20px;
        }

        .top-accent {
            height: 8px;
            background: linear-gradient(90deg, #FF6B6B 0%, #FFD166 50%, #06D6A0 100%);
        }

        .logo-section {
            text-align: center;
            padding: 30px 0 20px;
        }

        .logo {
            width: 180px;
            height: auto;
        }

        .header-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .content {
            padding: 30px 40px;
        }

        .greeting {
            font-size: 28px;
            font-weight: 700;
            color: #222222;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .message {
            font-size: 16px;
            color: #555555;
            margin-bottom: 25px;
        }

        .feature-section {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
        }

        .feature-title {
            font-size: 18px;
            font-weight: 600;
            color: #333333;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .feature-grid {
            display: table;
            width: 100%;
        }

        .feature-item {
            display: table-row;
            margin-bottom: 15px;
        }

        .feature-icon {
            display: table-cell;
            width: 40px;
            padding: 10px 15px 10px 0;
            text-align: center;
            vertical-align: top;
        }

        .feature-icon span {
            display: inline-block;
            width: 30px;
            height: 30px;
            background-color: #06D6A0;
            border-radius: 50%;
            color: white;
            line-height: 30px;
            font-weight: bold;
            font-size: 16px;
        }

        .feature-text {
            display: table-cell;
            vertical-align: top;
            padding-bottom: 15px;
        }

        .feature-name {
            font-weight: 600;
            margin: 0;
            color: #444444;
        }

        .feature-desc {
            margin: 5px 0 0;
            color: #666666;
        }

        .button-container {
            text-align: center;
            margin: 35px 0 25px;
        }

        .button {
            display: inline-block;
            background-color: #FF6B6B;
            color: white;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .divider {
            height: 1px;
            background-color: #eeeeee;
            margin: 30px 0;
        }

        .help-section {
            background-color: #f0f7ff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .help-title {
            font-size: 16px;
            font-weight: 600;
            color: #333333;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .help-text {
            margin: 0;
            font-size: 14px;
            color: #666666;
        }

        .help-link {
            color: #5E72E4;
            text-decoration: none;
            font-weight: 600;
        }

        .footer {
            background-color: #f9f9f9;
            padding: 30px 40px;
            text-align: center;
        }

        .social-links {
            margin-bottom: 20px;
        }

        .social-link {
            display: inline-block;
            margin: 0 8px;
            width: 36px;
            height: 36px;
            background-color: #eeeeee;
            border-radius: 50%;
            text-align: center;
            line-height: 36px;
            color: #666666;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-links {
            margin: 15px 0;
        }

        .footer-link {
            color: #666666;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
        }

        .copyright {
            color: #999999;
            font-size: 12px;
            margin: 20px 0 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="email-wrapper">
        <div class="top-accent"></div>

        <div class="logo-section">
            <img src="https://via.placeholder.com/180x50" alt="Company Logo" class="logo">
        </div>

        <img src="https://via.placeholder.com/600x200" alt="Welcome Banner" class="header-image">

        <div class="content">
            <h1 class="greeting">Welcome aboard, John!</h1>

            <p class="message">We're thrilled to have you join our community. Your account has been successfully created, and you're all set to start exploring everything we have to offer.</p>

            <div class="button-container">
                <a href="#" class="button">Get Started</a>
            </div>

            <div class="feature-section">
                <h2 class="feature-title">What you can do with your account:</h2>

                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <span>1</span>
                        </div>
                        <div class="feature-text">
                            <h3 class="feature-name">Personalize Your Profile</h3>
                            <p class="feature-desc">Add your photo, interests, and preferences to get a tailored experience.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <span>2</span>
                        </div>
                        <div class="feature-text">
                            <h3 class="feature-name">Connect with Others</h3>
                            <p class="feature-desc">Build your network and collaborate with like-minded professionals.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <span>3</span>
                        </div>
                        <div class="feature-text">
                            <h3 class="feature-name">Explore Features</h3>
                            <p class="feature-desc">Discover tools and resources designed to help you achieve your goals.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="help-section">
                <h3 class="help-title">Need assistance?</h3>
                <p class="help-text">Our support team is ready to help with any questions you might have. <a href="#" class="help-link">Contact Support</a></p>
            </div>
        </div>

        <div class="footer">
            <div class="social-links">
                <a href="#" class="social-link">f</a>
                <a href="#" class="social-link">t</a>
                <a href="#" class="social-link">in</a>
                <a href="#" class="social-link">ig</a>
            </div>

            <div class="footer-links">
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Service</a>
                <a href="#" class="footer-link">Unsubscribe</a>
            </div>

            <p class="copyright">© 2025 YourCompany Inc. All rights reserved.<br>123 Business Boulevard, Tech City, TC 12345</p>
        </div>
    </div>
</div>
</body>
</html>
