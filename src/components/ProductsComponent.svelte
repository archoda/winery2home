<script>
    
    /*
        Imports
    */
    
    import { onMount, beforeUpdate, afterUpdate, createEventDispatcher } from 'svelte';
    import { Store } from '../lib/js/store.js';

    import ProductComponent from '../components/Product.svelte';
    import ImageComponent from '../components/ImageComponent.svelte';
import { time_ranges_to_array } from 'svelte/internal';

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
    
    let ProductCarousel;

    let ProductInitCount = 0;

    let ScreenWidth = 0;

    const ProductCarouselResize = (_Args) =>
    {

        ProductCarousel = new Swiper('.product-carousel', {
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
                    loop: (Products.length > 1),
                    slidesPerView: ProductsPerView[0],
                    spaceBetween: 0
                },
                // when window width is >= 480px
                768: {
                    loop: false,
                    slidesPerView: ProductsPerView[1],
                    spaceBetween: 0,
                },
            }
        });

    }

    const ProductInitCallback = () => 
    {
        ProductInitCount++;
        
        if (ProductInitCount === Products.length)
        {
            let ProductCarouselReady = setInterval(() => 
            {
                if ((ScreenWidth <= 767 && ProductInitCount >= 1) || (ScreenWidth >= 768 && ProductInitCount >= 4))
                {
                    document.querySelector('main').classList.remove('center');
                    ProductCarouselResize(true);
                    window.onresize = ProductCarouselResize;
                }
                else
                {
                    if (ScreenWidth >= 768 && ProductInitCount < 3)
                    {
                        document.querySelector('main').classList.add('center');
                    }
                }
                
                clearInterval(ProductCarouselReady);
            
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

    <!-- Slider main container -->
    <div class="swiper-container product-carousel">
        <!-- <button class="product-carousel-carousel-next hidden">
            <ImageComponent
                ImageClass={['product-carousel-carousel-next']} 
                ImageSrc={'/lib/images/icon-button-next.svg'} 
                ImageWidth={'150'} ImageHeight={'150'}
                ImageTitle={'Next Arrow Graphical Icon'}
                ImageAlt={'Next Arrow Graphical Icon'} 
                ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
        </button>
        <button class="product-carousel-carousel-prev hidden">
            <ImageComponent
                ImageClass={['product-carousel-carousel-previous']} 
                ImageSrc={'/lib/images/icon-button-prev.svg'} 
                ImageWidth={'150'} ImageHeight={'150'}
                ImageTitle={'Previous Arrow Graphical Icon'}
                ImageAlt={'Previous Arrow Graphical Icon'} 
                ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
        </button> -->
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

    <slot />

</div>

<style global lang="scss">
    
    .products { position: relative;  height: auto; }

    @media (min-width: 0px) and (max-width: 767px)
    {  

    }

    @media (min-width: 768px) and (max-width: 100000000px)
    { 
        .main-shop.center .masthead p { text-align: center; }
        .main-shop.center .swiper-wrapper { justify-content: center; }
        .main-shop.center .swiper-slide { width: auto; }
        .main-shop.center .swiper-slide .product-buy { text-align: left; }
    } 

</style>