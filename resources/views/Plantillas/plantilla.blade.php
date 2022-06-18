<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('titulo')</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="tail.select-bootstrap4.css"> --}}
    <!-- Our Custom CSS -->
    {{-- <link rel="stylesheet" href="style4.css"/> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/css/tom-select.css" rel="stylesheet">


    <!-- jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- Popper Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>

<!-- Bootstrap CSS -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>

<!-- Hierarchy Select CSS -->
<link rel="stylesheet" href="css/hierarchy-select.min.css"> --}}




    <style>
        .select2-container{
        width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
        width: 98%;
        }
    {{-- DEMO STYLE --}} @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

    body {
        font-family: Century Gothic;
        background: #ffffff;
        font-size:small ;
    }

    p {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    line-height: 1.7em;
    color: #999;
    }

    a,
    a:hover,
    a:focus {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s;
    }

    .navbar {
    padding: 15px 10px;
    background: rgb(255, 255, 255);
    border: none;
    border-radius: 0;
    margin-bottom: 40px;
    box-shadow: 6px 6px 8px #3a993e;
    }

    .navbar-btn {
    box-shadow: none;
    outline: none !important;
    border: none;
    }

    .line {
    width: 100%;
    height: 1px;
    border-bottom: 1px dashed #ddd;
    margin: 40px 0;
    }

    i,
    span {
    display: inline-block;
    }

    {{-- /* ---------------------------------------------------
            SIDEBAR STYLE
        ----------------------------------------------------- */ --}}
    .wrapper {
    display: flex;
    align-items: stretch;

    }

    #sidebar {
    flex-wrap: wrap;
    min-width: 15%;
    max-width: 15%;
    background: #3a993e;
    color: #fff;
    transition: all 0.3s;
    }


    #sidebar.active {
    min-width: 80px;
    max-width: 80px;
    text-align: center;
    }

    #sidebar.active .sidebar-header h3,
    #sidebar.active .CTAs {
    display: none;
    }

    #sidebar.active .sidebar-header strong {
    display: block;
    }

    #sidebar ul li a {
    text-align: left;
    }

    #sidebar.active ul li a {
    padding: 20px 10px;
    text-align: center;
    font-size: 0.85em;
    }

    #sidebar.active ul li a i {
    margin-right: 0;
    display: block;
    font-size: 1.8em;
    margin-bottom: 5px;
    }

    #sidebar.active ul ul a {
    padding: 10px !important;
    }

    #sidebar.active .dropdown-toggle::after {
    top: auto;
    bottom: 10px;
    right: 50%;
    -webkit-transform: translateX(50%);
    -ms-transform: translateX(50%);
    transform: translateX(50%);
    }

    #sidebar .sidebar-header {
    padding: 20px;
    background: #0b6622;
    }

    #sidebar .sidebar-header strong {
    display: none;
    font-size: 1.8em;
    }

    #sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid #47748b;
    }

    #sidebar ul li a {
    padding: 10px;
    font-size: 1.0em;
    display: block;
    }

    #sidebar ul li a:hover {
    color: #0a0509;
    background: #fff;
    }

    #sidebar ul li a i {
    margin-right: 10px;
    }

    #sidebar ul li.active>a,
    a[aria-expanded="true"] {
    color: #fff;
    background: #3a993e;
    }

    a[data-toggle="collapse"] {
    position: relative;
    }

    .dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    }

    ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: #5fc481;
    }

    ul.CTAs {
    padding: 20px;
    }

    ul.CTAs a {
    text-align: center;
    font-size: 0.9em !important;
    display: block;
    border-radius: 5px;
    margin-bottom: 5px;
    }


    {{-- /* ---------------------------------------------------
            CONTENT STYLE
        ----------------------------------------------------- */ --}}
    .wrapper{
    width: 100%;
    /* max-width: 1000px;*/
    min-height: 100vh;
    transition: all 0.3s;
    }

    #content {
    width: 83%;
    padding: 2%;
    min-height: 40vh;
    transition: all 0.3s;
    }

    .ContenidoBarra2{
    display: none;
    }

    .ContenidoBarra{
    width: 100%;
    height: 5%;
    padding: 5px;
    min-height: 5vh;
    transition: all 0.3s;
    }

    #barras {
    width: 95%;
    height: 45px;
    padding: 5px;
    margin-left: 50px;

    min-height: 5vh;
    transition: all 0.3s;
    }



    {{-- /* ---------------------------------------------------
            MEDIAQUERIES
        ----------------------------------------------------- */ --}}
    @media (max-width: 868px) {
    #sidebar {
    min-width: 80px;
    max-width: 80px;
    text-align: center;

    }

    .dropdown-toggle::after {
    top: auto;
    bottom: 10px;
    right: 50%;
    -webkit-transform: translateX(50%);
    -ms-transform: translateX(50%);
    transform: translateX(50%);
    }

    #sidebar.active {
    margin-left: 0 !important;
    }

    #sidebar .sidebar-header h3,
    #sidebar .CTAs {
    display: none;
    }

    #sidebar .sidebar-header strong {
    display: block;
    }

    #sidebar ul li a {
    padding: 20px 10px;
    }

    #sidebar ul li a span {
    font-size: 0.85em;
    }

    #sidebar ul li a i {
    margin-right: 0;
    display: block;
    }

    #sidebar ul ul a {
    padding: 10px !important;
    }

    #sidebar ul li a i {
    font-size: 1.3em;
    }

    #sidebar {
    margin-left: 0;
    }

    #sidebarCollapse span {
    display: none;
    }

    /* ///////////////////////////////// */

    /* .ContenidoBarra2{
    display: block;
    width: 70%
    }
    .ContenidoBarra{
    display: none;
    } */




    }

    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header" id="nombre">
                <h3>AGRO System</h3>
                <strong>AS</strong>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="true">
                        <i class="glyphicon glyphicon-home"></i>
                        Menú
                    </a>
                </li>
                <li>
                    <a href="/cargos">
                        <i class="glyphicon glyphicon-briefcase"></i>
                        Cargos
                    </a>
                </li>

                <li>
                    <a href="/personals" aria-expanded="true">
                        <i class="glyphicon glyphicon-user"></i>
                        Personal
                    </a>
                </li>

                <li>
                    <a href="/proveedors" aria-expanded="true">
                        <i class="glyphicon glyphicon-log-in"></i>
                        Proveedores
                    </a>
                </li>
                <li>
                    <a href="/clientes" aria-expanded="true">
                        <i class="glyphicon glyphicon-user"></i>
                        Clientes
                    </a>
                </li>
                <li>
                    <a href="/categorias" aria-expanded="true">
                        <i class="glyphicon glyphicon-tags"></i>
                        Categorías
                    </a>
                </li>
                <li>
                    <a href="/productos" aria-expanded="true">
                        <i class="glyphicon glyphicon-qrcode"></i>
                        Productos
                    </a>
                </li>
                <li>
                    <a href="/compras" aria-expanded="true">
                        <i class="glyphicon glyphicon-shopping-cart"></i>
                        Compras
                    </a>
                </li>
                <li>
                    <a href="/ventas" aria-expanded="true">
                        <i class="glyphicon glyphicon-piggy-bank"></i>
                        Ventas
                    </a>
                </li>

                <li>
                    <a href="/inventario" aria-expanded="true">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Inventario
                    </a>
                </li>

                <li>
                    <a href="/Servicio" aria-expanded="true">
                        <i class="glyphicon glyphicon-fire"></i>
                        Servicio Técnico
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">
            <div class="navbar-header">
                <button type="button" id="sidebarCollapse" class="btn btn-success navbar-btn">
                    <i class="glyphicon glyphicon-align-left"></i>
                    <span></span>
                </button>
            </div>
            <nav class="navbar navbar-default" id="barras">

                <div class="container-fluid">

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Page</a></li>
                            <li><a href="#">Page</a></li>
                            <li><a href="#">Page</a></li>
                            <li><a href="#">Page</a></li>
                        </ul>
                    </div>
                </div>

            </nav>

            <section class="ContenidoBarra">
                @yield('barra')
                @yield('contenido')

            </section>

            <section class="ContenidoBarra2">
                @yield('barra2')

                @yield('contenido2')

            </section>


            {{-- <div class="container-fluid">
                <!-- Begin page content -->
                <main class="flex-shrink-0">
                    <div class="container">
                        <br>
                        <div class="resolucion">

                        </div>
                    </div>
                </main>
            </div> --}}
        </div>
    </div>



    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
    {{-- <script src="tail.select-full.min.js"></script> --}}
    <!-- Hierarchy Select Js -->
    {{-- <script src="js/hierarchy-select.min.js"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });

    </script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.3/dist/js/tom-select.complete.min.js"></script>
    @stack('alertas')

</body>

</html>

