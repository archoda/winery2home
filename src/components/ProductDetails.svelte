<script>
    /*
        Imports
    */
    import { onMount, afterUpdate, createEventDispatcher, tick } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import ImageComponent from './ImageComponent.svelte';
    import ImagePictureComponent from './ImagePictureComponent.svelte';
    import ButtonComponent from './ButtonComponent.svelte';    
    /*
        Exports
    */
    export let ProductDisplayType;
    export let ProductInitCallback;
    export let AttributeId = null;
    export let AttributeClass = '';

    export let Winery = Winery;
    export let WPId = WPId;
    export let Id = Id;
    export let Region = Region;
    export let Product;
    
    
    let Name = Product.name;
    let Sku = Product.sku;
    let Description = Product.description;
    let Varietal = Product.varietal;
    let Rating = Product.rating;
    let Volume = Product.alcohol_volume;
    let Featured = Product.featured;
    let Price = Product.price.split('.');
    let PriceDollars = Price[0];
    let PriceCents = Price[1];
    let TastingNotes = Product.tasting_notes;
    let FoodPairings = Product.food_pairings;
    let RatingsReviews = Product.ratings_reviews;
    let Image = Product.image;
    let ImageSizes = Object.entries(Image.sizes);
    let ImageMobileSrcString = ImageSizes[27][1].split('.io')[1].split('/');
    //let ImageMobileSrcString = ImageSizes[27][1].split(':')[2].split('/'); -- when done using ngrok...
    let ImageMobileSrc = $Store.API.Root + '/' + ImageMobileSrcString.slice(1, ImageMobileSrcString.length).join('/');
    let ImageMobileDimensions = (ImageMobileSrc.split('.')[1].split('-')).pop().split('x');
    let ImageMobileWidth = ImageMobileDimensions[0];
    let ImageMobileHeight = ImageMobileDimensions[1];
    
    $: Qty = 1;
    $: QtyType = 'Bottle';
    $: QtyString = String(Qty) + ' ' + QtyType;
    
    const QtyUpdate = (_Qty) => {
        if (_Qty <= 0 || !Number.isInteger(_Qty)) 
        {
            Qty = 1;
            QtyType = 'Bottle';
        }
        else
        {
            Qty = _Qty;
            QtyType = ((_Qty > 1) ? 'Bottles' : 'Bottle');
        }

        QtyString = Qty + ' ' + QtyType;
    };

    const QtyUpdateInput = (_Event) => {

        QtyUpdate(_Event.target.value.split(' ')[0]);

    };

    $: AttributeDataset = {
        'data-item-custom1-wpid': `${WPId}`, 
        'data-item-custom2-winery': `${Winery}`,
        'data-item-custom3-sku': `${Sku}`, 
        'data-item-name': `${Name}`,
        'data-item-id': `${WPId}-${Id}-${Sku}`, 
        'data-item-price': `${PriceDollars}.${PriceCents}`,
        'data-item-url': `${$Store.API.Root}/wp/wp-json/snipcart/validate/product/${WPId}/${Id}/${Sku}`,
        'data-item-image': `${ImageMobileSrc}`,
        'data-item-quantity': `${Qty}`,
        'data-item-stackable': `always`
    };

    const ProductDetailsClick = (Event) =>
    {
        console.log('Product Details Click Callback Called');
        $Store.Modal.Type = 'ProductDetails';
        $Store.Modal.Data.Product = Product;
        $Store.Modal.Active = true;

        Event.stopPropagation();
        
        Event.preventDefault();
    };

    onMount(() =>
    {
        console.log('Product Panel Loaded', Product.winery.name);
        
        if (ProductInitCallback) {
            ProductInitCallback();
        }
        else
        {
            console.log('No Carousel to Set');
        }
    });

    afterUpdate(() => { 
        console.log('Carousel on After Update for Product Component Called');
    });
</script>

