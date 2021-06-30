<script>

    /*
        Imports
    */
    import { onMount, tick } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import StoreManagerClass from '../lib/js/StoreManagerClass.js';
    import { transition } from '../lib/js/transition.js';
    import anime from 'animejs';

    import Masthead from '../components/MastheadComponent.svelte';
    import ImageComponent from '../components/ImageComponent.svelte';
    import ImagePictureComponent from '../components/ImagePictureComponent.svelte';
    
    /*
        Exports
    */
    export let LoaderInitCallback;


    let ContentCarousel;

    let ScreenWidth = 0;

    const ContentCarouselInit = (_Args) =>
    {

        let ContentCarouselNext = document.querySelector("button.content-carousel-next");
        let ContentCarouselPrev = document.querySelector("button.content-carousel-prev");

        ContentCarousel = new Swiper('.content-carousel', {
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
                    enabled: true,
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                // when window width is >= 480px
                768: {
                    enabled: false,
                    loop: false,
                    slidesPerView: 3,
                    spaceBetween: 0,
                },
            }
        });

        ContentCarouselNext.addEventListener('click', (Event) => { ContentCarousel.slideNext(100); }, false);
        ContentCarouselPrev.addEventListener('click', (Event) => { ContentCarousel.slidePrev(100); }, false);
    }

    const ContentAnimateIn = (_Args) =>
    {
        let AnimeTarget = document.querySelector('#main');

        anime.timeline({
            loop: false,
        }).add({
            targets: AnimeTarget,
            direction: 'forward',
            easing: 'linear',
            opacity: {
                value: [0,1],
                duration: 0,
                delay: 0,
            },
            delay: 0,
            begin: () => 
            {
                AnimeTarget.classList.remove('hidden');
            },
            complete: () => 
            {

            }
        });
    }

    onMount(async (event) =>
    {   
        LoaderInitCallback({ 
                LoaderActive: true,
                LoaderType:  'circle',
                LoaderClassColor: '#FFFFFF',
                LoaderOptions: $Store.Pages.PrivacyPolicy.Loader,
                LoaderCompleteCallback: (_Data) =>
                {   
                    const StoreManager = new StoreManagerClass($Store);

                    // Set the Wineries Data if not already set...
                    if (_Data.Responses[0].status != 200 || _Data.Responses[0].ok) 
                    {   
                        // Do something...
                        let test = setInterval( () => {
            
                            ContentCarouselInit();
                            ContentAnimateIn();
                            
                            clearInterval(test);
                        
                        }, 10);
                    }
                    else
                    {
                        // Something has gone wrong
                    }

                }
            });

    });

</script>

<svelte:head>
    <title>{ $Store.Pages.HowItWorks.Title } | { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.HowItWorks.Description }">
     <!-- FLICKITY -->
     <script async type="text/javascript" src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
     <link rel="preload stylesheet" as="style" type="text/css" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</svelte:head>

<svelte:window bind:outerWidth={ScreenWidth} />

