<style>
    .container00 {
        margin: 0 auto;
        padding: 0rem;
        width: 48rem;
        margin: 4rem auto;
    }
    .accordion .accordion-item {
    border-bottom: 1px solid #e5e5e5;
    }

    .accordion .accordion-item button[aria-expanded='true'] {
    border-bottom: 1px solid #03b5d2;
    }

    .accordion button {
    position: relative;
    display: block;
    text-align: left;
    width: 100%;
    padding: 1em 0;
    color: #7288a2;
    font-size: 1.15rem;
    font-weight: 400;
    border: none;
    background: none;
    outline: none;
    }

    .accordion button:hover,
    .accordion button:focus {
    cursor: pointer;
    color: #03b5d2;
    }

    .accordion button:hover::after,
    .accordion button:focus::after {
    cursor: pointer;
    color: #03b5d2;
    border: 1px solid #03b5d2;
    }

    .accordion button .accordion-title {
    padding: 1em 1.5em 1em 0;
    }

    .accordion button .icon {
    display: inline-block;
    position: absolute;
    top: 18px;
    right: 0;
    width: 22px;
    height: 22px;
    border: 1px solid;
    border-radius: 22px;
    }

    .accordion button .icon::before {
    display: block;
    position: absolute;
    content: '';
    top: 9px;
    left: 5px;
    width: 10px;
    height: 2px;
    background: currentColor;
    }
    .accordion button .icon::after {
    display: block;
    position: absolute;
    content: '';
    top: 5px;
    left: 9px;
    width: 2px;
    height: 10px;
    background: currentColor;
    }

    .accordion button[aria-expanded='true'] {
    color: #03b5d2;
    }
    .accordion button[aria-expanded='true'] .icon::after {
    width: 0;
    }
    .accordion button[aria-expanded='true'] + .accordion-content {
    opacity: 1;
    max-height: 9em;
    transition: all 200ms linear;
    will-change: opacity, max-height;
    }
    .accordion .accordion-content {
    opacity: 0;
    max-height: 0;
    overflow: hidden;
    transition: opacity 200ms linear, max-height 200ms linear;
    will-change: opacity, max-height;
    }
    .accordion .accordion-content p {
    font-size: 1rem;
    font-weight: 300;
    margin: 2em 0;
    }
</style>
<h2 style="margin-left: 2rem;
            font-weight: 400;
            font-size: 4rem;
            margin-left: 10%;">FAQ</h2>
<div class="container00">
    <div class="accordion">
        <div class="accordion-item">
            <button id="accordion-button-1" aria-expanded="false">
                <span class="accordion-title">Quel est le but de cette plateforme ?</span>
                <span class="icon" aria-hidden="true"></span>
            </button>
            <div class="accordion-content">
                <p>
                    Le but de cette plateforme est de créer des relations durables entre les anciens lauréats et les stagiaires actuels. Elle offre des opportunités de réseautage en ligne, de participation à des événements et ateliers, ainsi que des programmes de mentorat professionnel pour soutenir le développement de carrière des stagiaires.
                </p>
            </div>
        </div>
        <div class="accordion-item">
            <button id="accordion-button-2" aria-expanded="false">
                <span class="accordion-title">Comment puis-je rejoindre la plateforme ?</span>
                <span class="icon" aria-hidden="true"></span>
            </button>
            <div class="accordion-content">
                <p>
                    Pour rejoindre la plateforme, vous devez vous inscrire en créant un compte sur notre site web. Une fois votre compte approuvé, vous aurez accès aux opportunités de réseautage, aux événements et aux programmes de mentorat.
                </p>
            </div>
        </div>
        <div class="accordion-item">
            <button id="accordion-button-3" aria-expanded="false">
                <span class="accordion-title">Quels sont les avantages de participer au programme de mentorat ?</span>
                <span class="icon" aria-hidden="true"></span>
            </button>
            <div class="accordion-content">
                <p>
                    Le programme de mentorat permet aux stagiaires de recevoir des conseils de la part de professionnels expérimentés (nos anciens lauréats), les aidant à naviguer dans leur parcours professionnel, à améliorer leurs compétences et à atteindre leurs objectifs professionnels.
                </p>
            </div>
        </div>
        <div class="accordion-item">
            <button id="accordion-button-4" aria-expanded="false">
                <span class="accordion-title">Comment puis-je participer aux événements de réseautage et aux ateliers ?</span>
                <span class="icon" aria-hidden="true"></span>
            </button>
            <div class="accordion-content">
                <p>
                    Vous pouvez participer aux événements de réseautage et aux ateliers en vous inscrivant via la section événements sur notre site web. Nous mettons régulièrement à jour le calendrier des événements à venir, et vous recevrez des notifications sur les nouvelles opportunités de vous engager avec d'autres membres.
                </p>
            </div>
        </div>
        <div class="accordion-item">
            <button id="accordion-button-5" aria-expanded="false">
                <span class="accordion-title">Qui puis-je contacter pour obtenir de l'aide ou poser des questions supplémentaires ?</span>
                <span class="icon" aria-hidden="true"></span>
            </button>
            <div class="accordion-content">
                <p>
                    Si vous avez des questions supplémentaires ou avez besoin d'aide, vous pouvez contacter notre équipe de support via le formulaire de contact sur le site web ou nous envoyer un email à support@ofppt-edu.com. Nous sommes là pour vous aider avec toute question ou problème que vous pourriez avoir.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const items = document.querySelectorAll('.accordion button');

    function toggleAccordion() {
    const itemToggle = this.getAttribute('aria-expanded');

    for (i = 0; i < items.length; i++) {
        items[i].setAttribute('aria-expanded', 'false');
    }

    if (itemToggle == 'false') {
        this.setAttribute('aria-expanded', 'true');
    }
    }

    items.forEach((item) => item.addEventListener('click', toggleAccordion));
</script>