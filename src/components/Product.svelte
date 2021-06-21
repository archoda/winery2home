<script>
    
    
    /*
        Imports
    */
    import { onMount, afterUpdate, createEventDispatcher, tick } from 'svelte';
    import { Store } from '../lib/js/store.js';

    import ImageComponent from './ImageComponent.svelte';
    import ImagePictureComponent from './ImagePictureComponent.svelte';
    import LinkComponent from './LinkComponent.svelte';
    import ButtonComponent from './ButtonComponent.svelte';


    /* 
        Exports: ScreenWidth
    */

    let ScreenWidth = 0;

    /*
        Exports: Products
    */

    export let ProductDisplayType;
    export let ProductInitCallback;
    export let AttributeId = null;
    export let AttributeClass = '';
    export let AttributeClassExtended = '';

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
    
    $: Qty = 3;             // Set according to standard cart minimum requirements
    $: QtyType = 'Bottles'; // Set according to standard cart minimum requirements
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
        console.log('Product Details Click Callback Called', Event.target);
        $Store.Modal.Type = 'ProductDetails';
        $Store.Modal.Data.Product = Product;
        $Store.Modal.Active = true;

        Event.stopPropagation();
        
        Event.preventDefault();

        return false;
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

<svelte:window bind:outerWidth={ScreenWidth}/>

