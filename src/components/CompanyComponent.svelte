<script>

    /*
        Imports
    */
    import { onMount, createEventDispatcher, tick, afterUpdate, beforeUpdate } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import anime from 'animejs';

    import MastheadComponent from './MastheadComponent.svelte';
    import ImageComponent from './ImageComponent.svelte';
    import ImagePictureComponent from './ImagePictureComponent.svelte';
    import LinkComponent from './LinkComponent.svelte';
    import ButtonCloseComponent from './ButtonCloseComponent.svelte';

    /*
        Exports
    */
    export let Components       = null;
    export let Callback         = null;

    let Wineries                = {};
    let RegionSelected          = [];
    let Region                  = '';
    let State                   = '';
    $: Winery                   = null;

    const WineryGalleryInit = () =>
    {
        let Gallery = document.querySelector(".winery-details-gallery-carousel");
        let GallerySlides = Gallery.querySelectorAll('.swiper-slide');
        let GalleryCarousel = null;

        if (GallerySlides)
        {
            if (GallerySlides.length > 0)
            {
                let GalleryInterval = setInterval( () => {

                    let GalleryNext = document.querySelector(".winery-details-gallery-carousel-next");
                    let GalleryPrev = document.querySelector(".winery-details-gallery-carousel-prev");

                    GalleryNext.classList.remove('hidden');
                    GalleryPrev.classList.remove('hidden');

                    GalleryCarousel = new Swiper(Gallery, {
                        loop: true,
                        slidesPerView: 1,
                        preloadImages: false,
                        lazy: true,
                        navigation: {
                            nextEl: GalleryNext,
                            prevEl: GalleryPrev,
                        },
                        breakpoints: {
                            // when window width is >= 320px
                            0: {
                                shortSwipes: true,
                                threshold: 0,
                            },
                            // when window width is >= 480px
                            768: {
                                shortSwipes: true,
                                preventClicks: true,
                                preventClicksPropagation: true,
                                preventInteractionOnTransition: true,
                                threshold: 20,
                            },
                        }
                    });

                    GalleryNext.addEventListener('click', (Event) => { GalleryCarousel.slideNext(100); }, false);
                    GalleryPrev.addEventListener('click', (Event) => { GalleryCarousel.slidePrev(100); }, false);
                    GalleryCarousel.updateSlides();


                    // Gallery.querySelectorAll('.swiper-slide').forEach( (Item, Index) => {
                    //     if (Index === 0)
                    //     {
                    //         Item.classList.add('swiper-slide-active');
                    //     }

                    //     if (Index === 1)
                    //     {
                    //         Item.classList.add('swiper-slide-next');
                    //     }
                    // });

                    clearInterval(GalleryInterval);

                }, 10);
            }
        }
    }

    const WineryMapInit = () =>
    {
        //let MapLocation             = Winery.explore.map_location.split('/');

        // // Initialize and add the map
        // // The location of Uluru
        // const uluru = { lat: MapLocation[0], lng: MapLocation[1] };
        // // The map, centered at Uluru
        // const map = new google.maps.Map(document.querySelector(".winery-map"),
        // {
        //     zoom: 4,
        //     center: uluru,
        // });
        // // The marker, positioned at Uluru
        // const marker = new google.maps.Marker(
        // {
        //     position: uluru,
        //     map: map,
        // });

    }

    const WineryVideoToggle = () =>
    {
        let WineryVideo = document.querySelector('video');
        let WineryDetailsVideo = document.querySelector('.winery-details-video');
        let WineryVideoPlay = document.querySelector('.winery-details-video-play');

        if (WineryDetailsVideo && WineryVideo && WineryVideoPlay)
        {
            WineryDetailsVideo.addEventListener('click', (Event) => {

                WineryDetailsVideo.classList.toggle('active');

                if (WineryVideo.paused)
                {
                    WineryVideoPlay.style.opacity = 0;
                    WineryVideo.currentTime = 0;
                    WineryVideo.play(); 
                }
                else
                {
                    WineryVideoPlay.style.opacity = 1;
                    WineryVideo.pause();
                }

                Event.stopPropagation();
                Event.preventDefault();
                return false;

            }, false);
        }
    }

    const WineryDetailsToggle = async(_Args) =>
    {
        Winery = _Args.Winery;

        let ModalPanels = document.querySelectorAll('.modal-panel-group');

        ModalPanels.forEach( (Item) => {
            
            if (Item.classList.contains('modal-panel-group-active'))
            {
                anime({
                    targets: Item,
                    opacity: [1, 0],
                    duration: 250,
                    direction: 'forward',
                    easing: 'linear',
                    loop: false,
                    begin: () => {},
                    complete: () => {
                        Item.classList.remove('modal-panel-group-active');
                    }
                });
            }
            else
            {
                anime({
                    targets: Item,
                    opacity: [Item.style.opacity, 1],
                    duration: 250,
                    direction: 'forward',
                    easing: 'linear',
                    loop: false,
                    begin: () => 
                    {
                        Item.classList.add('modal-panel-group-active');
                    },
                    complete: () => 
                    {

                    }
                });
            }
        });

        let ModalInterval = setInterval( () => {

            if (Winery)
            {
                // console.log(Components().ModalTabs)
                Components().ModalTabs.TabsInit({ TransitionSpeed: 0 });

                WineryVideoToggle();
                WineryMapInit();
                WineryGalleryInit();
            }

            clearInterval(ModalInterval);

        }, 100);
    }

    onMount(async () => 
    {
        Wineries                = $Store.Modal.Data.Winery;
        RegionSelected          = Wineries.Region.split(',');
        Region                  = RegionSelected[1];
        State                   = RegionSelected[0];
    });

    beforeUpdate( () => { });
    afterUpdate( () => { });