{#if !Product}
    <p>No Product Petails.</p>
{:else}

        {#if $Store.Modal.Type === ''}

        <!-- Product Home Carousel Display Template -->
        <div if:id={AttributeId} class="{AttributeClass}">
            <div class="product-image" on:click={ProductDetailsClick}>
                
                <div class="product-rating-badge">
                    <span class="product-rating-large">{Rating}</span>
                    <span class="product-rating-small">Points</span>
                    <ImageComponent ImageClass={['product-image-badge']} ImageSrc={$Store.API.Root + '/lib/images/product-rating-badge.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Product Rating Badge'} ImageAlt={'Product Rating Badge'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                </div>
                
                <ImageComponent ImageClass={['product-image-details']} ImageSrc={$Store.API.Root + '/lib/images/button-product-details.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle='{Product.name} Details' ImageAlt='{Product.name} Details' ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                
                {#each Array(4) as _, Index}
                <ImagePictureComponent ImageId={Image.id} ImageClass='product-image product-image-{Index}' ImageSrc={ImageMobileSrc} ImageWidth={ImageMobileWidth} ImageHeight={ImageMobileHeight} ImageTitle={Image.title} ImageAlt={Image.alt} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                {/each}
            
            </div>
            
            <div class="product-title">
                {Product.name}
            </div>

            <ButtonComponent AttributeClass={"button button-wine product-button-add-item snipcart-add-item"} {AttributeDataset} on:click={ () => { console.log('add button clicked')}}>Add To Cart</ButtonComponent>

        </div>
        {/if}
        
        
        {#if $Store.Modal.Type === 'ProductDetails'}

        <!-- Product Modal Display Template -->
        <div if:id={AttributeId} class="{AttributeClass}">
            <div id="tab-group-1" class="tab-group hidden" role="tablist" aria-label="Winery Products">

                    <div class="product-title">
                        <div class="product">{Product.name}</div>
                        {#if ProductDisplayType === 'ProductDetails'}
                        <div class="winery">By {Winery}</div>
                        {/if}
                    </div>
                    
                    <ul class="tab-control">
                        <li class="tab tab-active">
                            <button role="tab">
                                <span class="tab-label" aria-label="Buy It" title="Buy It">Buy It</span>
                                <span class="tab-bar-active"></span>
                                <span class="tab-bar"></span>
                            </button>
                        </li>
                        <li class="tab tab-active">
                            <button role="tab">
                                <span class="tab-label" aria-label="Buy It" title="Description">Description</span>
                                <span class="tab-bar-active"></span>
                                <span class="tab-bar"></span>
                            </button>
                        </li>
                        <li class="tab tab-active">
                            <button role="tab">
                                <span class="tab-label" aria-label="Buy It" title="Detail">Detail</span>
                                <span class="tab-bar-active"></span>
                                <span class="tab-bar"></span>
                            </button>
                        </li>
                    </ul>


                    <div class="tab-panels">
                        
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel"><!-- Empty --></div>
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">

                            <div class="product-image">
                                    
                                <div class="product-rating-badge">
                                    <span class="product-rating-large">{Rating}</span>
                                    <span class="product-rating-small">Points</span>
                                    <ImageComponent ImageClass={['product-image-badge']} ImageSrc={$Store.API.Root + '/lib/images/product-rating-badge.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Product Rating Badge'} ImageAlt={'Product Rating Badge'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                                </div>
                                
                                {#each Array(4) as _, Index}
                                <ImagePictureComponent ImageId={Image.id} ImageClass='product-image product-image-{Index}' ImageSrc={ImageMobileSrc} ImageWidth={ImageMobileWidth} ImageHeight={ImageMobileHeight} ImageTitle={Image.title} ImageAlt={Image.alt} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                                {/each}
                            
                            </div>

                        </div>
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel"><!-- Empty --></div>
                    </div>

                    
                    <div class="tab-panels">
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">

                            <div class="product-buy">
                                <div class="product-buy-price"><span class="product-buy-price-dollars">${PriceDollars}</span><span class="product-buy-price-cents">.{PriceCents}</span></div>
                                <div class="product-buy-note">Shipping & Handling Information In Cart<span>*</span></div>
                                <div class="product-buy-qty">
                                    <input class="product-qty-input" bind:value="{QtyString}" on:input={ (Event) => QtyUpdateInput(Event) } disabled />
                                    <button class="product-qty-increment" on:click={() => { return QtyUpdate(Qty+1) } }>+</button>
                                    <button class="product-qty-decrement" on:click={() => { return QtyUpdate(Qty-1); } }>-</button>
                                </div>
                                <ButtonComponent AttributeClass={"button button-wine product-button-add-item snipcart-add-item"} {AttributeDataset} on:click={ () => { console.log('add button clicked')}}>Add To Cart</ButtonComponent>
                            </div>

                        </div>

                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">

                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        
                        </div>
                        
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">

                            ... Details

                        </div>
                    </div>

            </div>
        </div>
        <!-- <ImagePictureComponent ImageId={'modal-background'} ImageClass='modal-background' ImageSrc={$Store.API.Root + '/lib/images/_onionskin-modal-product-details-mobile.png'} ImageWidth={ImageMobileWidth} ImageHeight={ImageMobileHeight} ImageTitle={'Background-Image'} ImageAlt={'Background-Image'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /> -->
        {/if}

{/if}


<style global lang="scss">


    .product-rating-badge { position: absolute; z-index: 3; }
    
    .product-rating-large { font-family: "Montserrat-Medium", "Arial", "Helvetica", sans-serif; color: #FFF; }

    .product-rating-small { font-family: "Montserrat-Light", "Arial", "Helvetica", sans-serif; color: #FFF; }



    .product-image { position: relative; }

    .product-image-1,
    .product-image-2,
    .product-image-3 { position: absolute; top: 0; left: 0; }
    


    @media (min-width: 0px) and (max-width: 767px)
    {  
        
        /*
            PRODUCT CAROUSEL
        */

        .products { margin-top: 8vw; }

        .products .product-carousel-cell { width: 100%; height: auto; margin: 0; overflow: hidden; }

        .products .product-rating-badge { transform: translate(57.75vw, 21.75vw); width: 20vw; height: auto; }
            
        .products .product-rating-large { position: absolute; z-index: 2; font-size: 7.5vw; transform: translate(8.5vw, -3.45vw); }
        .products .product-rating-small { position: absolute; z-index: 2; font-size: 2.75vw; transform: translate(8.25vw, 3.45vw); }
            
        .products .product-rating-badge img { transform: translate(3vw, -31px) scale(0.7); }

        .products .product-image-details { position: absolute; z-index: 1; transform: translate(0vw, 19vw) scale(-0.11);  }
        .products img.product-image { padding: 0 41.5vw; }
        .products img.product-image-badge { padding: 0 0vw; }

        .products .product-image-1 { transform: translate(-14vw, 0) scale(.85); }
        .products .product-image-2 { transform: translate(14vw, 0) scale(.85); }

        .products .product-title { margin: 6vw 0 4vw; font-size: 3.5vw; }
        



        /*
            PRODUCT DETAIL
        */


        .product-details { position: absolute; width: 100%; height: 100%; text-align: center; padding: 0 12vw; }



        .product-details .product-title { display: grid; justify-content: center; align-items: center; }
        .product-details .product { font-size: 6.5vw; display: grid; align-items: flex-end; width: 100%; height: 14vw; margin: 20vw 0 1vw; color: var(--primary-wine); }
        .product-details .winery { width: 100%; }


        /* -- Tab Control Group */

        .product-details .tab-control,
        .product-details .tab { list-style: none; margin: 0; padding: 0; }

        .product-details .tab-control { display: inline-grid; grid-template-columns: 1fr 1fr 1fr; grid-column-gap: 2vw; width: 100%; padding: 5vw 4vw 3vw; }

        .product-details .tab { width: 100%; max-width: 68vw; height: 14vw; margin: 0 0 8vw; }
        .product-details .tab { position: relative; border-radius: 10px 10px; }
        
        .product-details .tab button { text-align: center; border: none; margin: 0; padding: 0; bottom: 0; left: 0; background: transparent; width: 100%; height: 100%; }

        .product-details .tab .tab-label { font-family: "Montserrat-Light", "Arial", "Helvetica", sans-serif; }

        .product-details .tab .tab-label,
        .product-details .tab .tab-bar,
        .product-details .tab .tab-bar-active { width: 100%; }

        .product-details .tab .tab-bar,
        .product-details .tab .tab-bar-active { display: block; position: absolute; left: 0; right: 0; bottom: 0; height: 1.5vw; border-radius: 10px 10px; }

        .product-details .tab .tab-bar { z-index: 1; background-color: var(--primary-gray); }
        .product-details .tab .tab-bar-active { z-index: 2; background-color: var(--primary-wine); }

        /* -- Tab Group, Panels & Panel Group */

        .product-details .tab-group,
        .product-details .tab-panels,
        .product-details .tab-panel { width: 100%; height: 100%; }

        .product-details .tab-panel { text-align: center; }



        /* -- Tab Panel = Buy It */

        .product-details .product-rating-badge { transform: translate(53.75vw, 21.25vw); width: 20vw; height: auto; }
        .product-details .product-rating-large { position: absolute; z-index: 3; font-size: 6.75vw; transform: translate(5.65vw, 4.5vw); }
        .product-details .product-rating-small { position: absolute; z-index: 3; font-size: 2.75vw; transform: translate(5.65vw, 11.25vw); }
        .product-details .product-rating-badge img { transform: scale(0.7); }

        .product-details img.product-image { padding: 0 26.5vw; }

        .product-details img.product-image-0 { opacity: 0; }
        .product-details img.product-image-1 { z-index: 1; transform: translate(-14vw, 0) scale(.85); }
        .product-details img.product-image-2 { z-index: 1; transform: translate(14vw, 0) scale(.85); }
        .product-details img.product-image-3 { z-index: 2; }

        .product-details .product-buy-note { font-size: 3vw; margin-bottom: 4vw; }
        
        .product-details .product-buy { display: grid; grid-auto-columns: 2fr; grid-column-gap: 4vw; margin-top: 4vw; }

        .product-details .product-buy-price,
        .product-details .product-buy-note { grid-column: 1/span 2; }

        .product-details .product-buy-price-dollars { font-size: 10vw; }
        .product-details .product-buy-price-cents { font-size: 6vw; transform: translate(1vw, -3vw); display: inline-block; }
        
        .product-details .product-buy-qty { position: relative; }

        .product-details .product-qty-input,
        .product-details .product-qty-input:disabled { width: 100%; overflow: hidden; }

        .product-details .product-qty-increment,
        .product-details .product-qty-decrement { font-size: 6vw; position: absolute; right: 0; height: 100%; border: none; background-color: transparent; }

        .product-details .product-qty-increment { transform: translate(-6.5vw, 0vw); }

        .product-details .product-qty-decrement { transform: translate(-.5vw, -.5vw); }

        .product-details .product-button-add-item { width: 100%; height: 10vw; }
        
    }

</style>