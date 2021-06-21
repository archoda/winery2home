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
    export let MapsActive = {};
    export let Wineries = {};

    let MapInitCount = 0;    

    let ScreenWidth = 0;

    const MapsModal = (Event) =>
    {

        let Element = (Event.target.tagName === 'IMG') ? Event.target.parentElement : Event.target;

        $Store.Modal.Type = 'WineryDetails';
        $Store.Modal.Data.Winery = {
            Region: Element.getAttribute('data-region'),
            List: JSON.parse(Element.getAttribute('data-wineries'))
        };

        $Store.Modal.Active = true;

        Event.stopPropagation();
        Event.preventDefault();
    }

    const MapsInit = () =>
    {
        let MapsNew = [];

        let MapsInterval = setInterval( () => { 

            if ($Store.API.Wineries.List.length > 0)
            {
                
                Maps = $Store.API.Wineries.Maps;
                Wineries = $Store.API.Wineries.List;
                
                // Map All Wineries in each Region
                Maps.forEach( (Map) =>
                {
                    Map.Regions.forEach( (Region) => 
                    {
                        Wineries.forEach( (Winery) => 
                        {
                            if (Region.Key === Winery.region.value)
                            {
                                Map.Active = true;
                                Region.Wineries.push(Winery);
                            }
                        });
                    });
                });

                MapsActive = true;

                let MapsAnimate = setTimeout( () => 
                {
                    document.querySelectorAll('.swiper-slide-active .responsive-img-map').forEach( (Map, Index) => 
                    {
                        anime({
                            targets: Map,
                            dirction: 'forward',
                            easing: 'linear',
                            opacity: [0,1],
                            scale: [.25, .9],
                            delay: 250, // increase delay by 100ms for each elements.
                            duration: 250,
                            begin: (Event) =>
                            {
                                Map.style.display = 'block';
                            },
                            complete: (Event) => 
                            {
                                document.querySelectorAll('.swiper-slide-active .map-pin-region').forEach( (Region, Index2) => 
                                {
                                    anime({
                                        targets: Region,
                                        dirction: 'forward',
                                        easing: 'linear',
                                        opacity: [0,1],
                                        transform: ['translate[-.5vw,0]','translate[0,0]'],
                                        delay: anime.stagger(Index2*1500), // increase delay by 100ms for each elements.
                                        duration: 250,
                                        begin: (Event) =>
                                        {
                                            Region.style.display = 'block';
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

<svelte:window bind:outerWidth={ScreenWidth} />

<div id="{AttributeId}" class="{AttributeClass} {AttributeClassExtended}" {...AttributeDataset}>

    <!-- Slider main container -->
    <div class="swiper-container">
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

                                <span class="map-pin-region-notification">
                                    {@html Region.Wineries.length}
                                </span>
                                <ImageComponent 
                                    ImageClass={['map-pin map-pin-region-' + Region.Key.toLowerCase()]} 
                                    ImageSrc={$Store.API.Root + '/lib/images/icon-map-pin.svg'}
                                    ImageWidth={'400'} ImageHeight={'400'} 
                                    ImageTitle='{Region.Value} Map Pin Graphic' 
                                    ImageAlt='{Region.Value} Map Pin Graphic' 
                                    ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                            </ButtonComponent>
                        </div>

                    {/if}
                    
                {/each}
              
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

    .swiper-slide-active .responsive-img-map { opacity: 0; display: none; }
    .swiper-slide-active .map-pin-region { opacity: 0; display: none; }

    .map-pin-region-button { position: relative; transform: scale(.55); }

    @media (min-width: 0px) and (max-width: 767px)
    {  
        .responsive-img-map-california { transform: translate(3.5vw, -2.6vw) scale(.9); };
        
        /*
            PINS: CALIFORNIA
        */
        .map-pin-region-ca-nc { top: 24vw; left: 15vw; }
        .map-pin-region-ca-cc { top: 52vw; left: 31vw; }
        .map-pin-region-ca-sf { top: 26vw; left: 36vw; }
        .map-pin-region-ca-iv { top: 36vw; left: 32vw; }
        .map-pin-region-ca-sn { top: 75vw; left: 61vw; }
        .map-pin-region-ca-fn { top: 3vw; left: 14vw; }

        /*
            PINS: WASHINGTON
        */

        /*
            PINS: OREGON
        */
    }

    @media (min-width: 768px) and (max-width: 100000000px)
    { 

        /*
            HOME
        */

        /*
            SHOP
        */

    }

</style>