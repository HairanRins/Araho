const toggleBtn = document.querySelector('.toggle_btn')
const toggleBtnIcon = document.querySelector('.toggle_btn i')
const dropDownMenu = document.querySelector('.dropdown_menu')

toggleBtn.onclick = function() {
    dropDownMenu.classList.toggle('open')
    const isOpen = dropDownMenu.classList.contains('open')
    toggleBtnIcon.classList = isOpen ? 'fas fa-times':'fas fa-bars';
}

document.addEventListener('DOMContentLoaded', function() {
    const dots = document.querySelectorAll('.dot');
    const contents = document.querySelectorAll('.carousel-content');

    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');

            // Retirer la classe active de tous les contenus
            contents.forEach(content => {
                content.classList.remove('active');
            });

            // Ajouter la classe active au contenu ciblé
            document.getElementById(targetId).classList.add('active');

            // Mettre à jour les points actifs
            dots.forEach(d => d.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Optionnel : Ajouter la classe active au premier point au chargement de la page
    dots[0].classList.add('active');
});

document.getElementById('contact-button').addEventListener('click', function() {
    const contactFormContainer = document.getElementById('contact-form-container');
    contactFormContainer.classList.add('show');
    contactFormContainer.classList.remove('hidden');
});

document.getElementById('close-form').addEventListener('click', function() {
    const contactFormContainer = document.getElementById('contact-form-container');
    contactFormContainer.classList.remove('show');
    setTimeout(() => {
        contactFormContainer.classList.add('hidden');
    }, 500); // Attendre que l'animation soit terminée
});

document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('submit_contact_form.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        document.getElementById('contact-form').reset(); // Réinitialiser le formulaire
        const contactFormContainer = document.getElementById('contact-form-container');
        contactFormContainer.classList.remove('show');
        setTimeout(() => {
            contactFormContainer.classList.add('hidden');
        }, 500); // Attendre que l'animation soit terminée
    })
    .catch(error => console.error('Error:', error));
});
