<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Aturin</title>
    

</head>

<body>
    
    @yield('content')
    <script>
    const toggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const main = document.querySelector('.main-content');

    toggle.addEventListener('click', () => {

        sidebar.classList.toggle('expanded');

        if (sidebar.classList.contains('expanded')) {
            main.style.marginLeft = '240px';
        } else {
            main.style.marginLeft = '90px';
        }

    });
</script>

</body>

</html>