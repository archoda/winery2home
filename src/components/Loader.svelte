<script>

    /*
        Imports
    */
    import { onMount, onDestroy, createEventDispatcher } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import anime from 'animejs';
    import AnimeJSTime from '../lib/js/animejs-time.js';
    import LoaderClass from '../lib/js/LoaderClass.js';

    import W2HLogo from './W2HLogo.svelte';


    
    /*  
        Exports
    */

    export let LoaderType;

    export let LoaderOptions;

    export let LoaderClassColor = null;

    let Loader = null;

    let LoaderResults = {
                        Cached: false,
                    };

    const LoaderCompleteDispatch = createEventDispatcher();

    const LoaderComplete = () =>
    {
        // Update Store Cache
        if (LoaderResults.Cache) $Store.API.Cache = Array.from(LoaderResults.Cache);

        // Dispatch Loader Data
        LoaderCompleteDispatch('message', { data: LoaderResults });
    }

    onMount(async () => {
        
        // Clear Any Modal
        $Store.Modal.Class = '',
        $Store.Modal.Type = '',
        $Store.Modal.Active = false,
        $Store.Modal.Data = {};

        let loadAnimation = null;

        // Init With Loader Hidden;
        anime.timeline({
            loop: false,
        }).add({
            targets: '#loader',
            direction: 'forward',
            easing: 'linear',
            opacity: {
                value: [1,0],
                duration: 0,
                delay: 0,
            },
            delay: 0,
            complete: () => 
            {
                // Show the loader
                anime({
                    targets: '#loader',
                    direction: 'forward',
                    easing: 'linear',
                    scale: {
                        value: [0,1], 
                        easing: 'easeOutBounce',
                        duration: 500,
                        delay: 0,
                    },
                    opacity: {
                        value: [0,1],
                        duration: 500,
                        delay: 0,
                    },
                });
                
                // Show the loader circle
                anime({
                    targets: '.loader-circle-element',
                    opacity: [0,1],
                    scale: {
                        value: [0,1],
                        easing: 'spring(1, 80, 10, 0)',
                        delay: 500
                    },
                    duration: 5500,
                    direction: 'forward',
                    delay: 1000,
                    loop: false
                });

                // Spin the dotted loader circle for the duration
                anime({
                    targets: '#loader-circle #loader-circle-dotted',
                    rotate: {
                        value: 180,
                        duration: 10000,
                        easing: 'linear'
                    },
                    direction: 'forward',
                    loop: true
                });

                // Animate the solid loader circle closed for the duration to complete the loader
                loadAnimation = anime({
                    targets: '#loader-circle-solid path',
                    strokeDashoffset: [anime.setDashoffset, 0],
                    duration: 10000,
                    direction: 'forward',
                    easing: 'linear',
                    loop: false,
                    delay: 1000,
                    complete: () =>
                    {
                        LoaderComplete();

                        anime.timeline({
                            direction: 'forward',
                            easing: 'linear',
                            delay: 500,
                            loop: false
                        })
                        .add({
                            targets: '#loader-circle',
                            duration: 250,
                            opacity: [1,0]
                        })
                        .add({
                            targets: '#loader',
                            opacity: [1,0],
                            duration: 500,
                        });
                    }
                });

            },
        });


        // Create Loader class
        Loader = new LoaderClass({
            options: LoaderOptions,
            cache: $Store.API.Cache,
        });
        
        // Set/Get Loader Data
        LoaderResults = await Loader.PromiseAll();
        
        // Hasten the Loader animation for onComplete Callback
        let AnimeJSTimeManager = new AnimeJSTime(loadAnimation, 20);
            AnimeJSTimeManager.TimeStart();
            AnimeJSTimeManager.TimeRamp();
    });

    onDestroy(async () => {
        
    });



</script>

{#if LoaderType == "circle" }
<div id="loader">
    <div id="loader-circle">
        <div id="loader-circle-container">
            <div id="loader-circle-logo" class="loader-circle-element">
                <W2HLogo fillColorText={"#FFFFFF"} fillColorBottle={"#FFFFFF"} fillColorFlag={"#FFFFFF"} />
            </div>
            <div class="loader-circle-element">
                <svg id="loader-circle-solid" viewBox="0 0 36 36">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{LoaderClassColor}" stroke-width=".45" />
                </svg>
            </div>
            <div class="loader-circle-element">
                <svg id="loader-circle-dotted" viewBox="0 0 36 36">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{LoaderClassColor}" stroke-width=".25" />
                </svg>
            </div>
        </div>
    </div>
</div>
{/if}

<style>

    /*
        LOADER
    */

    #loader { z-index: 2000000; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: var(--primary-wine); }

    /*
        LOADER TYPE: CIRCLE
    */

    #loader-circle { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }

    #loader-circle-container { position: relative; }

    #loader-circle,
    #loader-circle * { display:inline-block; margin: 0; border: 0; padding: 0; box-sizing: border-box; }

    #loader-circle-container .loader-circle-element svg,
    #loader-circle-container .loader-circle-element svg path { width: 100%; height: auto; }

    #loader-circle-container .loader-circle-element { position: absolute; top: 0; left: 0; }

    #loader-circle-dotted path { stroke-dasharray: 0.015, 1.15; stroke-linecap: round; }

    @media (min-width: 0px) and (max-width: 767px)
    {  
        #loader-circle,
        #loader-circle #loader-circle-container,
        #loader-circle-container .loader-circle-element { width: 35vw; height: 35vw; }

        #loader-circle-container #loader-circle-logo { padding: 10vw 9vw 0; }
    }

    @media (min-width: 768px) and (max-width: 100000000px)
    {  
        #loader-circle,
        #loader-circle #loader-circle-container,
        #loader-circle-container .loader-circle-element { width: 15vw; height: 15vw; }

        #loader-circle-container #loader-circle-logo { padding: 4.5vw 4vw 0; }
    }
    
</style>