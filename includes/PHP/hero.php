<div id="hero">
    <div id="hero-content">
        <h1>Copains d'avant - OFPPT</h1>
        <p>Plateforme pour reconnecter les anciens et actuels membres de l'<spn style="font-weight:700">OFPPT</spn>, partager des expériences et élargir votre réseau professionnel.</p>
        <button ><a href="#FAQ__" style="text-decoration:none; color: white;">Savoir plus &nbsp; ></a></button>
    </div>
    <div id="hero-image">
        <img src="images/hero_amg.png" alt="Networking">
    </div>
</div>

<style>
    #hero {
        height: calc(60vh);
        width: calc(100vw - 3px);
        padding-top: 5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(207,232,255,1) 100%);
        
    }

    #hero-content,
    #hero-image {
        height: calc(60vh - 4rem);
        width: 50vw;
    }

    #hero-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 10%;
    }

    #hero-content h1 {
        font-size: 3.5rem;
        font-weight: 700;
        color: #001120;
    }

    #hero-content button { 
        color: white;
        background: rgb(250,151,70);
        background: linear-gradient(0deg, rgba(250,151,70,1) 0%, rgba(230,108,19,1) 100%);
        border: none;
        border-radius: 5px;
        padding: 0.3125rem 0; 
        width: 9rem;
        margin-top: 1rem;
    }

    #hero-content button:hover {
        background: rgb(250,151,70);
        background: linear-gradient(180deg, rgba(250,151,70,1) 0%, rgba(230,108,19,1) 100%);
    }

    #part2 .connect {
            background: none;
            border: 1px solid white;
            color: #00529B;
            padding: 0.3125rem 0; 
            width: 9rem;
            border-radius: 0.3125rem;
            border: 1px solid rgba(128, 128, 128, 0.212);
            transition: background-color 0.3s, color 0.3s;
        }

    #hero-image {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #hero-image img {
        height: 55%;
    }

    @media (max-width: 1190px) {
        #hero-content h1 {
            font-size: 2.5rem;

        }
    }
    @media (max-width: 970px) {
        #hero {
            display: flex;
            flex-direction: column;
            
        }
        #hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: left;
            font-style: justify;
            width: 80vw;
            text-align: justify;
        }
        #hero-content h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #001120;
        }
        #hero-content p {
            font-size: 1rem;
            font-weight: 400;
            color: #001120;
        }
        #hero-image {
            height: 30vh;
        }
        #hero-image img {
            margin-bottom: 3rem;
        }
        #hero-content button { 
        color: white;
        background: rgb(250,151,70);
        background: linear-gradient(0deg, rgba(250,151,70,1) 0%, rgba(230,108,19,1) 100%);
        border: none;
        border-radius: 5px;
        padding: 0.3125rem 0; 
        width: 9rem;
        margin-top: 1rem;
        margin: 1rem 0;
        }
        #hero-content button:hover {
            background: rgb(250,151,70);
            background: linear-gradient(180deg, rgba(250,151,70,1) 0%, rgba(230,108,19,1) 100%);
        }

        #part2 .connect {
                background: none;
                border: 1px solid white;
                color: #00529B;
                padding: 0.3125rem 0; 
                width: 9rem;
                border-radius: 0.3125rem;
                border: 1px solid rgba(128, 128, 128, 0.212);
                transition: background-color 0.3s, color 0.3s;
            }

        #hero-image {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #hero-image img {
            height: 55%;
        }
    }
</style>
