<script>
    /*
        Imports
    */
    import { onMount, beforeUpdate, afterUpdate, createEventDispatcher } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import anime from 'animejs';

    import ImageComponent from './ImageComponent.svelte';
    import ImagePictureComponent from './ImagePictureComponent.svelte';
    import ButtonComponent from './ButtonComponent.svelte';

    /*
       Exports
    */
    export let AttributeId = '';
    export let AttributeClass = '';
    export let AttributeClassExtended = '';
    export let AttributeDataset = {};

    export let Maps = {};
    export let MapsActive = false;
    export let Wineries = {};


    let MapCarousel;  

    let ScreenWidth = 0;

    const MapsModal = (Event) =>
    {

        let Element = (Event.target.tagName === 'IMG' || Event.target.tagName === 'SPAN') ? Event.target.parentElement : Event.target;

        $Store.Modal.Type = 'WineryDetails';
        $Store.Modal.Data.Winery = {
            Region: Element.getAttribute('data-region'),
            List: JSON.parse(Element.getAttribute('data-wineries'))
        };

        $Store.Modal.Active = true;

        Event.stopPropagation();
        Event.preventDefault();

        return false;
    }

    const MapsInit = () =>
    {
        
        let MapsInterval = setInterval( () => { 

            if ($Store.API.Wineries.List.length > 0)
            {
                MapsActive = false;
                Maps = $Store.API.Wineries.Maps;
                Wineries = $Store.API.Wineries.List;
                
                // Map All Wineries in each Region
                Maps.forEach( (Map) =>
                {
                    Map.Active = false; // Reset on each load/re-load

                    Map.Regions.forEach( (Region) => 
                    {
                        Region.Wineries = []; // Reset on each load/re-load

                        Wineries.forEach( (Winery) => 
                        {
                            // Only Show Regions w/ where we have a winery.
                            if (Region.Key === Winery.region.value)
                            {
                                if (!MapsActive) MapsActive = true; // Activate Maps Slider
                                Map.Active = true; // Activate Regional Map
                                Region.Wineries.push(Winery);
                            }
                        });

                    });
                });

                let MapsAnimate = setTimeout( () => 
                {
                    // Apply Map Carousel if we have more than one State of Wineries
                    if (Maps[1])
                    {
                        if (Maps[1].Regions[0].length > 1)
                        {
                            MapCarousel = new Swiper('.map-carousel', {
                                loop: false,
                                slidesPerView: 1,
                                shortSwipes: true,
                                preventClicks: true,
                                preventClicksPropagation: true,
                                preventInteractionOnTransition: true,
                                threshold: 20,
                                preloadImages: false,
                                lazy: true,
                                breakpoints: {
                                    // when window width is >= 320px
                                    0: {
                                        slidesPerView: 0,
                                        spaceBetween: 0
                                    },
                                    // when window width is >= 480px
                                    768: {
                                        slidesPerView: 1,
                                        spaceBetween: 0,
                                    },
                                }
                            });
                        }
                    }
                    
                    document.querySelectorAll('.map-carousel .responsive-img-map').forEach( (Map, Index) => 
                    {
                        anime({
                            targets: Map,
                            dirction: 'forward',
                            easing: 'linear',
                            opacity: [0,1],
                            scale: [0, .85],
                            delay: 500, // increase delay by 100ms for each elements.
                            duration: 250,
                            begin: (Event) =>
                            {
                                Map.style.display = 'inline-block';
                            },
                            complete: (Event) => 
                            {
                                document.querySelectorAll('.map-carousel .map-pin-region').forEach( (Region, Index2) => 
                                {
                                    anime({
                                        targets: Region,
                                        dirction: 'forward',
                                        easing: 'linear',
                                        translateY: ['-8vw', '0vw'],
                                        opacity: [0,1],
                                        delay: ((Index2 + 1) * 100), // increase delay by 100ms for each elements.
                                        duration: 150,
                                        begin: (Event) =>
                                        {
                                            Region.style.display = 'inline-block';
                                        }
                                    });

                                });
                            }
                        });

                    });

                    clearTimeout(MapsAnimate);
                
                }, 0);

                clearInterval(MapsInterval);
            }

        }, 10);
        
    }

    onMount( () => 
    {
        MapsInit();
    });

    afterUpdate( () => 
    {

    });

    beforeUpdate( () => 
    {

    });

</script>


