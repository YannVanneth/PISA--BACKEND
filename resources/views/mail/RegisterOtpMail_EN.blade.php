<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification Email</title>
    <style>
        body {
            font-family: "Roboto", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .email-wrapper {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            margin: 20px 0;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        }

        .email-header {
            background: linear-gradient(135deg, #134E5E 0%, #71B280 100%);
            padding: 30px;
            text-align: center;
        }

        .logo {
            margin-bottom: 10px;
        }

        .logo img {
            height: 45px;
        }

        .header-title {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 8px 0 0;
            font-weight: 400;
        }

        .shield-icon {
            background-color: white;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .shield-icon span {
            font-size: 28px;
        }

        .email-body {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #111827;
        }

        .message {
            margin-bottom: 25px;
            color: #4B5563;
            font-size: 16px;
        }

        .otp-container {
            margin: 30px auto;
            text-align: center;
        }

        .otp-box {
            /*background-color: #F9FAFB;*/
            /*border: 1px solid #E5E7EB;*/
            border-radius: 8px;
            padding: 20px 30px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .otp-label {
            font-size: 14px;
            color: #6B7280;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .otp-code {
            font-family: "Roboto", sans-serif;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #111827;
        }

        .expiry-text {
            color: #EF4444;
            font-size: 14px;
            margin-top: 10px;
            font-weight: 500;
        }

        .security-info {
            background-color: #F9FAFB;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid #3B82F6;
        }

        .security-title {
            font-weight: 600;
            color: #111827;
            margin-top: 0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .security-title span {
            margin-right: 8px;
        }

        .security-text {
            font-size: 14px;
            color: #6B7280;
            margin-bottom: 0;
        }

        .cta-button {
            display: block;
            text-align: center;
            background-color: #3B82F6;
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 6px;
            font-weight: 600;
            margin: 30px auto;
            width: 200px;
            transition: background-color 0.2s;
        }

        .cta-button:hover {
            background-color: #2563EB;
        }

        .alternative-text {
            text-align: center;
            color: #6B7280;
            font-size: 14px;
            margin: 15px 0;
        }

        .divider {
            height: 1px;
            background-color: #E5E7EB;
            margin: 30px 0;
        }

        .email-footer {
            background-color: #F9FAFB;
            padding: 25px 30px;
            text-align: center;
        }

        .footer-text {
            color: #6B7280;
            font-size: 13px;
            margin: 5px 0;
        }

        .footer-links {
            margin-top: 15px;
        }

        .footer-link {
            color: #6B7280;
            text-decoration: none;
            font-size: 13px;
            margin: 0 8px;
        }

        .footer-link:hover {
            text-decoration: underline;
            color: #3B82F6;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="email-wrapper">
        <div class="email-header">
            <div class="logo">
                <img src="https://lh3.googleusercontent.com/fife/ALs6j_GrDHPa7t90XqpbGhTMYKLUp7Uk2Bwuxt0NBF29nsuOMGOnA3__IzJ9Lm0htrE7F8s1WZquOkEIENAO7lsqyPkTUdh8QUp8AXHPR82_br3LaBCuDwHGAu5wujZ01K3fKVbduTC8bbtaLXOf2V9wy_JiRpSTHy3TMQxm5e_52-e4Z07IakXLBiDzJIAP_9iDkXylJ7iFxt4tR9M9j-d_WAAXsW13W3x4K2fL6ccO0Rn-e-ERYmuKWnCT-68C3YPHe0FOMXKVxAmCAcwr4ObGJDA_D8bvS0cASZjfwH06uPvT57TmZNfiHnFMAXx9bsLL89zDG_YL4RfMmyxDOMD4YjRcWBiqBjdErd88Q_tXGyNsnBKMgh9FJrEPyxx9KOLn7FCgnajOyUEKu2KOAJNg8oPn8CdQ0qCOzjNW4_7RNmKd94Zge22NNEZ4Dgg8Ks-iWKc0F637cagv947MxUNE2ZozjrIftwh8S4OzAQ48Cev__xDRBAeTp5UoKYWuM4VHNqyRF3z0Qvj-b50gjLnEJpxiNcnG87jyXg0fiHPy1H6e5o613orp3wATSb5OQxowTIFFAklmITr-vW1eMBkUIy64k20hBFfRfjSytq6O0l0DYTur7a2w6zGga6nNXXjhfT3BwIGMx4ommpsBhQqaEBBMr38BXNOS0NslgKosG0Of3kUmW6xTnMUwWfzal5Suxh6zM0lnqY_f_nYJp26Wt06pALyiHw_oJO4bAduk2A8nFjDxWGDDuqvUG4AVD3Wvh03ovY6UIZ3o4PAhsLWEs8-pNUHpFlfPiKuOgiouWuk12SLpDU7OgJeZMc8ufCme_7vLcND28osYqK8979PzvE8E3Pbrv6vsWWjZQJQqLzM9HvLmiFYAJF1AHS9TNmBGDJ-j0-VLEjHDKlGUlA_ZddRuQ-1tGTa1sv-hPy0-tTftVt0xWdrBJWp1TrvWoGRS84XpAA9W3mI1wFtPBToZfdjm1BI8gJEFaVxBIWW-T3ASpFuWSM7lKNcOZwYOAorr_0FZ6ppXO2yQPrshNLHGspV-pOjwjY3ypXW4-LazRWh8RLFOiQKR-2t9Nvy70yo0uuLfrCupYZB-T319TR5k1U3kGgw4u48vTyuWYAzjwOuZRz16n0HgL5JL0eu_YyakLCuZ7NK5vw1S7Z9BhgAYjloMkSuDCG3LzGzGK0BsXuPuHLtRBiHDrMWXUc1OvUg3CDoHw59Yufd_Fdo83S5f05z-s-i9tA2BWDinRAGT8vmZGDRn2AUi-wAM5cauJW6rXHAwPnpJmhMl3r20s4kdDJ4AMIAeK4X5sIU_qN8o_Mrw67-6Q_XOXFUCsfdKiytIOdrG2lRA1rAKXE63smDRx78UtUX9X6rw_ZxZOmKAm4fcItn5uViCAIaJM9n_NnZ6_q7J5P_8qztPcpj7n4P0seNImfS6rQkM-rwhx4nMg5dOLYtQJDiV6KDwNRoeMwmjX9UIxaoR_fJYpD8vh8h0K_V0LZ0vqnCQzUtpaXMQ71yAGT7l95ZbbIj3t7ck0sunaA8p3mZnOB-4HqO9Hy08DKbNeV8L_YhySC5Tq5sVYntK2x4VjSLZzu2MWp1h1_0Kf8euCkbvCC1yI-3J-SIIHFMFjdqJtJp6MRVE2FaFv4RxPB01-AG-dnAvKCuPe-ai7kQ-KVAGHqP0ifZTmZpYAgNrFsKaf5YiEziRhqhwEh0tyn0H0ZIiIF2fz5l9Dg=w906-h793"
                     alt="PISA">
            </div>
            <h1 class="header-title">Verify Your Account</h1>
            <p class="header-subtitle">Security Verification Code</p>
{{--            <div class="shield-icon">--}}
{{--                <span>🔒</span>--}}
{{--            </div>--}}
        </div>

        <div class="email-body">
            <p class="greeting">Dear {{ $username }},</p>

            <p class="message">{{$emailMessage ?? "We've received a request to access your account. To ensure it's really you and protect your account, please use the verification code below."}}</p>

            <div class="otp-container">
                <div class="otp-box">
                    <div class="otp-label">Verification Code</div>
                    <div class="otp-code">{{ $otp_code }}</div>
                    <div class="expiry-text">Expires in {{ $expire_at ?? "10"}} minutes</div>
                </div>
            </div>

            <div class="security-info">
                <h3 class="security-title"><span>ℹ️</span> Security Notice</h3>
                <p class="security-text">If you didn't request this code, please ignore this email or contact our support team immediately as someone may be trying to access your account.</p>
            </div>

{{--            <a href="#" class="cta-button">Verify Now</a>--}}

{{--            <p class="alternative-text">Or enter the code on the verification page</p>--}}

            <div class="divider"></div>

            <p class="message">For security reasons, please don't share this verification code with anyone, including our support team. Our staff will never ask for your verification code.</p>
        </div>

        <div class="email-footer">
            <p class="footer-text">© {{now()->year}} PISA. All rights reserved.</p>
            <p class="footer-text">This is an automated message, please do not reply.</p>

            <div class="footer-links">
                <a href="#" class="footer-link">Help Center</a>
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Service</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
