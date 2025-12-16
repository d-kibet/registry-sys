<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#179847">
    <title>Offline - UDA Registry</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #F7C821 0%, #179847 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #F7C821 0%, #179847 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon svg {
            width: 60px;
            height: 60px;
            fill: white;
        }

        h1 {
            color: #179847;
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #F7C821 0%, #179847 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(23, 152, 71, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            padding: 10px 20px;
            background: #f5f5f5;
            border-radius: 25px;
            font-size: 14px;
            color: #666;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #ff4444;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-dot.online {
            background: #44ff44;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>

        <h1>You're Offline</h1>

        <p>
            It looks like you've lost your internet connection.
            Don't worry - some features may still be available.
            Check your connection and try again.
        </p>

        <button class="btn" onclick="tryAgain()">Try Again</button>

        <div class="status">
            <span class="status-dot" id="statusDot"></span>
            <span id="statusText">Offline</span>
        </div>
    </div>

    <script>
        function tryAgain() {
            window.location.reload();
        }

        // Check online status
        function updateOnlineStatus() {
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');

            if (navigator.onLine) {
                statusDot.classList.add('online');
                statusText.textContent = 'Back Online';

                // Auto-reload after 1 second when back online
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                statusDot.classList.remove('online');
                statusText.textContent = 'Offline';
            }
        }

        // Listen for online/offline events
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);

        // Check status on load
        updateOnlineStatus();

        // Keyboard shortcut - press R to retry
        document.addEventListener('keydown', function(e) {
            if (e.key === 'r' || e.key === 'R') {
                tryAgain();
            }
        });
    </script>
</body>
</html>
