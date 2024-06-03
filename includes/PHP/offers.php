<h2 style="margin-left: 2rem;
                font-weight: 400;
                font-size: 4rem;
                margin-left: 10%;">Offres</h2>
<div class="features" id="offers__">
<div class="feature">
        <div class="icon-text">
            <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-info min-w-[2rem] text-blue-600"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><line x1="12" x2="12" y1="16" y2="12"></line><line x1="12" x2="12.01" y1="8" y2="8"></line></svg>
            </div>
            <div class="text">
                <h3>Réseautage en ligne</h3>
                <p>Créez des relations durables entre les anciens lauréats et les stagiaires actuels grâce à notre plateforme en ligne dédiée.</p>
            </div>
        </div>
    </div>
    <div class="feature">
        <div class="icon-text">
            <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users min-w-[2rem] text-blue-600"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <div class="text">
                <h3>Rencontres et échanges</h3>
                <p>Participez à des événements et des ateliers de networking pour encourager les échanges entre les anciens et les nouveaux stagiaires.</p>
            </div>
        </div>
    </div>
    <div class="feature">
        <div class="icon-text">
            <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase-business min-w-[2rem] text-blue-600"><path d="M12 12h.01"></path><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"></path><path d="M22 13a18.15 18.15 0 0 1-20 0"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect></svg>
            </div>
            <div class="text">
                <h3>Mentorat professionnel</h3>
                <p>Développez des relations de mentorat avec nos anciens lauréats pour guider les stagiaires dans leur parcours professionnel.</p>
            </div>
        </div>
    </div>
</div>
<style>
    .features {
        display: flex;
        justify-content: space-between;
        margin: 1.5rem 10%;
        transition: all .5 ease;
    }

    .feature {
        flex: 1;
        margin: 2rem;
        display: flex;
        align-items: top;
    }

    .feature .icon-text {
        display: flex;
        flex-direction: row;
        align-items: top;
    }

    .feature .icon-text .icon {
        margin-right: 1rem;
    }

    .feature .icon-text .icon img {
        width: 50px; 
        height: auto;
    }

    .feature svg {
        color: #00529B;
    }

    .feature .text {
        display: flex;
        flex-direction: column;
    }

    .feature h3 {
        color: #2c3e50;
        margin: 0;
    }

    .feature p {
        margin-top: 0.5rem;
        color: #34495e;
    }

    @media (max-width: 800px) {
        .features {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            margin: 1.5rem 10%;
            transition: all .5 ease;
        }

        .feature {
            flex: 1;
            margin: 2rem;
            display: flex;
            align-items: top;
        }

        .feature .icon-text {
            display: flex;
            flex-direction: row;
            align-items: top;
        }

        .feature .icon-text .icon {
            margin-right: 1rem;
        }

        .feature .icon-text .icon img {
            width: 50px; 
            height: auto;
        }

        .feature svg {
            color: #00529B;
        }

        .feature .text {
            display: flex;
            flex-direction: column;
        }

        .feature h3 {
            color: #2c3e50;
            margin: 0;
        }

        .feature p {
            margin-top: 0.5rem;
            color: #34495e;
        }
    }
</style>