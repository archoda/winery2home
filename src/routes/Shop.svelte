<script>

    /*
        Imports
    */
    import { onMount, beforeUpdate, afterUpdate, createEventDispatcher } from 'svelte';
	import { Store } from '../lib/js/store.js';
    import StoreManagerClass from '../lib/js/StoreManagerClass.js';
    import { transition } from '../lib/js/transition.js';
    import anime from 'animejs';

    import MastheadComponent from '../components/MastheadComponent.svelte';
    import ButtonComponent from '../components/ButtonComponent.svelte';
    import ImageComponent from '../components/ImageComponent.svelte';
    import ImagePictureComponent from '../components/ImagePictureComponent.svelte';
    import ProductsComponent from '../components/ProductsComponent.svelte';

    /*
        Exports
    */
    export let LoaderInitCallback;

    let ScreenWidth;

    let Products = [];
    let ProductsFiltered = [];
    let ProductsActive = false;

    const ProductsFilteredByRegion = (Event) => 
    {
        ProductsActive = false;
        
        ProductsFiltered = [];

        let ProductFilteredRegion = document.querySelector('[name=shop-filter-region]');
        let ProductFilteredRegionValue = ProductFilteredRegion.value
        if (ProductFilteredRegionValue === 'null')
        {
            ProductsFiltered = Products;
        }
        else
        {
            Products.forEach( (Product) => 
            {

                if (Product.winery.region.value === ProductFilteredRegionValue)
                {
                    ProductsFiltered.push(Product);
                }

            });   
        }

        let ProductFilterInterval = setInterval( () => 
        {
            
            ProductsActive = true;
            ProductFilteredRegion.blur();
            clearInterval(ProductFilterInterval);

        }, 250);
    }

    const ProductsFilteredByVarietal = (Event) => 
    {
        ProductsActive = false;
        
        ProductsFiltered = [];

        let ProductFilteredVarietal = document.querySelector('[name=shop-filter-varietal]');
        let ProductFilteredVarietalValue = ProductFilteredVarietal.value;

        if (ProductFilteredVarietalValue === 'null')
        {
            ProductsFiltered = Products;
        }
        else
        {
            Products.forEach( (Product) => 
            { 
                if (Product.varietal.value === ProductFilteredVarietalValue)
                {
                    ProductsFiltered.push(Product);
                }

            });
        }

        let ProductFilterInterval = setInterval( () => 
        {
            
            ProductsActive = true;
            ProductFilteredVarietal.blur();
            clearInterval(ProductFilterInterval);

        }, 250);
    }

    onMount(() => {

        LoaderInitCallback({ 
            LoaderActive: true,
            LoaderType:  'circle',
            LoaderClassColor: '#FFFFFF',
            LoaderOptions: $Store.Pages.Shop.Loader,
            LoaderCompleteCallback: (_Data) =>
            {   
                const StoreManager = new StoreManagerClass($Store);

                // Set the Wineries Data if not already set...
                if (_Data.Responses[0].status != 200 || _Data.Responses[0].ok) 
                {   
                    // Load the products
                    ProductsFiltered = Products = $Store.API.Wineries.All = StoreManager.WineriesAllSet(_Data.Results[0], true);

                    // Activate the products
                    ProductsActive = true;

                    console.log(Products);
                }
                else
                {
                    // Something has gone wrong
                }

            }
        });

    });

    beforeUpdate( () => {
        // Do something...
        //console.log('After Update', Products);
    });

    afterUpdate( () => {
        // Do something...
        //console.log('Before Update', Products);
    });

</script>


<svelte:head>
    <title>{ $Store.Pages.Shop.Title } | { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.Shop.Description }">
     <!-- FLICKITY -->
     <script async type="text/javascript" src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
     <link rel="preload stylesheet" as="style" type="text/css" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</svelte:head>

<svelte:window bind:outerWidth={ScreenWidth}/>

