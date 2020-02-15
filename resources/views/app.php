<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dorfobookmanager</title>
    <script src="dist/app.js"></script>
    <link rel="stylesheet" href="dist/app.css" />
</head>
<body>
    <header>
        <h1>DorfoBookManager</h1>
    </header>
    <main  id="main-app" class="mainContainer">
        <nav>
            <ul>
                <li>
                    <router-link to="/book">Book</router-link>
                </li>
            </ul>
        </nav>
        <router-view></router-view>
    </main><!-- mainContainer -->
    <footer></footer>
</body>
</html>