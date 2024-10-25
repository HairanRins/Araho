
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Araho</title>
    <link rel="shortcut icon" href="img/1715279265111.jpg" type="image/x-icon">
    <link rel="stylesheet" href="SCSS/styles.css" type="text/css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.2.1-web/css/all.css">
    <link href="assets/Aos/dist/aos.css" rel="stylesheet">
</head>
<body>
    <div class="acc" id="accueil">
        <header>
            <div class="head">
                <div class="h1">
                    <div class="logo">
                        <img src="img/1715279265111.jpg" alt="logo">
                        <span>Araho</span>
                    </div>
                    <nav>
                        <ul class="nav">
                            <li><a href="#accueil" class="active">Accueil</a></li>
                            <li><a href="#about">A propos</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="inter">
                    <a href="login.php" class="user"><i class="fas fa-user"></i>Se connecter</a>
                    <a href="register.php" id="touch"><span>S'inscrire</span></a>
                    <div class="toggle_btn">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>
            <div class="dropdown_menu">
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#about">A propos</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
            </div>
        </header>
        <main>
            <div class="container">
                <div class="content">
                    <h1>Gérez tâches et objectifs avec <span>efficacité</span> &#127919;.</h1>
                    <p>Notre application vous aide à organiser vos tâches , à définir et suivre vos objectifs personnels, et à utiliser des outils de productivité intégrés pour maximiser votre efficacité, le tout gratuitement. </p>
                    <div id="emailForm">
                        <a href="register.php" class="start-button">Commencez</a>
                    </div>
                </div>
                <div class="illustr">
                    <img src="img/1719853766534.jpg" alt="illustration">
                </div>
            </div>
        </main>
    </div>
    <section class="about" id="about">
        <div class="title">
            <h2 class="animated_title">Bienvenue sur Araho !</h2>
        </div>
        <div class="about_container">
            <div class="about_image" data-aos="fade-right">
                <img src="img/69add1b0-b6a3-4684-86bc-ff3b1763c748-cover.png" alt="About Araho">
            </div>
            <div class="about_content" data-aos="fade-left">
                <div class="carousel">
                    <div class="carousel-content active" id="content-1">
                        <h3>A propos de Nous</h3><br>
                        <p>Araho est une application de gestion des tâches et des objectifs conçue pour maximiser votre efficacité. Créée en 2024 , elle vise à offrir des outils de productivité intégrés pour organiser vos tâches et suivre vos objectifs personnels.</p>
                        <br>
                        <a href="#" id="touch">En savoir plus</a>
                        <br><br>
                    </div>
                    <div class="carousel-content" id="content-2">
                        <h3>Notre Mission</h3><br>
                        <p>Chez Araho, nous croyons que chaque individu a le potentiel de réaliser ses objectifs avec les bons outils. Notre mission est de vous fournir une plateforme intuitive et efficace pour gérer vos tâches quotidiennes, suivre vos progrès et maximiser votre productivité.</p><br>
                    </div>
                    <div class="carousel-content" id="content-3">
                        <h3>Pourquoi Araho ?</h3><br>
                        <p>En tant que développeur indépendant, je mets tout mon cœur et mon expertise dans ce projet pour offrir une expérience utilisateur unique. Chaque fonctionnalité est conçue avec soin pour répondre à vos besoins spécifiques de gestion de tâches et d'objectifs personnels.</p><br>
                        <a href="#" id="touch">Commencez</a>
                    </div>
                    <div class="carousel-nav">
                        <span class="dot" data-target="content-1"></span>
                        <span class="dot" data-target="content-2"></span>
                        <span class="dot" data-target="content-3"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="services" id="services" data-aos="fade-down">
        <div class="title">
            <h2 class="animated_title">Ce que nous Offrons</h2>
        </div>
        <div class="corp">
            <div class="container1">
            <div class="section">
                <div class="icon">&#128736;</div>
                <h2 class="lit">Gestion des Tâches</h2>
                <p class="small-desc">Créez, assignez et suivez vos tâches de manière efficace.</p>
            </div>
            <div class="section">
                <div class="icon">&#128188;</div>
                <h2 class="lit">Gestion de Projets</h2>
                <p class="small-desc">Organisez vos projets, définissez des objectifs et suivez les progrès.</p>
            </div>
            <div class="section">
                <div class="icon">&#128221;</div>
                <h2 class="lit">Outils de Productivité</h2>
                <p class="small-desc">Utilisez des outils de productivité pour optimiser votre temps et vos efforts.</p>
            </div>
            </div>
        </div>
        <div class="outils">
            <div class="princip">
                <div class="titre">
                    <h3>Essayez quelques outils de productivité intégrés Gratuitement !</h3>
                </div>
                <div class="cont">
                    <p class="first">Découvrez comment nos outils de productivité comme un minuteur Pomodoro et un To-Do List peuvent améliorer votre efficacité et votre gestion de temps. En testant, vous pourrez :</p>
                    <div class="cont_f">
                        <p><i class="fas fa-check-circle"></i><span>Gagner du temps</span></p>
                        <p><i class="fas fa-check-circle"></i><span>Améliorer votre efficacité</span></p>
                        <i class="fas fa-check-circle"></i><span>Optimiser vos efforts</span>
                    </div>
                    <a href="tools.php" id="touch" class="sign"><span>Essayez gratuitement !</span></a>
                </div>
            </div>
            <div class="img_illus">
            <img src="img/1719895496329.jpg" alt="">
            </div>
        </div>
    </section>
    <section class="contact" id="contact">
        <div class="title">
            <h2 class="animated_title">Contactez-nous</h2>
        </div>
        <div class="contact_section">
            <div class="contact-info">
                <h3>Prenez Contact</h3>
                <p><i class="fas fa-map-marker-alt"></i> Rue de Productivité, Tana, Madagascar</p>
                <p><i class="fas fa-mobile-alt"></i>+261 34 24 239 94</p>
                <p><i class="fas fa-envelope"></i>contact@araho.mg</p>
                <p class="suiv">Suivez-nous sur les réseaux sociaux :</p>
                <div class="social-media">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="contact-explanation" data-aos="fade-left">
                <h3>Améliorez votre productivité dès aujourd'hui !</h3>
                <p>Notre plateforme offre des outils de gestion de tâches, d'objectifs et bien plus encore pour vous aider à maximiser votre efficacité.</p>
                <p>Contactez-nous pour en savoir plus sur nos services et comment nous pouvons vous aider à atteindre vos objectifs.</p><br>
                <button class="sign" id="contact-button"><span>Contactez-nous</span></button>
            </div>
        </div>
        <div id="contact-form-container" class="contact-form-container hidden">
    <div class="contact-form">
        <span id="close-form">×</span>
        <h2>Formulaire de Contact</h2>
        <form id="contact-form" action="submit_contact_form.php" method="post">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Message :</label>
            <textarea id="message" name="message" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>

        <div class="citation">
            <h4>"Transformez vos ambitions en actions en gérant, en accomplissant et en progressant."</h4>
        </div>
    </section>
    <footer>
        <div class="footer-section app-details">
            <h3>Détails de l'App</h3>
            <p>Notre application vous aide à organiser vos tâches et à atteindre vos objectifs personnels grâce à des outils de productivité intégrés.</p>
        </div>
        <div class="footer-section useful-links">
            <h3>Liens Utiles</h3>
            <ul>
                <li><a href="#acceuil" class="ic"><i class="fas fa-home"></i>Accueil</a></li>
                <li><a href="#about" class="ic"><i class="fas fa-info-circle"></i>A propos</a></li>
                <li><a href="#services"><i class="fas fa-cogs"></i>Services</a></li>
                <li><a href="#contact" class="ic"><i class="fas fa-phone"></i>Contact</a></li>
            </ul>
        </div>
        <div class="footer-section social-media">
            <h3>Médias Sociaux</h3>
            <ul>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </ul>
        </div>
        <div class="footer-section signup">
            <h3>Inscription</h3>
            <div class="signup-link">
                <a href="register.php">S'inscrire</a>
            </div>
        </div>
    </footer>
    <script src="JS/script.js" type="text/javascript"></script>
    <script src="assets/Aos/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>
</html>