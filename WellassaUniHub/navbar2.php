<?php
$user_name = $_SESSION['user_name'];
?>
<nav class="navbar navbar-expand-md sticky-top text-nowrap shadow visible navbar-shrink py-3 navbar-light" id="mainNav" style="background: url(&quot;https://cdn.bootstrapstudio.io/placeholders/1400x800.png&quot;), var(--bs-secondary-bg);height: 73.2px;" data-bs-smooth-scroll="true">
    <div class="container">
        <span class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-gear-wide">
                <path d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z">
                </path>
            </svg>
        </span>
        <a class="navbar-brand d-flex align-items-center">
            <span>WellassaUniHUB</span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item dropdown" style="margin: 0px;padding: -1px;">
                    <a class="dropdown-toggle nav-link d-lg-flex align-items-lg-center" aria-expanded="false" data-bs-toggle="dropdown" target="_blank" style="margin: -1px;padding: 9px;font-weight: bold;color: rgba(0,0,0,0.65);">Services</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="./Reservations.php">Reservations</a>
                        <a class="dropdown-item" href="./shop.php">OrderProducts</a>
                        <a class="dropdown-item" href="./freelance.php">Freelance</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#contact">Contact Us</a>
                </li>
            </ul>

            <!-- User Profile Link -->
            <a href="./user_profile.php" class="d-flex align-items-center text-primary text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                </svg>
                <span><?= $user_name; ?></span>
            </a>

            <!-- Cart Link -->
            <a class="btn btn-outline-warning d-inline-flex align-items-center" role="button" href="./add_cart.php" style="margin-right: 10px; margin-top: 2%;">
                <i class="fa fa-shopping-cart" style="font-size: 20px; margin-right: 5px;"></i>Cart
            </a>

            <!-- Logout Button -->
            <a class="btn btn-primary shadow-sm" role="button" href="./php/logout.php" style="border-radius: 50px; padding: 5px 20px; margin-top: 2%;">
                Logout
            </a>
        </div>
    </div>
</nav>