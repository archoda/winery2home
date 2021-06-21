<script>
    /*
        Imports
    */
    import { onMount, beforeUpdate, afterUpdate, createEventDispatcher } from 'svelte';
    import { Store } from '../lib/js/store.js';


    import ProductComponent from '../components/Product.svelte';
    import ImageComponent from './ImageComponent.svelte';

    // Import Swiper
    // import SwiperCore, { Virtual, Navigation, Pagination, Scrollbar, A11y } from 'swiper/core';
    // import { Swiper, SwiperSlide, } from 'swiper/svelte';
    
    // // Install Swiper modules
    // SwiperCore.use([Virtual, Navigation, Pagination, Scrollbar, A11y]);

    // // // Create array with 1000 slides
    // const virtualSlides = Array.from({ length: 1000 }).map((el, index) => `Slide ${index + 1}`);

    /*
       Exports
    */
    export let AttributeId = '';
    export let AttributeClass = '';
    export let AttributeClassExtended = '';
    export let AttributeDataset = {};

    export let Products;
    export let ProductDisplayType = '';
    export let ProductsPerView = [];

    let ProductInitCount = 0;

    let ProductCarousel;
    let ProductCarouselProgress;
    let ProductCarouselTarget;
    let ProductCarouselPrev = null;
    let ProductCarouselNext = null;
    $: ProductCarouselSlide = 1;
    $: ProductCarouselCount = 3;
    let ProductCarouselOptions = null;
    

    let ScreenWidth = 0;

    const ProductCarouselResize = (_Args) =>
    {

        ProductCarousel = new Swiper('.swiper-container', {
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
                    slidesPerView: ProductsPerView[0],
                    spaceBetween: 0
                },
                // when window width is >= 480px
                768: {
                    slidesPerView: ProductsPerView[1],
                    spaceBetween: 0,
                },
            }
        });

        // ProductCarousel.on('click', (Event) => { console.log('Swiper Click'); return false; });

        // console.log('resize called...');
    }

    const ProductInitCallback = () => 
    {
        ProductInitCount++;
        
        if (ProductInitCount === Products.length)
        {
            let ProductCarouselReady = setInterval(() => 
            {
                // if (window.Swiper)
                // {
                    
                    

                    ProductCarouselResize(true);
                    window.onresize = ProductCarouselResize;

                    console.log('Swiper Set OnEvents', ProductCarousel);
                    clearInterval(ProductCarouselReady);
               //}
            }, 10);

        }

    }

    onMount( () => 
    {
        
    });

    afterUpdate( () => 
    {

    });

    beforeUpdate( () => 
    {

    });

</script>

<svelte:window bind:outerWidth={ScreenWidth}/>

<div id="{AttributeId}" class="{AttributeClass} {AttributeClassExtended}" {...AttributeDataset}>

    <!-- <Swiper slidesPerView={ProductCarouselCount}> -->
    <!-- Slider main container -->
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">

        {#each Products as Product}
        
            <div class="swiper-slide">
                <ProductComponent 
                    AttributeClass={AttributeClass} 
                    AttributeClassExtended={AttributeClassExtended} 
                    Winery={Product.winery.name} 
                    Id={Product.winery.id} 
                    WPId={Product.winery.wpid} 
                    Region={Product.winery.region} 
                    Product={Product} 
                    ProductDisplayType={ProductDisplayType} 
                    ProductInitCallback={ProductInitCallback} />
            </div>
        
        {/each}
        
        </div>
    </div>
    <!-- </Swiper> -->

    <!-- <button class="products-carousel-prev">
        <ImageComponent ImageClass={['product-prev']} ImageSrc={$Store.API.Root + '/lib/images/product-carousel-prev.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Left facing arrow'} ImageAlt={'Left facing arrow'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
    </button>
    <button class="products-carousel-next">
        <ImageComponent ImageClass={['product-next']} ImageSrc={$Store.API.Root + '/lib/images/product-carousel-next.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Left facing arrow'} ImageAlt={'Left facing arrow'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
    </button>
    <div class="products-carousel">
    {#if Products !== [] } 
        {#each Products as Product}
            <ProductComponent AttributeClass={AttributeClass + ' products-carousel-cell'} Winery={Product.winery.name} Id={Product.winery.id} WPId={Product.winery.wpid} Region={Product.winery.region} Product={Product} ProductDisplayType={ProductDisplayType} ProductInitCallback={ProductInitCallback} />
        {/each}
    {:else}
        We're sorry. No products are available at this time. Please check back soon.
    {/if}
    </div>
    <slot /> -->
</div>

<style global lang="scss">
    
    // @import 'swiper/swiper.scss';
    // @import 'swiper/components/navigation/navigation.scss';
    // @import 'swiper/components/pagination/pagination.scss';
    // @import 'swiper/components/scrollbar/scrollbar.scss';

    .products { position: relative;  height: auto; }

    @media (min-width: 0px) and (max-width: 767px)
    {  

        /*
            HOME
        */

        /*
            SHOP
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