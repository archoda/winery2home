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
    import ImagePictureComponent from '../components/ImagePictureComponent.svelte';
    import ProductsComponent from '../components/ProductsComponent.svelte';

    /*
        Exports
    */
    export let LoaderInitCallback;

    let Products = [];
    let ProductsActive = false;

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
                    Products = $Store.API.Wineries.All = StoreManager.WineriesAllSet(_Data.Results[0], true);

                    // Activate the products
                    ProductsActive = true;
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
</svelte:head>


<main class="main main-shop">

    <div id="tab-group-1" class="tab-group" role="tablist" aria-label="Winery Products" data-tab-group-id="1">

        <div class="tab-panels">
            <div class="tab-panel" tabindex="0" role="tabpanel">

                <MastheadComponent Class={"center"} headersmall={"Shop The"} header={"Wineries"} body={""} />
                
                {#if ProductsActive}
                <ProductsComponent ProductDisplayType={'ProductShop'} ProductsPerView={[1,3]} AttributeClass={'products-shop'} Products={Products} />
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
	
    .main-center { display: grid; width: 100%; height: 100%; align-items: center; justify-items: center; }

</style>