
<script>

    /*
        Imports
    */
    import { onMount } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import { transition, transitionTriggerMethod } from '../lib/js/transition.js';
    import { CookiesClass } from '../lib/js/cookies.js';
    import { MouseClass } from '../lib/js/mouse.js';
    import { gsap } from "gsap";
    import { Draggable } from "gsap/Draggable";
    import { TimelineMax } from "gsap";

    import W2HLogo from '../components/W2HLogo.svelte';

    /*
        Exports
    */

    onMount(async () => {

        // Create Timeline
        let TL = new TimelineMax();

        // Animate Timeline
        TL.to(document.querySelector(".page"), { opacity: 1, duration: 1, clipPath: 'initial', delay: 1, backgroundColor: '#93064A' } )
            .to('.ring img', { rotation: "1080", ease: "linear.easeNone", repeat: -1 }, "-=1")
            .fromTo('#W2HLogoAgeCheck', { opacity: 0, scale: .75, color: "#FFFFFF" }, { opacity: 1, scale: 1, duration: 1, ease: "easeInOut(0.5, 0.5)" }, "-=.5")
            .fromTo('#W2HLogoAgeCheck', { y: window.outerHeight/6 }, { y: 0, duration: .75, ease: "easeIn(0.5)" }, "-=1.15")
            .fromTo('h1', { opacity: 0 }, { opacity: 1, duration: 1.75, ease: "easeIn(0.5)" }, "-=.15")
            .fromTo('.circle', { opacity: 0, scale: 0 },{ opacity: 1, scale: 1, duration: .5, ease: "bounce(0.5)" }, "-=1.25")
            .fromTo('.ring img', { opacity: 0, scale: 0 }, { opacity: 1, scale: 1, duration: .5, ease: "bounce(0.5)" }, "-=.5")
            .fromTo('.dragBounds h2:first-of-type', { opacity: 0, x: +50 }, { x: 0, opacity: 1, duration: .5, ease: "easeIn(0.5)" }, "-=.5")
            .fromTo('.dragBounds h2:last-of-type', { opacity: 0, x: -50 }, { x: 0, opacity: 1, duration: .5, ease: "easeIn(0.5)" }, "-=.5")
            .fromTo('.drag-to-choose', { opacity: 0, scale: .5 }, { y: +10, delay: .5, opacity: 1, scale: 1, duration: .5, ease: "easeIn(0.5)" }, "-=.5")
            .fromTo('h5, h6', { opacity: 0 }, { y: +10, delay: .5, opacity: 1, duration: .5, ease: "easeIn(0.5)" }, "-=.5");

        // Register Draggable to avoid error
        gsap.registerPlugin(Draggable);

		Draggable.create( document.getElementById('button'), { 
            type: "x", 
            bounds: ".dragBounds",
            onDragStart: (event) =>
            {   
                TL.to(".drag-to-choose", { duration: .15, opacity: 0 } );
                TL.fromTo("#button", { opacity: 1 }, { duration: 1, opacity: .25 });
            },
            onDrag: (event) =>
            { 

            }, 
            onRelease: (event) => 
            { 
                let center = window.outerWidth/2;
                
                let drop = Math.round(event.clientX);

                let dropCB = transitionTriggerMethod;
                
                let dropEvent = new MouseEvent(MouseEvent.CLICK);
                
                let link = null;

                if (drop > center)
                {
                    // Create Cookies Class
                    let Cookies = new CookiesClass();

                    // Set Age-Check Cookie 
                    Cookies.CookieSet('age-check', 'true');

                    link  = document.createElement('a');
                    link.href = "/";
                }

                if (drop < center)
                {
                    link  = document.createElement('a');
                    link.href = "/age-check-denied";

                    // Set Age-Check Cookie 
                    //Cookies.CookieRemove('age-check')
                }

                link.addEventListener(MouseEvent.CLICK, (e) =>
                {
                    dropCB(e, true);

                }, false);

                link.dispatchEvent(dropEvent);
            }
        });

	});

</script>

<svelte:head>
    <title>{ $Store.Pages.AgeCheck.Title } | { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.AgeCheck.Description }">
</svelte:head>

<main id="main" class="main main-age-check">

        <W2HLogo id={"W2HLogoAgeCheck"} classes={"age-check"} fillColorText={"#FFFFFF"} fillColorBottle={"#FFFFFF"} fillColorFlag={"#FFFFFF"} />

        <h1>ARE YOU OF LEGAL<br />DRINKING AGE?</h1>

        <div class="dragBounds">
            <h2>NO</h2>
            <button id="button">
                <span class="ring"><img src="lib/images/age-check-ring.svg" alt="animated dotted ring spinning"/></span>
                <span class="circle"><img src="lib/images/age-check-circle.svg" alt="Solid white circle with two-way arrows"/></span>
            </button>
            <h2>YES</h2>
            <img src="lib/images/drag-line.svg" alt="Graphical dotted drage line">
        </div>
        <p class="drag-to-choose">Drag To Choose</p>
        <h5>To visit our website you must be old enough to<br />purchase and consume alcohol under the laws<br />of your country of residence.</h5>
        <h6>By entering, you agree to our Cookie Policy, <a href="/terms-of-service" title="Terms of Service" use:transition>Privacy Policy</a>,<br />and <a href="/privacy-policy" title="Privacy Policy" use:transition>Privacy Policy</a></h6>
    
</main>

<style lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;
    
    #main { padding: 0 4vw 0 !important; }

    .main-age-check { display: flex; flex-direction: row; justify-content: center; align-items: center; width: 100%; height: 100%; overflow: hidden; text-align: center; padding: 4vw; }

    .main-age-check * { color: white; }

    .main-age-check #W2HLogoAgeCheck { width: 30vw; height: auto; }

    .main-age-check h1 { font-size: 8vw; }

    .main-age-check h2 { font-size: 7vw; display: inline-block; }

    .main-age-check .drag-to-choose { font-size: 3vw; }

    .main-age-check .dragBounds { position: relative; margin: 0 7vw; }

    .main-age-check .dragBounds h2 { position: absolute; z-index: 1001; top: -4vw; }
    .main-age-check .dragBounds h2:first-of-type { left: 0; }
    .main-age-check .dragBounds h2:last-of-type { right: 0; }

    .main-age-check .dragBounds button { position: relative; background-color: transparent; border: 0 solid transparent; }

    .main-age-check .dragBounds button,
    .main-age-check .dragBounds button .ring { width: 13.25vw; height: 13.25vw; }

    .main-age-check .dragBounds button .ring ,
    .main-age-check .dragBounds button .circle { top: 0; left: 0; position: absolute; display: inline-block; }

    .main-age-check .dragBounds button .ring { top: -1.5vw; left: -1.5vw; }
    
    .main-age-check .dragBounds button .circle { width: 12vw; height: 12vw; }
    
    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {
        .main-age-check h1 { font-size: 4vw; }

        .main-age-check h2 { font-size: 2.5vw; }

        .main-age-check .drag-to-choose { font-size: 1.05vw; }

        .main-age-check .dragBounds { position: relative; margin: 0 6vw; }

        .main-age-check .dragBounds h2 { top: -1.75vw; }

        .main-age-check .dragBounds button,
        .main-age-check .dragBounds button .ring  { width: 4vw; height: 4vw; }

        .main-age-check .dragBounds button .ring { top: -.35vw; left: -.45vw; }

        .main-age-check .dragBounds button .circle { width: 2vw; height: 2vw; }

        .main-age-check h5 { font-size: 1.25vw; }

        .main-age-check h6 { font-size: .75vw; }
    }
</style>