</script>


<div class="modal-panel modal-centered modal-panel-group modal-panel-group-active winery-detail-list">

    <ButtonCloseComponent Callback={Callback} AttributeId={'modal-button-close'} AttributeClass={'modal-button-close'} AttributeTitle={'Modal Close'} />
    <MastheadComponent Class={'masthead-winery-details'} headersmall={'Wineries Of ' + Region} header={State}>

    <ul>
        {#if State}
        {#each Wineries.List as WineryListing }
            <li class="list-item">
                
                <button on:click={ () => { WineryDetailsToggle({ Winery: WineryListing }); } } class="button list-item-button">
                    <span class="list-item-icon">
                        <ImageComponent ImageClass={['winery-detail-icon-arrow']} ImageSrc={'/lib/images/icon-arrow.svg'} ImageWidth={'24'} ImageHeight={'13'} ImageTitle='Icon Arrow Graphical Icon' ImageAlt='Icon Arrow Graphical Icon' ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                    </span>
                    <span class="list-item-label">{@html WineryListing.name}</span>
                </button>
            
            </li>
        {/each}
        {/if}
    </ul>

    </MastheadComponent>
</div>

<div class="modal-panel modal-panel-group winery-details">
    
    
    <div id="tab-group-1" class="tab-group hidden" role="tablist" aria-label="Winery Details">

        <ButtonCloseComponent Callback={ () => { WineryDetailsToggle({ Winery: null }); } } AttributeId={'modal-button-close'} AttributeClass={'modal-button-close'} AttributeTitle={'Modal Close'} />
        
        {#if Winery}
        <MastheadComponent Class={'center'} headersmall={Winery.name + ' Of ' + Region} header={State}/>
        {/if}
        <ul class="tab-control">
            <li class="tab tab-active">
                <button role="tab">
                    <span class="tab-label" aria-label="Video" title="Video">Video</span>
                    <span class="tab-bar"><span class="tab-bar-active"></span></span>
                </button>
            </li>
            <li class="tab tab-active">
                <button role="tab">
                    <span class="tab-label" aria-label="Map" title="Map">Map</span>
                    <span class="tab-bar"><span class="tab-bar-active"></span></span>
                </button>
            </li>
            <li class="tab tab-active">
                <button role="tab">
                    <span class="tab-label" aria-label="Gallery" title="Gallery">Gallery</span>
                    <span class="tab-bar"><span class="tab-bar-active"></span></span>
                </button>
            </li>
        </ul>

        <div class="tab-panels">
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                {#if Winery}
                <div class="winery-details-video">
                    <button class="winery-details-video-play">
                        <ImageComponent 
                            ImageClass={['map-pin']} 
                            ImageSrc={'/lib/images/icon-play-button.svg'}
                            ImageWidth={'414'} ImageHeight={'896'} 
                            ImageTitle='Video Play Button Icon' 
                            ImageAlt='Video Play Button Icon' 
                            ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                    </button>
                    <video class="" src="{Winery.explore.video.url}" preload="auto" poster="{Winery.explore.video_poster.sizes['Winery 16:9 Image Desktop']}" loop="loop" playsinline="true">Your browser does not support the video tag.</video>
                </div>
                {/if}
            </div>

            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                {#if Winery}
                <div class="winery-details-map">[MAP PLACEHOLDER]</div>
                {/if}
            </div>
            
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                <div class="swiper-container winery-details-gallery-carousel">
                {#if Winery}
                    <button class="winery-details-gallery-carousel-next hidden">
                        <ImageComponent
                            ImageClass={['winery-details-gallery-next']} 
                            ImageSrc={'/lib/images/icon-button-next.svg'} 
                            ImageWidth={'150'} ImageHeight={'150'}
                            ImageTitle={'Image Gallery Next Arrow Graphical Icon'}
                            ImageAlt={'Image Gallery Next Arrow Graphical Icon'} 
                            ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                    </button>
                    <button class="winery-details-gallery-carousel-prev hidden">
                        <ImageComponent
                            ImageClass={['winery-details-gallery-previous']} 
                            ImageSrc={'/lib/images/icon-button-prev.svg'} 
                            ImageWidth={'150'} ImageHeight={'150'}
                            ImageTitle={'Image Gallery Previous Arrow Graphical Icon'}
                            ImageAlt={'Image Gallery Previous Arrow Graphical Icon'} 
                            ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                    </button>
                    <div class="swiper-wrapper">
                        {#each Winery.explore.photo_gallery as Image}
                        <div class="swiper-slide">
                            <ImagePictureComponent 
                                ImageId={Image.id} 
                                ImageClass='winery-details-gallery-photo' 
                                ImageSrc={Image.photo.sizes['Winery 16:9 Image Mobile']} 
                                ImageWidth={Image.photo.sizes['Winery 16:9 Image Mobile-width']} 
                                ImageHeight={Image.photo.sizes['Winery 16:9 Image Mobile-height']} 
                                ImageTitle={Image.photo.title} 
                                ImageAlt={Image.photo.title}
                                ImageSources={ 
                                    [
                                        { 
                                            Lazy: '', 
                                            Srcset: Image.photo.sizes['Winery 16:9 Image Mobile'], 
                                            Media: '(min-width: 0px) and (max-width: 767px)'
                                        },
                                        { 
                                            Lazy: '', 
                                            Srcset: Image.photo.sizes['Winery 16:9 Image Desktop'], 
                                            Media: '(min-width: 768px) and (max-width: 10000000px)'
                                        },
                                    ]
                                }/>
                        </div>
                        {/each}
                    </div>
                {/if}
                </div>
            </div>
        </div>

        <div class="winery-details-content">
            <div>
                {#if Winery}
                {@html Winery.explore.description}
                <LinkComponent AttributeClass={"button button-wine white-text"} AttributeHref={'/shop'} AttributeTitle={'Shop All Wines'}>Shop All Wines</LinkComponent>
                {/if}
            </div>
        </div>
    </div>
    
</div>

<style global lang="scss">

    .modal-panel-group .modal-button-close { display: none; }

    .modal-panel-group-active .modal-button-close { display: inline-block; }

    /* 
        WINERY VIDEO 
    */
    
    .winery-details-video { position: relative; }

    .winery-details-video,
    .winery-details-video video { background-color: var(--primary-tan-dark) }

    .winery-details-video-play { position: absolute; top: 50%; left: 50%; width: 20vw; height: auto; transform: translate(-50%, -50%);}

    .winery-details-gallery-carousel-next,
    .winery-details-gallery-carousel-prev { z-index: 2; position: absolute; top: 50%; transform: translate(0, -50%); }

    @media (min-width: 0px) and (max-width: 767px)
    {  

        /*
            WINERY: DETAIL LIST
        */

        .winery-detail-list .masthead { padding-top: 0; }
        
        .winery-detail-list .masthead .small { font-size: 4.5vw; }
        .winery-detail-list .masthead .large { font-size: 12vw; }

        .winery-detail-list .masthead ul,
        .winery-detail-list .masthead li { list-style: none; margin: 0; padding: 0; }

        .winery-detail-list .masthead ul { margin-top: 8vw; }

        .winery-detail-list .masthead .list-item + .list-item { margin: 1vw 0 0; }

        .winery-detail-list .masthead .list-item-icon { display: inline-block; width: 3vw; }

        .winery-detail-list .masthead .list-item-label { display: inline-block; margin-left: 3vw; transform: translate(0, -1.25vw); }

        .winery-detail-list .masthead .list-item-button { margin: 0; }
    
        /*
            WINERY: DETAILS: TAB GROUP
        */

        .winery-details .masthead { margin-bottom: 82vw; }
        .winery-details .masthead .small { font-size: 4.5vw; }
        .winery-details .masthead .large { font-size: 12vw; }

        .winery-details .tab-group,
        .winery-details .tab-panels { width: 100%; height: 100%; }

        .winery-details .tab-control,
        .winery-details .tab { list-style: none; margin: 0; padding: 0; }

        .winery-details .tab-control { position: absolute; z-index: 5; top: 100vw; left: 12vw; width: 76vw; padding: 5vw 0 0; display: inline-grid; grid-template-columns: 1fr 1fr 1fr; grid-column-gap: 2vw; }

        .winery-details .tab-panels { top: 48vw; height: auto; }

        .winery-details .tab-panel { text-align: center; width: 100%; height: auto; }

        .winery-details .tab { position: relative; border: none; width: 100%; max-width: 68vw; height: 14.5vw; margin: 0 0 8vw; background-color: transparent; }

        .winery-details .tab + .tab { margin-top: 0; }

        .winery-details .tab button { text-align: center; border: none; margin: 0; padding: 0; bottom: 0; left: 0; background: transparent; width: 100%; height: 100%; }

        .winery-details .tab .tab-label { font-family: "Montserrat-Medium", "Arial", "Helvetica", sans-serif; font-size: 3.05vw; height: auto; display: block; margin: 3.5vw 0 3.5vw; background-color: initial; }

        .winery-details .tab .tab-label,
        .winery-details .tab .tab-bar,
        .winery-details .tab .tab-bar-active { width: 100%; }

        .winery-details .tab .tab-bar,
        .winery-details .tab .tab-bar-active { display: block; border-radius: 10px 10px; }

        .winery-details .tab .tab-bar { z-index: 1; position: relative; left: initial; right: initial; bottom: initial; height: 10%; background-color: var(--primary-gray); }

        .winery-details .tab .tab-bar-active { z-index: 2; background-color: var(--primary-wine); }

        /*
            WINERY: DETAILS
        */

        .winery-details .winery-details-video { position: relative; padding-bottom: 56.25%;  /* 16:9 */ height: 0; }

        .winery-details video { display: block; width: 100%; height: auto; }

        .winery-details .winery-details-video-play { width: 26vw; }

        .winery-details .winery-details-gallery-carousel-next,
        .winery-details .winery-details-gallery-carousel-prev { width: 11vw; height: 11vw; }

        .winery-details .winery-details-gallery-carousel-next { right: 1vw; }
        .winery-details .winery-details-gallery-carousel-prev { left: 1vw; }

        .winery-details .winery-details-content { text-align: center; width: 100%; padding: 0 12vw; }

        .winery-details .winery-details-content p { text-align: left; }

    }


    @media (min-width: 768px) and (max-width: 100000000px)
    {  

        /*
            WINERY: DETAIL LIST
        */

        .winery-detail-list .masthead { padding: 0; }
        
        .winery-detail-list .masthead h1,
        .winery-detail-list .masthead h1 span { width: 100%; text-align: center; }

        .winery-detail-list .masthead ul,
        .winery-detail-list .masthead li { list-style: none; width: 100%; margin: 0; padding: 0; }

        .winery-detail-list .masthead ul { margin-top: 4vw; }

        .winery-detail-list .masthead .list-item { text-align: center; }
        
        .winery-detail-list .masthead .list-item + .list-item { margin: 1vw 0 0; }

        .winery-detail-list .masthead .list-item-icon { display: inline-block; width: 1vw; }

        .winery-detail-list .masthead .list-item-label { display: inline-block; margin-left: 1vw; transform: translate(0, -.75vw); }

        .winery-detail-list .masthead .list-item-button { margin: 0; }


        /*
            WINERY: DETAILS: TAB GROUP
        */

        .winery-details .masthead { padding: 7.35vw 0 0 0; }

        .winery-details .masthead h1,
        .winery-details .masthead h1 span { width: 100%; text-align: center; }

        .winery-details .tab-group,
        .winery-details .tab-panels { width: 100%; height: 100%; }

        .winery-details .tab-control,
        .winery-details .tab { list-style: none; margin: 0; padding: 0; }

        .winery-details .tab-control { position: absolute; z-index: 5; top: 44.5vw; left: 26vw; width: 20vw; height: auto; padding: 2.5vw 0 0; display: inline-grid; grid-template-columns: 1fr 1fr 1fr; grid-column-gap: .5vw; }

        .winery-details .tab-panels { top: 18.25vw; left: 12vw; width: 50%; height: 28.075vw; }

        .winery-details .tab-panel { text-align: center; width: 100%; height: auto; }

        .winery-details .tab { position: relative; border: none; width: 100%; height: 2.5vw; background-color: transparent; }

        .winery-details .tab + .tab { margin: 0; }

        .winery-details .tab button { text-align: center; border: none; margin: 0; padding: 0; bottom: 0; left: 0; background: transparent; width: 100%; height: 100%; }

        .winery-details .tab .tab-label { font-family: "Montserrat-Medium", "Arial", "Helvetica", sans-serif; font-size: .75vw; height: auto; display: block; margin: 0 0 .55vw; background-color: initial; }

        .winery-details .tab .tab-label,
        .winery-details .tab .tab-bar,
        .winery-details .tab .tab-bar-active { width: 100%; }

        .winery-details .tab .tab-bar,
        .winery-details .tab .tab-bar-active { display: block; border-radius: 10px 10px; }

        .winery-details .tab .tab-bar { z-index: 1; position: relative; left: initial; right: initial; bottom: initial; height: .25vw; background-color: var(--primary-gray); }

        .winery-details .tab .tab-bar-active { z-index: 2; background-color: var(--primary-wine); }


        /*
            WINERY: DETAILS
        */

        .winery-details .winery-details-video { position: relative; padding-bottom: 56.25%;  /* 16:9 */ height: 0; }

        .winery-details video { display: block; width: 100%; height: auto; }

        .winery-details .winery-details-video-play { width: 8vw; }

        // .winery-details .winery-details-gallery-carousel-next,
        // .winery-details .winery-details-gallery-carousel-prev { width: 11vw; height: 11vw; }

        .winery-details .winery-details-gallery-carousel-next { right: 1vw; }
        .winery-details .winery-details-gallery-carousel-prev  { left: 1vw; }

        .winery-details .winery-details-content { text-align: left; width: 50vw; padding: 0 12vw; position: absolute; right: -2vw; top: 18.15vw; height: 28.35vw; display: grid; align-items: center; }

        .winery-details .winery-details-content p { text-align: left; }
    }

</style>