{#if !Product}
    
    <p>No Product Petails.</p>

{:else}
        {#if ProductDisplayType === 'ProductHome'}

        <!-- Product Home Carousel Display Template -->
        <div if:id={AttributeId} class="{AttributeClass}-item {AttributeClassExtended}">

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

        </div>

        {/if}
        
        {#if ProductDisplayType === 'ProductShop'}
            
            <div if:id={AttributeId} class="{AttributeClass}-item {AttributeClassExtended}">
             
                <div class="product-image" on:click={ProductDetailsClick} >
                    
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

                <div class="product-buy">
                    <div class="product-title">{Product.name}</div>
                    <div class="product-winery">By {Winery}</div>
                    <div class="product-buy-price"><span class="product-buy-price-dollars">${PriceDollars}</span><span class="product-buy-price-cents">.{PriceCents}</span></div>
                    <div class="product-buy-note">Shipping & Handling In Cart<span>*</span></div>
                    <div class="product-buy-qty form">
                        <input class="product-qty-input" bind:value="{QtyString}" on:input={ (Event) => QtyUpdateInput(Event) } readonly />
                        <button class="product-qty-increment" on:click={() => { return QtyUpdate(Qty+1) } }>+</button>
                        <button class="product-qty-decrement" on:click={() => { return QtyUpdate(Qty-1); } }>-</button>
                    </div>
                    <ButtonComponent AttributeClass={"button button-wine product-button-add-item snipcart-add-item"} {AttributeDataset} on:click={ () => { console.log('add button clicked')}}>Add To Cart</ButtonComponent>
                </div>

            </div>
        {/if}

        {#if ProductDisplayType === 'ProductDetails'}

        <!-- Product Modal Display Template -->
        <div if:id={AttributeId} class="{AttributeClass}-item {AttributeClassExtended}">

            {#if ScreenWidth <= 767 }

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
                                <span class="tab-label" aria-label="Order" title="Order">Buy It</span>
                                <span class="tab-bar"><span class="tab-bar-active"></span></span>
                            </button>
                        </li>
                        <li class="tab tab-active">
                            <button role="tab">
                                <span class="tab-label" aria-label="Description" title="Description">Description</span>
                                <span class="tab-bar"><span class="tab-bar-active"></span></span>
                            </button>
                        </li>
                        <li class="tab tab-active">
                            <button role="tab">
                                <span class="tab-label" aria-label="Detail" title="Detail">Detail</span>
                                <span class="tab-bar"><span class="tab-bar-active"></span></span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-panels">
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

                            <div class="product-buy">
                                <div class="product-buy-price"><span class="product-buy-price-dollars">${PriceDollars}</span><span class="product-buy-price-cents">.{PriceCents}</span></div>
                                <div class="product-buy-note">Shipping & Handling In Cart<span>*</span></div>
                                <div class="product-buy-qty form">
                                    <input class="product-qty-input" bind:value="{QtyString}" on:input={ (Event) => QtyUpdateInput(Event) } readonly />
                                    <button class="product-qty-increment" on:click={() => { return QtyUpdate(Qty+1) } }>+</button>
                                    <button class="product-qty-decrement" on:click={() => { return QtyUpdate(Qty-1); } }>-</button>
                                </div>
                                <ButtonComponent AttributeClass={"button button-wine product-button-add-item snipcart-add-item"} {AttributeDataset} on:click={ () => { console.log('add button clicked')}}>Add To Cart</ButtonComponent>
                            </div>

                        </div>

                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">

                            {@html Description}

                        </div>
                        
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                            
                            
                            {#if TastingNotes }
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-tasting-notes.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Tasting Notes Clipboard Icon Graphic'} ImageAlt={'Tasting Notes Clipboard Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">Tasting Notes</div>
                                {#each TastingNotes as Item}
                                <div class="product-detail-link">
                                    <LinkComponent AttributeClass={'wine-text'} AttributeHref={Item.tasting_notes_pdf.url} AttributeTarget={Item.tasting_notes_pdf.taget} AttributeTitle={Item.tasting_notes_title}>{@html Item.tasting_notes_title}</LinkComponent>
                                </div>
                                {/each}
                            </div>
                            {/if}

                            {#if RatingsReviews}
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-ratings-reviews.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Ratings Reviews Stars Icon Graphic'} ImageAlt={'Ratings Reviews Stars Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">Ratings/Reviews</div>
                                {#each RatingsReviews as Item}
                                <div class="product-detail-link">
                                    {@html Item.rating_review_score} Pts. by <LinkComponent AttributeClass={'wine-text'} AttributeHref={Item.rating_review_link.url} AttributeTarget={Item.rating_review_link.target} AttributeTitle={Item.rating_review_link.title}>{@html Item.rating_review_author}</LinkComponent>
                                </div>
                                {/each}
                            </div>
                            {/if}

                            {#if Volume}
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-alcohol-volume.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Alcohol/Water Drop Icon Graphic'} ImageAlt={'Alcohol/Water Drop Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">{@html Volume}% Alc.</div>
                            </div>
                            {/if}

                            {#if FoodPairings}
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-food-pairings.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Food Pairings Waitstaff Hand Carring Food Platter Icon Graphic'} ImageAlt={'Food Pairings Waitstaff Hand Carring Food Platter Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">Food Pairings</div>
                                {#each FoodPairings as Item}
                                <div class="product-detail-link">
                                    <LinkComponent AttributeClass={'wine-text'} AttributeHref={Item.food_pairing_link.url} AttributeTarget={Item.food_pairing_link.target} AttributeTitle={Item.food_pairing_title}>{@html Item.food_pairing_title}</LinkComponent>
                                </div>
                                {/each}
                            </div>
                            {/if}

                        </div>
                    </div>

            </div>
            {/if}

            {#if ScreenWidth >= 768 }
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
                                <span class="tab-label" aria-label="Order" title="Order">Buy It</span>
                                <span class="tab-bar"><span class="tab-bar-active"></span></span>
                            </button>
                        </li>
                        <li class="tab tab-active">
                            <button role="tab">
                                <span class="tab-label" aria-label="Description" title="Description">Description</span>
                                <span class="tab-bar"><span class="tab-bar-active"></span></span>
                            </button>
                        </li>
                        <li class="tab tab-active">
                            <button role="tab">
                                <span class="tab-label" aria-label="Detail" title="Detail">Detail</span>
                                <span class="tab-bar"><span class="tab-bar-active"></span></span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-panels">
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">

                            <div class="product-buy">
                                <div class="product-buy-price"><span class="product-buy-price-dollars">${PriceDollars}</span><span class="product-buy-price-cents">.{PriceCents}</span></div>
                                <div class="product-buy-note">Shipping & Handling Details At Checkout<span>*</span></div>
                                <div class="product-buy-qty form">
                                    <input class="product-qty-input" bind:value="{QtyString}" on:input={ (Event) => QtyUpdateInput(Event) } readonly />
                                    <button class="product-qty-increment" on:click={() => { return QtyUpdate(Qty+1) } }>+</button>
                                    <button class="product-qty-decrement" on:click={() => { return QtyUpdate(Qty-1); } }>-</button>
                                </div>
                                <ButtonComponent AttributeClass={"button button-wine product-button-add-item snipcart-add-item"} {AttributeDataset} on:click={ () => { console.log('add button clicked')}}>Add To Cart</ButtonComponent>
                            </div>

                        </div>

                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">

                            {@html Description}

                        </div>
                        
                        <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                            
                            
                            {#if TastingNotes}
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-tasting-notes.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Tasting Notes Clipboard Icon Graphic'} ImageAlt={'Tasting Notes Clipboard Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">Tasting Notes</div>
                                {#each TastingNotes as Item}
                                <div class="product-detail-link">
                                    <LinkComponent AttributeClass={'wine-text'} AttributeHref={Item.tasting_notes_pdf.url} AttributeTarget={Item.tasting_notes_pdf.taget} AttributeTitle={Item.tasting_notes_title}>{@html Item.tasting_notes_title}</LinkComponent>
                                </div>
                                {/each}
                            </div>
                            {/if}

                            {#if RatingsReviews}
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-ratings-reviews.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Ratings Reviews Stars Icon Graphic'} ImageAlt={'Ratings Reviews Stars Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">Ratings/Reviews</div>
                                {#each RatingsReviews as Item}
                                <div class="product-detail-link">
                                    {@html Item.rating_review_score} Pts. by <LinkComponent AttributeClass={'wine-text'} AttributeHref={Item.rating_review_link.url} AttributeTarget={Item.rating_review_link.target} AttributeTitle={Item.rating_review_link.title}>{@html Item.rating_review_author}</LinkComponent>
                                </div>
                                {/each}
                            </div>
                            {/if}

                            {#if FoodPairings}
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-food-pairings.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Food Pairings Waitstaff Hand Carring Food Platter Icon Graphic'} ImageAlt={'Food Pairings Waitstaff Hand Carring Food Platter Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">Food Pairings</div>
                                {#each FoodPairings as Item}
                                <div class="product-detail-link">
                                    <LinkComponent AttributeClass={'wine-text'} AttributeHref={Item.food_pairing_link.url} AttributeTarget={Item.food_pairing_link.target} AttributeTitle={Item.food_pairing_title}>{@html Item.food_pairing_title}</LinkComponent>
                                </div>
                                {/each}
                            </div>
                            {/if}

                            {#if Volume}
                            <div class="product-detail-item">
                                <div class="product-detail-icon"><ImageComponent ImageClass={''} ImageSrc={$Store.API.Root + '/lib/images/icon-alcohol-volume.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle={'Alcohol/Water Drop Icon Graphic'} ImageAlt={'Alcohol/Water Drop Icon Graphic'} ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } /></div>
                                <div class="product-detail-header">{@html Volume}% Alc.</div>
                            </div>
                            {/if}

                        </div>
                    </div>

                </div>
            {/if}

        </div>
        {/if}

{/if}


<style global lang="scss">


    .product-rating-badge { position: absolute; z-index: 3; }
    
    .product-rating-large { font-family: "Montserrat-Medium", "Arial", "Helvetica", sans-serif; color: #FFF; }

    .product-rating-small { font-family: "Montserrat-Light", "Arial", "Helvetica", sans-serif; color: #FFF; text-transform: uppercase; }


    .product-image { position: relative; }

    .product-image-1,
    .product-image-2,
    .product-image-3 { position: absolute; top: 0; left: 0; }
    

    @media (min-width: 0px) and (max-width: 767px)
    {  
        
        /*
            HOME PRODUCTS CAROUSEL
        */

        .products-home { margin-top: 8vw;  text-align: center; }

        .products-home .product-carousel-cell { width: 100%; height: auto; margin: 0; overflow: hidden; }

        .products-home .product-rating-badge { transform: translate(60.75vw, 26.75vw); width: 20vw; height: auto; }
            
        .products-home .product-rating-large { position: absolute; z-index: 2; font-size: 6.75vw; transform: translate(8.75vw, -3.45vw); }
        .products-home .product-rating-small { position: absolute; z-index: 2; font-size: 2.35vw; transform: translate(8.25vw, 3.45vw); }
            
        .products-home .product-rating-badge img { transform: translate(3vw, -31px) scale(0.7); }

        .products-home .product-image-details { position: absolute; z-index: 1; transform: translate(0vw, 29vw) scale(-0.11);  }
        .products-home img.product-image { padding: 0 40.5vw; }
        .products-home img.product-image-badge { padding: 0 0vw; }

        .products-home .product-image-1 { transform: translate(-16vw, 0) scale(.85); }
        .products-home .product-image-2 { transform: translate(16vw, 0) scale(.85); }

        .products-home .product-title { margin: 6vw 0 0; font-size: 4.5vw; display: grid; text-align: center; height: 11vw; align-items: center; }
        
        /*
            SHOP PRODUCTS CAROUSEL
        */

        .products-shop { margin-top: 8vh; padding: 0 8vw; }
        
        .products-shop div.product-image {  margin: 0 0 0 3vw; }

        .products-shop img.product-image { width: 15.25vw; margin: 0 0 2vw 0; }

        .products-shop img.product-image-1 { transform: translate(-3.15vw, 0) scale(.85); }
        .products-shop img.product-image-2 { transform: translate(3.15vw, 0) scale(.85); }

        .products-shop .product-rating-badge { transform: translate(3.25vw, 2.25vw) scale(0.425); width: 7.5vw; height: auto; }
            
        .products-shop .product-rating-large { position: absolute; z-index: 2; font-size: 3.15vw; transform: translate(1.58vw, 1.25vw); }
        .products-shop .product-rating-small { position: absolute; z-index: 2; font-size: 1.25vw; transform: translate(1.15vw, 4.55vw); }
            
        .products-shop .product-image-details { cursor: pointer; position: absolute; z-index: 1; bottom: 1vw; left: 1vw; width: 2.25vw; height: 2.25vw; }

        .products-shop .product-buy {}

        .products-shop .product-title { font-size: 1.75vw; color: var(--primary-wine); display: grid; align-items: end; height: 5.75vw; }

        .products-shop .product-winery { margin: 0.25vw 0 0; }

        .products-shop .product-buy-price { margin: .85vw 0 0; }

        .products-shop .product-buy-price-dollars { font-size: 2vw; }

        .products-shop .product-buy-price-cents { display: inline-block; transform: translate(0,-.9vw); }

        .products-shop .product-buy-note { font-size: .625vw; margin: .25vw 0 .50vw; }

        .products-shop .product-qty-input { text-align: center; width: 11.25vw; margin: .25vw 0 0; }

        .products-shop .product-qty-increment,
        .products-shop .product-qty-decrement { position: absolute; top: 10vw; }

        .products-shop .product-button-add-item { margin: .5vw 0 0; }



        /*
            MODAL PRODUCT TABS & DETAIL
        */


        .product-details-item { position: relative; width: 100%; height: 100%; text-align: center; padding: 0 12vw; }

        .product-details-item .product-title { display: grid; justify-content: center; align-items: center; }
        .product-details-item .product { font-size: 6.5vw; display: grid; align-items: flex-end; width: 100%; height: 14vw; margin: 16vw 0 1vw; color: var(--primary-wine); }
        .product-details-item .winery { width: 100%; }


        /* -- Tab Group, Panels & Panel Group */

        .product-details-item .tab-group,
        .product-details-item .tab-panels,
        .product-details-item .tab-panel { width: 100%; height: 100%; }

        .product-details-item .tab-control { position: initial; z-index: initial; top: initial; left: initial; }

        .product-details-item .tab-control,
        .product-details-item .tab { list-style: none; margin: 0; padding: 0; }

        .product-details-item .tab-control { display: inline-grid; grid-template-columns: 1fr 1fr 1fr; grid-column-gap: 2vw; width: 100%; padding: 5vw 0 3vw; }

        .product-details-item .tab-panels { top: 62vw; }

        .product-details-item .tab-panel { text-align: center; }

        .product-details-item .tab { position: relative; border: none; width: 100%; max-width: 68vw; height: 14vw; margin: 0 0 8vw; background-color: transparent; }

        .product-details-item .tab + .tab { margin-top: 0; }

        .product-details-item .tab button { text-align: center; border: none; margin: 0; padding: 0; bottom: 0; left: 0; background: transparent; width: 100%; height: 100%; }

        .product-details-item .tab .tab-label { font-family: "Montserrat-Medium", "Arial", "Helvetica", sans-serif; font-size: 4vw; height: auto; display: block; margin: 3.5vw 0 3.5vw; background-color: initial; }

        .product-details-item .tab .tab-label,
        .product-details-item .tab .tab-bar,
        .product-details-item .tab .tab-bar-active { width: 100%; }

        .product-details-item .tab .tab-bar,
        .product-details-item .tab .tab-bar-active { display: block; border-radius: 10px 10px; }

        .product-details-item .tab .tab-bar { z-index: 1; position: relative; left: initial; right: initial; bottom: initial; height: 10%; background-color: var(--primary-gray); }

        .product-details-item .tab .tab-bar-active { z-index: 2; background-color: var(--primary-wine); }


        /* -- Tab Panel = Buy It */

        .product-details-item .product-rating-badge { transform: translate(67.5vw, 21.25vw); width: 20vw; height: auto; }
        .product-details-item .product-rating-large { position: absolute; z-index: 3; font-size: 7vw; transform: translate(5.85vw, 4.5vw); }
        .product-details-item .product-rating-small { position: absolute; z-index: 3; font-size: 2.65vw; transform: translate(4.85vw, 11.25vw); }
        .product-details-item .product-rating-badge img { transform: scale(0.775); }

        .product-details-item img.product-image { padding: 0 38.5vw; }

        .product-details-item img.product-image-0 { opacity: 0; }
        .product-details-item img.product-image-1 { z-index: 1; transform: translate(-18vw, 0) scale(.85); }
        .product-details-item img.product-image-2 { z-index: 1; transform: translate(18vw, 0) scale(.85); }
        .product-details-item img.product-image-3 { z-index: 2; }

        .product-details-item .product-buy-note { font-size: 3vw; margin-bottom: 4vw; }
        
        .product-details-item .product-buy { display: grid; grid-auto-columns: 2fr; grid-column-gap: 4vw; margin: 4vw 11vw; }

        .product-details-item .product-buy-price,
        .product-details-item .product-buy-note { grid-column: 1/span 2; }

        .product-details-item .product-buy-price-dollars { font-size: 10vw; }
        .product-details-item .product-buy-price-cents { font-size: 6vw; transform: translate(1vw, -3vw); display: inline-block; }

        .product-details-item .product-buy-qty { position: relative; }

        .product-details-item .product-qty-input,
        .product-details-item .product-qty-input:readonly { overflow: hidden; text-align: center; border: .05vw solid var(--primary-tan-dark); }

        .product-details-item .product-qty-increment,
        .product-details-item .product-qty-decrement { font-size: 6vw; position: absolute; width: 7.25vw; margin: 0; border: .05vw solid var(--primary-tan-dark); background-color: transparent; }

        .product-details-item .product-qty-increment { top: 0; left: 0; } /* transform: translate(-7.35vw, 0vw); */
        .product-details-item .product-qty-decrement { top: 0; right: 0; } /* transform: translate(-7.35vw, 0vw); */


        .product-details-item .product-button-add-item { width: 100%; margin: 0; }

        .product-details-item .product-detail-item { width: 100%; }

        .product-details-item .product-detail-item + .product-detail-item { margin-top: 10vw; }

        .product-details-item .product-detail-item > div + div { margin-top: 2vw; }

        .product-details-item .product-detail-icon img { width: 8vw; }
        
        .product-details-item .product-detail-header { font-size: 5vw; } 

        .product-details-item .product-detail-header + .product-detail-link { margin-top: 2.25vw; } 

        .product-detail-link + .product-detail-link { margin-top: 2vw; } 

    }

    @media (min-width: 768px) and (max-width: 100000000px)
    {  
        
        /*
            HOME: PRODUCT
        */
        
        .products-home { margin-top: 11vh; }

        .products-home div.product-image {  margin: 0 0 0 18vw; }

        .products-home img.product-image { width: 10vw; }

        .products-home img.product-image-1 { transform: translate(-8vw, 0) scale(.85); }
        .products-home img.product-image-2 { transform: translate(8vw, 0) scale(.85); }
        
        .products-home .product-rating-badge { transform: translate(13.25vw, 10.75vw) scale(0.775); width: 7.5vw; height: auto; }
            
        .products-home .product-rating-large { position: absolute; z-index: 2; font-size: 3.15vw; transform: translate(1.80vw, 1.25vw); }
        .products-home .product-rating-small { position: absolute; z-index: 2; font-size: 1.25vw; transform: translate(1.25vw, 4.55vw); }
            
        .products-home .product-image-details { cursor: pointer; position: absolute; z-index: 1; bottom: -1.5vw; left: 2.75vw; width: 3.75vw; height: 3.75vw; }

        .products-home .product-title { font-size: 1.25vw; margin: -3vw 0 4vw 2vw; display: grid; text-align: right; height: 6vw; align-items: center; width: 13vw; }

         /*
            SHOP: PRODUCT
        */
        
        .products-shop { margin-top: 11vh; padding: 0 8vw; }

        .products-shop div.product-image {  margin: 0 0 0 3vw; }

        .products-shop img.product-image { width: 4.25vw; margin: 0 0 2vw 0; }

        .products-shop img.product-image-1 { transform: translate(-3.15vw, 0) scale(.85); }
        .products-shop img.product-image-2 { transform: translate(3.15vw, 0) scale(.85); }
        
        .products-shop .product-rating-badge { transform: translate(3.25vw, 2.25vw) scale(0.425); width: 7.5vw; height: auto; }
            
        .products-shop .product-rating-large { position: absolute; z-index: 2; font-size: 3.15vw; transform: translate(1.58vw, 1.25vw); }
        .products-shop .product-rating-small { position: absolute; z-index: 2; font-size: 1.25vw; transform: translate(1.15vw, 4.55vw); }
            
        .products-shop .product-image-details { cursor: pointer; position: absolute; z-index: 1; bottom: 1vw; left: 1vw; width: 2.25vw; height: 2.25vw; }

        .products-shop .product-image,
        .products-shop .product-buy { float: left; }

        .products-shop .product-buy { width: 19vw; padding: 0 0 0 5.5vw; }

        .products-shop .product-title { font-size: 1.75vw; color: var(--primary-wine); display: grid; align-items: end; height: 5.75vw; }

        .products-shop .product-winery { margin: 0.25vw 0 0; }

        .products-shop .product-buy-price { margin: .85vw 0 0; }

        .products-shop .product-buy-price-dollars { font-size: 2vw; }

        .products-shop .product-buy-price-cents { display: inline-block; transform: translate(0,-.9vw); }

        .products-shop .product-buy-note { font-size: .625vw; margin: .25vw 0 .50vw; }

        .products-shop .product-qty-input { text-align: center; width: 11.25vw; margin: .25vw 0 0; }

        .products-shop .product-qty-increment,
        .products-shop .product-qty-decrement { position: absolute; top: 10vw; }

        .products-shop .product-button-add-item { margin: .5vw 0 0; }

        /*
            MODAL PRODUCT TABS & DETAIL
        */


        .product-details-item { text-align: left; position: relative; overflow: hidden; display:grid; grid-template-columns: 42vw 68vw; width: 100%; height: 100%; padding: 0 10vw; }

        .product-details-item .product-title { display: grid; justify-content: left; align-items: center; }
        .product-details-item .product { font-size: 2.05vw; font-variation-settings: "wght" 500; display: grid; align-items: flex-end; width: 22vw; height: 4vw; margin: 19vw 0 .45vw; color: var(--primary-wine); }
        .product-details-item .winery { width: 100%; margin-top: .25vw; }


        // /* -- Tab Group, Panels & Panel Group */

        .product-details-item .tab-group { position: relative; }

        .product-details-item .tab-group,
        .product-details-item .tab-panels,
        .product-details-item .tab-panel { width: 100%; height: 100%; }

        .product-details-item .tab-control { position: initial; z-index: initial; top: initial; left: initial; }

        .product-details-item .tab-control,
        .product-details-item .tab { list-style: none; margin: 0; padding: 0; }

        .product-details-item .tab-control { display: inline-grid; grid-template-columns: 1fr 1fr 1fr; grid-column-gap: .3vw; width: 14vw; padding: 2.5vw 0 0; }

        .product-details-item .tab-panels { top: 30vw;}

        .product-details-item .tab-panel { top: 1.5vw; height: auto; padding: 0 15vw 0 0; }

        .product-details-item .tab-panel:nth-child(2)  { top: .75vw; display: grid; grid-template-columns: 1fr; padding: 0 35vw 0 0;  }
        .product-details-item .tab-panel:nth-child(3) { display: grid; grid-template-columns: 1fr 1fr; padding: 0 35vw 0 0;  }

        .product-details-item .tab { position: relative; border: none; width: 100%; max-width: 68vw; height: 1.9vw; background-color: transparent; }

        .product-details-item .tab + .tab { margin-top: 0; }

        .product-details-item .tab button { text-align: center; border: none; margin: 0; padding: 0; bottom: 0; left: 0; background: transparent; width: 100%; height: 100%; }

        .product-details-item .tab .tab-label { font-family: "Montserrat-Medium", "Arial", "Helvetica", sans-serif; font-size: .75vw; height: auto; display: block; margin: 0 0 .55vw; background-color: initial; }

        .product-details-item .tab .tab-label,
        .product-details-item .tab .tab-bar,
        .product-details-item .tab .tab-bar-active { width: 100%; }

        .product-details-item .tab .tab-bar,
        .product-details-item .tab .tab-bar-active { display: block; border-radius: 10px 10px; }

        .product-details-item .tab .tab-bar { z-index: 1; position: relative; left: initial; right: initial; bottom: initial; height: .25vw; background-color: var(--primary-gray); }

        .product-details-item .tab .tab-bar-active { z-index: 2; background-color: var(--primary-wine); }


        // /* -- Tab Panel = Buy It */

        .product-details-item .product-image { overflow: hidden; }

        .product-details-item .product-rating-badge { transform: translate(28vw, 12.75vw); width: 20vw; height: auto; }
        .product-details-item .product-rating-large { position: absolute; z-index: 3; font-size: 2.5vw; transform: translate(8.5vw, 8.25vw); }
        .product-details-item .product-rating-small { position: absolute; z-index: 3; font-size: 0.75vw; transform: translate(8.5vw, 10.75vw); }
        .product-details-item .product-rating-badge img { transform: scale(0.25); }

        .product-details-item img.product-image { padding: 8vw 16.15vw; }

        .product-details-item img.product-image-0 { opacity: 0; }
        .product-details-item img.product-image-1 { z-index: 1; transform: translate(13vw, 0) scale(.85); }
        .product-details-item img.product-image-2 { z-index: 1; transform: translate(-3vw, 0) scale(.85); }
        .product-details-item img.product-image-3 { z-index: 2; transform: translate(5vw, 0); }

        .product-details-item .product-buy-note { font-size: .55vw; margin-bottom: 2vw; }
        
        .product-details-item .product-buy { display: grid; grid-auto-columns: 10.5vw 25vw; grid-column-gap: .8vw; } /* margin-top: 0vw; */

        .product-details-item .product-buy-price,
        .product-details-item .product-buy-note { grid-column: 1/span 2; }

        .product-details-item .product-buy-price-dollars { font-size: 2.75vw; }
        .product-details-item .product-buy-price-cents { font-size: 1.5vw; transform: translate(0, -1vw); display: inline-block; }
        
        .product-details-item .product-buy-qty { position: relative; }

        .product-details-item .product-qty-input,
        .product-details-item .product-qty-input:readonly { overflow: hidden; text-align: center; width: 10vw; border: .05vw solid var(--primary-tan-dark); }

        .product-details-item .product-qty-increment,
        .product-details-item .product-qty-decrement { cursor: pointer; font-size: 1.25vw; position: absolute; top: 0; width: 1.75vw; height: 2.45vw; margin: 0; border: .05vw solid var(--primary-tan-dark); background-color: transparent; }

        .product-details-item .product-qty-decrement { right: .5vw; }

        .product-details-item .product-qty-increment { left: 0; }

        .product-details-item .product-button-add-item { cursor: pointer; width: 11vw; margin: 0; }

        .product-details-item .product-detail-item { position: relative; width: 100%; margin-bottom: 2.5vw }

        .product-details-item .product-detail-icon { position: absolute; top: 0; left: 0; }

        .product-details-item .product-detail-icon img { width: 2.5vw; }
        
        .product-details-item .product-detail-header { font-size: 1.25vw; margin-left: 3.25vw; } 

        .product-details-item .product-detail-header + .product-detail-link { margin-top: 0.25vw; margin-left: 3.25vw; } 

        .product-detail-link + .product-detail-link { margin-top: .25vw; } 

    }

</style>