<main id="main" class="main-how-it-works hidden">

    <div class="main-content">
        
        <Masthead Class={"center"} headersmall={"How It"} header={"Works"} body={""} />

        <div class="swiper-container content-carousel">

            <button class="content-carousel-next">
                <ImageComponent
                    ImageClass={['content-carousel-next']} 
                    ImageSrc={'/lib/images/icon-button-next.svg'} 
                    ImageWidth={'150'} ImageHeight={'150'}
                    ImageTitle={'Next Arrow Graphical Icon'}
                    ImageAlt={'Next Arrow Graphical Icon'} 
                    ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
            </button>

            <button class="content-carousel-prev">
                <ImageComponent
                    ImageClass={['content-carousel-previous']} 
                    ImageSrc={'/lib/images/icon-button-prev.svg'} 
                    ImageWidth={'150'} ImageHeight={'150'}
                    ImageTitle={'Previous Arrow Graphical Icon'}
                    ImageAlt={'Previous Arrow Graphical Icon'} 
                    ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
            </button>

            <div class="swiper-wrapper">
                <!-- ImageSrc={Image.photo.sizes['Winery 16:9 Image Mobile']} 
                ImageWidth={Image.photo.sizes['Winery 16:9 Image Mobile-width']} 
                ImageHeight={Image.photo.sizes['Winery 16:9 Image Mobile-height']} 
                ImageTitle={Image.photo.title} 
                ImageAlt={Image.photo.title} -->

                <div class="swiper-slide">
                    <ImagePictureComponent 
                        ImageId={'how-it-works-step-1-image'} 
                        ImageClass='how-it-works-step-1-photo'
                        ImageSrc={'/lib/images/how-it-works-step-1-mobile.png'} 
                        ImageSources={ 
                            [
                                { 
                                    Lazy: '', 
                                    Srcset: '/lib/images/how-it-works-step-1-mobile.png, /lib/images/how-it-works-step-1-mobile@2x.png 2x', 
                                    Media: '(min-width: 0px) and (max-width: 767px)'
                                },
                                { 
                                    Lazy: '', 
                                    Srcset: '/lib/images/how-it-works-step-1-desktop.png, /lib/images/how-it-works-step-1-desktop@2x.png 2x', 
                                    Media: '(min-width: 768px) and (max-width: 10000000px)'
                                },
                            ]
                    }/>
                    <h1>
                        <span class="step">1</span>
                        <span class="title">Shop</span>
                    </h1>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut.</p>
                </div>

                <div class="swiper-slide">
                    <ImagePictureComponent 
                        ImageId={'how-it-works-step-2-image'} 
                        ImageClass='how-it-works-step-2-photo'
                        ImageSrc={'/lib/images/how-it-works-step-2-mobile.png'} 
                        ImageSources={ 
                            [
                                { 
                                    Lazy: '', 
                                    Srcset: '/lib/images/how-it-works-step-2-mobile.png, /lib/images/how-it-works-step-2-mobile@2x.png 2x', 
                                    Media: '(min-width: 0px) and (max-width: 767px)'
                                },
                                { 
                                    Lazy: '', 
                                    Srcset: '/lib/images/how-it-works-step-2-desktop.png, /lib/images/how-it-works-step-2-desktop@2x.png 2x', 
                                    Media: '(min-width: 768px) and (max-width: 10000000px)'
                                },
                            ]
                    }/>
                    <h1>
                        <span class="step">2</span>
                        <span class="title">Order</span>
                    </h1>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut.</p>
                </div>

                <div class="swiper-slide">
                    <ImagePictureComponent 
                        ImageId={'how-it-works-step-3-image'} 
                        ImageClass='how-it-works-step-3-photo'
                        ImageSrc={'/lib/images/how-it-works-step-3-mobile.png'} 
                        ImageSources={ 
                            [
                                { 
                                    Lazy: '', 
                                    Srcset: '/lib/images/how-it-works-step-3-mobile.png, /lib/images/how-it-works-step-3-mobile@2x.png 2x', 
                                    Media: '(min-width: 0px) and (max-width: 767px)'
                                },
                                { 
                                    Lazy: '', 
                                    Srcset: '/lib/images/how-it-works-step-3-desktop.png, /lib/images/how-it-works-step-3-desktop@2x.png 2x', 
                                    Media: '(min-width: 768px) and (max-width: 10000000px)'
                                },
                            ]
                    }/>
                    <h1>
                        <span class="step">3</span>
                        <span class="title">Enjoy</span>
                    </h1>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut.</p>
                </div>

            </div>

        </div>

    </div>
    
    <div class="main-background">
        <ImagePictureComponent
            ImageId={''} 
            ImageClass='responsive-img-cover' 
            ImageSrc={'./lib/images/shop-background-mobile-slide.jpg'} 
            ImageWidth={'414'} 
            ImageHeight={'896'} 
            ImageTitle={'Image Background'} 
            ImageAlt={'Image Background'} 
            ImageSources={[
                { 
                    Lazy: '', 
                    Srcset: './lib/images/shop-background-mobile-slide.jpg, ./lib/images/shop-background-mobile-slide@2x.jpg 2x', 
                    Media: '(min-width: 0px) and (max-width: 767px)'
                },
                { 
                    Lazy: '', 
                    Srcset: './lib/images/shop-background-desktop-slide.jpg, ./lib/images/shop-background-desktop-slide@2x.jpg 2x', 
                    Media: '(min-width: 768px) and (max-width: 10000000px)'
                },
            ]}
        />

    </div>
    

</main>

<style global lang="scss">

    .main-how-it-works { width: 100%; height: 100% }

    .main-how-it-works .main-content,
    .main-how-it-works .main-background { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }

    .main-how-it-works .main-content { z-index: 2; }
    .main-how-it-works .main-background { z-index: 1; }

    .main-how-it-works button.content-carousel-next,
    .main-how-it-works button.content-carousel-prev { z-index: 3; position: absolute; top: 24vw; width: 9vw; height: 9vw; }
   
    @media (min-width: 0px) and (max-width: 767px)
    { 
        .main-how-it-works .masthead { padding-left: 12vw; padding-right: 12vw; }
        
        .main-how-it-works button.content-carousel-next { right: 1vw; padding: 1vw; }
        .main-how-it-works button.content-carousel-prev { left: 1vw; padding: 1vw; }

        .main-how-it-works .swiper-container,
        .main-how-it-works .swiper-wrapper,
        .main-how-it-works .swiper-slide { width: 100%; }

        .main-how-it-works .swiper-container {margin: 4vw 0 0; }

        .main-how-it-works .swiper-slide { text-align: center; }

        .main-how-it-works .swiper-slide h1 { margin: -9vw 0 4vw; }
        .main-how-it-works .step { font-size: 9.5vw; margin: 0 0 1vw; }
        .main-how-it-works .title { color: var(--primary-black); }

        .main-how-it-works .swiper-slide p { padding-left: 12vw; padding-right: 12vw; }
    }

    @media (min-width: 767px) and (max-width: 100000000px)
    {
        .main-how-it-works .swiper-container { width: 82vw; margin-top: 2vw; }

        .main-how-it-works .swiper-container,
        .main-how-it-works .swiper-wrapper { text-align: center; }

        .main-how-it-works button.content-carousel-next,
        .main-how-it-works button.content-carousel-prev { opacity: 0; display: none; transform: translate(-100000000vw, -100000000vw) }

        .main-how-it-works .swiper-wrapper,
        .main-how-it-works .swiper-wrapper { width: 100%; }

        .main-how-it-works .swiper-slide h1 { margin: -3vw 0 1vw; }
        .main-how-it-works .step { font-size: 3.5vw; margin: 0; }
        .main-how-it-works .title { color: var(--primary-black); margin: .25vw 0 0; }

        .main-how-it-works .swiper-slide p { padding-left: 4vw; padding-right: 4vw; }
    } 
</style>