<main class="main main-shop">

    <div id="tab-group-1" class="tab-group" role="tablist" aria-label="Winery Products" data-tab-group-id="1">

        <div class="tab-panels">
            <div class="tab-panel" tabindex="0" role="tabpanel">

                <MastheadComponent Class={"center"} headersmall={"Shop The"} header={"Wineries"} body={""}>
                    <ButtonComponent AttributeId={'shop-filter-region'} AttributeClass={'products-shop-filter shop-filter-region'} AttributeTitle={'Shop Filter by Region'}>
                        <form>
                            <label for="shop-filter-region">
                                
                                <ImageComponent
                                    ImageClass={['shop-filter-region-icon']} 
                                    ImageSrc={'/lib/images/icon-filter.svg'} 
                                    ImageWidth={'400'} ImageHeight={'400'} 
                                    ImageTitle='Shop Filter by Region Graphical Icon' 
                                    ImageAlt='Shop Filter by Region Graphical Icon' 
                                    ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                    
                                <span class="shop-filter-region-label">Region</span>
                            
                                <select name="shop-filter-region" on:change={ProductsFilteredByRegion}>
                                    <option value="null">All</option>
                                    {#each $Store.API.Wineries.Maps as Map}
                                        <optgroup label="{Map.Name}">
                                        {#each Map.Regions as Region}
                                            <option value="{Region.Key}">{Region.Value.split(', ')[1]}</option>
                                        {/each}
                                        </optgroup>
                                    {/each}

                                </select>
                            </label>
                        </form>
                    </ButtonComponent>   
                    <ButtonComponent AttributeId={'shop-filter-varietal'} AttributeClass={'products-shop-filter shop-filter-varietal'} AttributeTitle={'Shop Filter by Varietal'}>
                        <form>
                            <label for="shop-filter-varietal">
                                
                                <ImageComponent
                                    ImageClass={['shop-filter-vatietal-icon']} 
                                    ImageSrc={'/lib/images/icon-filter.svg'} 
                                    ImageWidth={'400'} ImageHeight={'400'} 
                                    ImageTitle='Shop Filter by Region Graphical Icon' 
                                    ImageAlt='Shop Filter by Region Graphical Icon' 
                                    ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />

                                <span class="shop-filter-vatietal-label">Varietal</span>
                            
                                <select name="shop-filter-varietal" on:change={ProductsFilteredByVarietal}>
                                    <option value="null">All</option>
                                    {#each $Store.API.Wineries.Varietals as Varietal}
                                    <optgroup label="{Varietal.Name}">
                                        {#each Varietal.Types as Type}
                                        <option value="{Type.split(' ').join('')}">{Type}</option>
                                        {/each}
                                    {/each}

                                </select>
                            </label>
                        </form>
                    </ButtonComponent>     
                </MastheadComponent>
                
                {#if ProductsActive}
                    {#if ProductsFiltered.length >= 1}
                        <ProductsComponent ProductDisplayType={'ProductShop'} ProductsPerView={[1,3]} AttributeClass={'products-shop'} Products={ProductsFiltered} ScreenWidth={ScreenWidth} />
                    {:else}
                        <p>Your filter returned no results.</p>
                    {/if}
                {/if}
            
            </div>
        </div>

        <div class="tab-panels">
            <div class="tab-panel" tabindex="0" role="tabpanel">

                <ImagePictureComponent
                ImageId={''} 
                ImageClass='responsive-img-cover' 
                ImageSrc={'./lib/images/shop-background-mobile-slide.jpg'} 
                ImageWidth={'414'} 
                ImageHeight={'896'} 
                ImageTitle={'Image Background'} 
                ImageAlt={'Image Background'} 
                ImageSources={ 
                    [
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
                    ]
                } />

            </div>
        </div>

    </div>

</main>


<style global lang="scss">
	
    .main-shop { z-index: 2; overflow-x: hidden; overflow-y: scroll; overflow-x: hidden; -ms-overflow-style: none;  /* IE and Edge */ scrollbar-width: none;  /* Firefox */ }
    .main-shop::-webkit-scrollbar { display: none; }

    button.products-shop-filter,
    button.products-shop-filter label { position: relative; display: inline-block; }

    select { position: absolute; top: 0; left:0; right: 0; bottom: 0; opacity: 0; }
    
    button.products-shop-filter span { display: inline-block; }

    @media (min-width: 0px) and (max-width: 767px)
    {  
        button.products-shop-filter { margin-top: 1vw; }

        button.products-shop-filter,
        button.products-shop-filter label { height: 5vw; }

        button.products-shop-filter span { transform: translate(0, -1.45vw); }

        button.products-shop-filter img { width: 6vw !important; margin: 0 1vw 0 1vw; }
    }

    @media (min-width: 768px) and (max-width: 100000000px)
    {  
        button.products-shop-filter,
        button.products-shop-filter label { height: 5vw; }

        button.products-shop-filter span { font-size: 1vw; transform: translate(0, -.5vw); }

        button.products-shop-filter img { width: 2vw !important; margin: 0 1vw 0 1vw; }

        button.products-shop-filter form { width: 10vw !important; margin: 0 !important; }
    }
</style>