<script>

    /*
        Imports
    */
    import { onMount, createEventDispatcher } from 'svelte';
    import anime from 'animejs';
    import AnimeJSTime from '../lib/js/animejs-time.js';
    import FetchClass from '../lib/js/fetch.js';

    /*
        Import Comonents
    */
    import W2HLogo from './W2HLogo.svelte';

    let Fetch = FetchClass;
    let FetchData = null;
    export let FetchOptions;
    const FetchDataDispatch = createEventDispatcher();

    export let classColor = null;


    export let radius = null;
    $: radius = (window.outerWidth <= 500) ? 42 : 50; // mobile : desktop

    export const LoaderCircleReInit = () =>
    {
        console.log('call');
    };

    onMount(async () => {

        anime({
            targets: '.body',
            opacity: [0,1],
            scale: {
                value: [0,1],
                easing: 'spring(1, 80, 10, 0)',
                delay: 500
            },
            duration: 10000,
            direction: 'forward',
            loop: false
        });

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
            loop: false
        });

        const loadAnimation = anime({
            targets: '#loader-circle-solid path',
            strokeDashoffset: [anime.setDashoffset, 0],
            duration: 5000,
            direction: 'forward',
            easing: 'linear',
            loop: false,
            complete: () =>
            {
                anime.timeline({
                    direction: 'forward',
                    easing: 'linear',
                    duration: 500,
                    delay: 250,
                    loop: false,
                })
                .add({
                    targets: '#loader-circle',
                    duration: 250,
                    opacity: [1,0],
                })
                .add({
                    targets: '#loader',
                    opacity: [1,0],
                    complete: () =>
                    {

                        // Dispatch Fetch Data
                        FetchDataDispatch('message', { data: FetchData });
                    }
                });
            }
        });

        anime({
            targets: '#loader-circle #loader-circle-dotted',
            rotate: {
                value: 180,
                duration: 5500,
                easing: 'linear'
            },
            direction: 'forward',
            loop: true
        });


        // Create Fetch class
        Fetch = new FetchClass({
            options: FetchOptions
        });
        
        // Set/Get Fetch Data
        FetchData = await Fetch.PromiseAll();
        
        // Hasten the Loader animation for onComplete Callback
        let AnimeJSTimeManager = new AnimeJSTime(loadAnimation, 20);
            AnimeJSTimeManager.TimeStart();
            AnimeJSTimeManager.TimeRamp();

    });



</script>

<div id="loader">
    <div id="loader-circle">
        <div id="loader-circle-container">
            <div id="loader-circle-logo" class="loader-circle-element">
                <W2HLogo fillColorText={"#FFFFFF"} fillColorBottle={"#FFFFFF"} fillColorFlag={"#FFFFFF"} />
            </div>
            <div class="loader-circle-element">
                <svg id="loader-circle-solid" viewBox="0 0 36 36">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{classColor}" stroke-width=".45" />
                </svg>
            </div>
            <div class="loader-circle-element">
                <svg id="loader-circle-dotted" viewBox="0 0 36 36">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{classColor}" stroke-width=".25" />
                </svg>
            </div>
        </div>
    </div>
</div>

<style>

    #loader { z-index: 2000000; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: var(--primary-wine); }

    #loader-circle { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }

    #loader-circle-container { position: relative; }

    #loader-circle,
    #loader-circle * { display:inline-block; margin: 0; border: 0; padding: 0; box-sizing: border-box; }

    #loader-circle,
    #loader-circle #loader-circle-container,
    #loader-circle-container .loader-circle-element { width: 35vw; height: 35vw; }

    #loader-circle-container .loader-circle-element svg,
    #loader-circle-container .loader-circle-element svg path { width: 100%; height: auto; }

    #loader-circle-container #loader-circle-logo { padding: 10vw 9vw 0; }

    #loader-circle-container .loader-circle-element { position: absolute; top: 0; left: 0; }

    #loader-circle-dotted path { stroke-dasharray: 0.015, 1.15; stroke-linecap: round; }
    
</style>