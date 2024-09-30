<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Club Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .section h2 {
            margin: 0 0 10px;
            color: #5cb85c;
        }

        .club {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .club h3 {
            margin: 0;
            color: #333;
        }

        .programs-list {
            margin-top: 10px;
            list-style-type: none;
            padding: 0;
        }

        .programs-list li {
            margin-bottom: 5px;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%; /* Full width for submit button */
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>University Club Page</h1>
    <div class="container">
        <div class="section">
            <h2>Club Recruitment</h2>
            <p>Join one of our exciting clubs! Here are the clubs currently recruiting:</p>

            <!-- Dummy Clubs Data -->
            <div class="club">
                <h3>Coding Club</h3>
                <p>Learn programming and software development.</p>
                <form action="#" method="POST">
                    <input type="submit" value="Join Coding Club">
                </form>
            </div>
            <div class="club">
                <h3>Art Society</h3>
                <p>Explore your creativity through various art forms.</p>
                <form action="#" method="POST">
                    <input type="submit" value="Join Art Society">
                </form>
            </div>
            <div class="club">
                <h3>Debate Team</h3>
                <p>Enhance your public speaking and critical thinking skills.</p>
                <form action="#" method="POST">
                    <input type="submit" value="Join Debate Team">
                </form>
            </div>
            <div class="club">
                <h3>Sports Club</h3>
                <p>Participate in various sports and fitness activities.</p>
                <form action="#" method="POST">
                    <input type="submit" value="Join Sports Club">
                </form>
            </div>
        </div>

        <div class="section">
            <h2>Ongoing Programs</h2>
            <p>Check out the following programs happening across various clubs:</p>
            <ul class="programs-list">
                <li>Coding Workshop - Date: October 15</li>
                <li>Art Exhibition - Date: November 5</li>
                <li>Debate Competition - Date: October 22</li>
                <li>Sports Day - Date: November 10</li>
            </ul>
            <p>New programs can be added regularly. Stay tuned!</p>
        </div>
    </div>
</body>
</html>
