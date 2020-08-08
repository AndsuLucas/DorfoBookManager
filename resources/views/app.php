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
    <header class="principalHeader">
        <h1 class="logo">DorfoBookManager</h1>
    </header>
    <main id="main-app" class="principalContainer">
        <nav-bar></nav-bar>
        <router-view></router-view>
    </main><!-- mainContainer -->
    <footer></footer>
</body>
</html>