<svelte:head>
    {#if ScreenWidth >= 768}
        <link rel="preload" href="./lib/images/home-regions-california-desktop.png" as="image">
    {:else if ScreenWidth <= 767 }
        <link rel="preload" href="./lib/images/home-regions-california-mobile@2x.png" as="image">
    {/if}
</svelte:head>

<svelte:window bind:outerWidth={ScreenWidth} />

<div id="{AttributeId}" class="{AttributeClass} {AttributeClassExtended}" {...AttributeDataset}>

    <!-- Slider main container -->
    <div class="swiper-container map-carousel">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
        
        {#if MapsActive }
        {#each Maps as Map}

            {#if Map.Active }
            <div class="swiper-slide">
                <ImagePictureComponent
                ImageId={''} 
                ImageClass={'responsive-img-map responsive-img-map-' + Map.Name.toLowerCase()} 
                ImageSrc={'./lib/images/home-regions-' + Map.Name.toLowerCase() + '-desktop.png'} 
                ImageWidth={'414'} 
                ImageHeight={'896'} 
                ImageTitle={ Map.Name + ' Regions Map'} 
                ImageAlt={ Map.Name + ' Regions Map'} 
                ImageSources={ 
                    [
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-regions-california-mobile.png, ./lib/images/home-regions-california-mobile@2x.png 2x', 
                            Media: '(min-width: 0px) and (max-width: 767px)'
                        },
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-regions-california-desktop.png, ./lib/images/home-regions-california-desktop@2x.png 2x', 
                            Media: '(min-width: 768px) and (max-width: 10000000px)'
                        },
                    ]
                } />

                {#each Map.Regions as Region}

                    {#if Region.Wineries.length > 0}

                        <div class={'map-pin-region map-pin-region-' + Region.Key.toLowerCase()}>

                            <ButtonComponent AttributeClass='map-pin-region-button' AttributeDataset={ { 'data-region': Region.Value, 'data-wineries': JSON.stringify(Region.Wineries) } } Callback={MapsModal}>

                                <span class="map-pin-region-count">
                                    {@html Region.Wineries.length}
                                </span>
                                <ImageComponent
                                    ImageClass={['map-pin-region-icon-badge']} 
                                    ImageSrc={'/lib/images/icon-badge.svg'} 
                                    ImageWidth={'400'} ImageHeight={'400'}
                                    ImageTitle={Region.Value + 'Region Winery Count'}
                                    ImageAlt={Region.Value + 'Region Winery Count'} 
                                    ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                                <ImageComponent 
                                    ImageClass={['map-pin']} 
                                    ImageSrc={'/lib/images/icon-map-pin.svg'}
                                    ImageWidth={'400'} ImageHeight={'400'} 
                                    ImageTitle='{Region.Value} Map Pin Graphic' 
                                    ImageAlt='{Region.Value} Map Pin Graphic' 
                                    ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                            </ButtonComponent>
                        </div>

                    {/if}

                {/each}
                
                <div class="map-region-title">
                    {@html Map.Name }
                </div>
                
            </div>
            {/if}

        {/each}
        {/if}
        </div>
    </div>

</div>

<style global lang="scss">
    
    // @import 'swiper/swiper.scss';
    // @import 'swiper/components/navigation/navigation.scss';
    // @import 'swiper/components/pagination/pagination.scss';
    // @import 'swiper/components/scrollbar/scrollbar.scss';

    .map { position: relative;  height: auto; }

    .map-pin-region { position: absolute; }

    .map-carousel .responsive-img-map { opacity: 0; display: none; }
    .map-carousel .map-pin-region { opacity: 0; display: none; }

    .map-pin-region-button { position: relative; }

    @media (min-width: 0px) and (max-width: 767px)
    {  

        .map-region-title { font-size: 4.5vw; margin-top: -12vw; margin-bottom: -1vw; }

        /*
            PINS: BADGE
        */
        
        .map-pin-region img.map-pin { width: 13vw; height: 13vw; }
        .map-pin-region .map-pin-region-count { font-size: 3vw; color: var(--primary-white); position: absolute; z-index: 2; top: -.75vw; right: 1.5vw; width: 5vw; height: 5vw; display: grid; align-items: center; text-align: center }
        .map-pin-region .map-pin-region-icon-badge { z-index: 1; width: 6vw; height: 6vw; position: absolute; top: -1.25vw; right: 1.25vw; display: grid; align-items: center; text-align: center; }
        

        /*
            PINS: CALIFORNIA
        */

        .responsive-img-map-california { margin: -5vw 0 0 4vw; }
        
        .map-pin-region-ca-fn { top: 8vw; left: 18vw; }
        .map-pin-region-ca-nc { top: 26vw; left: 19vw; } 
        .map-pin-region-ca-cc { top: 54vw; left: 37vw; }
        .map-pin-region-ca-sf { top: 28vw; left: 35vw; }
        .map-pin-region-ca-iv { top: 38vw; left: 32vw; }
        .map-pin-region-ca-sn { top: 75vw; left: 64vw; }

        /*
            PINS: WASHINGTON
        */

        /*
            PINS: OREGON
        */
    }

    @media (min-width: 768px) and (max-width: 100000000px)
    { 

        .map-region-title { font-size: 1.75vw; position: absolute; bottom: 7vw; left: 6vw; }

        /*
            PINS: BADGE
        */
        
        .map-pin-region img.map-pin { width: 3.75vw; height: 3.75vw; }
        .map-pin-region .map-pin-region-count { font-size: 1vw; color: var(--primary-white); position: absolute; z-index: 2; top: -2.2vw; right: -1.45vw; width: 5vw; height: 5vw; display: grid; align-items: center; text-align: center }
        .map-pin-region .map-pin-region-icon-badge { position: absolute; z-index: 1; top: -.5vw; right: .25vw; display: grid; width: 1.6vw; height: 1.6vw; align-items: center; text-align: center; }

        /*
            PINS: CALIFORNIA
        */

        .responsive-img-map-california { margin: 2vw 0 0 -1.25vw; }

        .map-pin-region-ca-fn { top: 6vw; left: 6vw; }
        .map-pin-region-ca-nc { top: 16vw; left: 8vw; } 
        .map-pin-region-ca-cc { top: 28vw; left: 15vw; }
        .map-pin-region-ca-sf { top: 17vw; left: 15vw; }
        .map-pin-region-ca-iv { top: 20vw; left: 12vw; }
        .map-pin-region-ca-sn { top: 39vw; left: 27vw; }

         /*
            PINS: WASHINGTOON
        */


         /*
            PINS: OREGON
        */
    }

</style>