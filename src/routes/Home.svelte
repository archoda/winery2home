
<script>

    /*
        Imports
    */
    import { onMount } from 'svelte';
	import { Store } from '../lib/js/store.js';
    import { transition } from '../lib/js/transition.js';
    import anime from 'animejs';

    import Masthead from '../components/Masthead.svelte';
    

    /*
        Exports
    */
    // Used By Svelte-Routing - prevents console log warning
    export let location;

    let SlidesMasthead;
    let SlidesBody;
    let SlidesButtons;

    const SlideToggle = (slide, speed = 5500) =>
    {
        SlidesMasthead.forEach((Slide, i) =>
        {
            SlideAnimation(Slide, speed, slide, i); 
        });

        SlidesBody.forEach((Slide, i) =>
        {
            SlideAnimation(Slide, speed, slide, i); 
        });
    };

    const SlideAnimation = (Slide, speed, slide, i) =>
    {
        if (slide !== i)
        {
            anime({
                targets: Slide,
                opacity: [Slide.style.opacity,0],
                duration: speed,
                direction: 'forward',
                loop: false,
                complete: () => {
                    Slide.style.opacity = 0;
                }
            });
        }
        else
        {
            if (slide === i)
            {
                anime({
                    targets: Slide,
                    opacity: [0,1],
                    duration: speed,
                    direction: 'forward',
                    loop: false
                }); 
            }
        }
    }

    const SlidesInit = () =>
    {
        SlidesMasthead = document.querySelectorAll('.masthead');
        SlidesBody = document.querySelectorAll('.body .slide');
        SlidesButtons = document.querySelectorAll('#slide-controls button');
        
        SlidesButtons.forEach((Button, i) => {

            Button.addEventListener('click', (event) => {

                SlideToggle(i);

            });

        });

        SlideToggle(0, 0);
    }

    onMount(() =>
    {   
        SlidesInit();

        document.body.style.backgroundImage = "url('.lib/images/_fpo_home_slide1.jpg')";
    });

</script>

<svelte:head>
    <title>{ Store.pages.home.title }| { Store.pages.base.title }</title>
	<meta name="description" property="description" content="{ Store.pages.home.description }">
</svelte:head>

<main id="main" class="main-home">

    
    <Masthead class={"slide hidden"} headersmall={"Explore The"} header={"Wineries"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."} />
    <Masthead class={"slide hidden"} headersmall={"Discover Select"} header={"Wines"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."} />
    <Masthead class={"slide hidden"} headersmall={"Join For Special"} header={"Offers"} body={""} />
    
    <section class="body">
        <div class="slide hidden">Slide 1</div>
        <div class="slide hidden">Slide 2</div>
        <div class="slide hidden">Slide 3</div>
        <div id="slide-controls">
            <button>1</button>
            <button>2</button>
            <button>3</button>
        </div>
       <a href="/shop" class="button button-wine" title="Shop The Wine" use:transition>Shop The Wines</a>
    </section>

</main>

<style global lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {  
        #main { text-align: center; padding: 36vw 4vw 0vw; }
    }

    .body { margin-top: 100vw; }
</style>