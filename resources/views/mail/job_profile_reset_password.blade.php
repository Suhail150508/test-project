<!DOCTYPE html>
<html>
<head>
	<title>Password Reset</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		body {
			font-family: Arial, sans-serif;
			font-size: 14px;
			line-height: 1.5;
			color: #333333;
			background-color: #f2f2f2;
			margin: 0;
			padding: 0;
		}

		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #ffffff;
			border-radius: 5px;
			box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
		}

		h1 {
			font-size: 24px;
			margin-bottom: 20px;
			text-align: center;
		}

		p {
			margin-bottom: 20px;
			text-align: justify;
		}

		a {
			color: #0072c6;
			text-decoration: none;
		}

		@media only screen and (max-width: 480px) {
			h1 {
				font-size: 22px;
			}
			p {
				font-size: 12px;
			}
			.container {
				padding: 10px;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Password Reset</h1>
		<p>Dear user,</p>
		<p>We have received a request to reset your password for your account. If you did not request this change, please ignore this email.</p>
		<p>To reset your password, please click on the link below:</p>
        <p>
            <a href="https://jobs1.ewubd.edu/reset-password?token={{ $token }}"
                style="display: inline-block; padding: 10px 20px; background-color: #0072c6; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;"
            >
                Reset Password
            </a>
        </p>
		<p>If the link does not work, copy and paste the following URL into your browser:</p>
		<p>https://jobs1.ewubd.edu/reset-password?token={{ $token }}</p>
		<p>This link will expire in 24 hours. If you do not reset your password within this time, you will need to request another password reset.</p>
		<p>Thank you,</p>
		<p>The Example Team</p>
	</div>
</body>
</html>
