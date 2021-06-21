
<script>

    /*
        Imports
    */
    import { onMount, createEventDispatcher } from 'svelte';
	import { Store } from '../lib/js/store.js';
    import StoreManagerClass from '../lib/js/StoreManagerClass.js';
    import anime from 'animejs';

    import MastheadComponent from '../components/MastheadComponent.svelte';
    import MapComponent from '../components/MapComponent.svelte';
    import ProductsComponent from '../components/ProductsComponent.svelte';
    import LinkComponent from '../components/LinkComponent.svelte';
    import ButtonComponent from '../components/ButtonComponent.svelte';
    import ImagePictureComponent from '../components/ImagePictureComponent.svelte';
    

    /*
        Exports
    */
    export let LoaderInitCallback;

    /* 
        ScreenWidth
    */

    let ScreenWidth = 0;

    /*
        TABS * SLIDERS 
    */

    const TabsToggle = (_Args, Event) =>
    { 
        let TabGroup = _Args.TabGroup;
        let TabGroupIndex = _Args.TabGroupIndex;
        let TabControl = _Args.TabControl;
        let TabPanels = _Args.TabPanels;
        let TabButtonIndex = _Args.TabButtonIndex;
        let TabTransitionSpeed = _Args.TabTransitionSpeed;
        
        // Change it up
        if (_Args.TabHashIndex)
        {
            TabButtonIndex = _Args.TabHashIndex;
        }

        // Loop through all the tab buttons and change correct hide/show by selected index
        TabControl.querySelectorAll('li').forEach((Tab, TabIndex) => {

            let Span = Tab.querySelector('span');

            if (TabIndex != TabButtonIndex)
            {
                Tab.classList.remove('tab-active');
                
                anime({
                    targets: Span,
                    height: [Span.style.height + 'vw', 0 + 'vw'],
                    duration: TabTransitionSpeed/2,
                    direction: 'forward',
                    easing: 'linear',
                    loop: false,
                    complete: () => {
                        
                    }
                });
            }
            else
            {
                Tab.classList.add('tab-active');
                
                anime({
                    targets: Span,
                    height: [Span.style.height + 'vw',25 + 'vw'],
                    duration: TabTransitionSpeed/2,
                    direction: 'forward',
                    easing: 'linear',
                    loop: false,
                    complete: () => {
                        
                    }
                });
            }
        });

        // Loop through all the panels and change the correct hide/show by selected index.
        TabPanels.forEach((TabPanel, TabPanelIndex) =>
        {      
            TabPanel.querySelectorAll('.tab-panel').forEach((Panel, PanelIndex) =>
            {
                
                if (PanelIndex != TabButtonIndex)
                {
                    Panel.classList.remove('tab-panel-active');

                    anime({
                        targets: Panel,
                        opacity: [Panel.style.opacity,0],
                        duration: TabTransitionSpeed,
                        direction: 'forward',
                        easing: 'linear',
                        loop: false,
                        complete: () => {
                            Panel.style.zIndex = 0;
                            Panel.style.opacity = 0;
                        }
                    });

                }
                else
                {
                    Panel.classList.add('tab-panel-active');

                    anime({
                        targets: Panel,
                        opacity: [Panel.style.opacity,1],
                        duration: TabTransitionSpeed,
                        direction: 'forward',
                        easing: 'linear',
                        loop: false,
                        begin: () =>
                        {
                            //Panel.style.display = 'block';
                        },
                        complete: () => {
                            Panel.style.zIndex = 1;
                            Panel.style.opacity = 1;
                        }
                    });

                }

            });

        });

    };

    const TabsInit = () =>
    {   
        let TabTransitionSpeed = 500;
        let TabGroups = document.querySelectorAll('.tab-group');
        let TabAutoIndexByHash = null;

        TabGroups.forEach((TabGroup, TabGroupIndex) => {

            let TabControl = TabGroup.querySelector('.tab-control');
            let TabPanels = TabGroup.querySelectorAll('.tab-panels');

            TabControl.querySelectorAll('li').forEach((TabButton, TabButtonIndex) =>
            {
                let TabGroupData = {
                        TabGroupIndex: TabGroupIndex,
                        TabGroup: TabGroup,
                        TabButton: TabButton,
                        TabButtonIndex: TabButtonIndex,
                        TabControl: TabControl,
                        TabPanels: TabPanels,
                        TabTransitionSpeed: TabTransitionSpeed,
                };

                if (TabGroupIndex == 0 && TabAutoIndexByHash === null)
                {
                    TabAutoIndexByHash = (window.location.hash.indexOf('#tab=') > -1) 
                        ? Number(new RegExp(/#tab=(\d+){0,}/g).exec(window.location.hash)[1])
                        : 0;
                    
                        console.log('Home Page Tab To Load: ', TabAutoIndexByHash);
                    TabsToggle({
                            TabGroupIndex: TabGroupIndex,
                            TabGroup: TabGroup,
                            TabButton: TabButton,
                            TabButtonIndex: TabButtonIndex,
                            TabControl: TabControl,
                            TabPanels: TabPanels,
                            TabTransitionSpeed: TabTransitionSpeed,
                            TabHashIndex: TabAutoIndexByHash
                    }, null);
                }


                anime({
                    targets: TabGroup,
                    opacity: [TabGroup.style.opacity,1],
                    duration: TabTransitionSpeed,
                    direction: 'forward',
                    loop: false,
                    complete: () => {
                        TabGroup.style.opacity = 1;
                    }
                });

                TabButton.addEventListener('click', TabsToggle.bind(Event, TabGroupData), false);
            });
        
        });
    }

    /*
        JOIN FORM CONTROLLS
    */
    
    let JoinFormFirstName = '';
    let JoinFormEmailAddress = '';
    let JoinFormEmailAddress2 = '';
    let JoinFormHoneyPot = '';
    $: JoinFormResponse = '';
    
    export let ButtonSubmitJoinInstance;

    function ButtonSubmitJoinClickCallback(event)
    {   
        event.stopPropagation();
        event.preventDefault();

        let formFirstName               = document.querySelector('[name=JoinFormFirstName').value;
        let formEmailAddress            = document.querySelector('[name=JoinFormEmailAddress').value;
        let JoinFormEmailAddress2       = document.querySelector('[name=JoinFormEmailAddress2').value;
        let JoinFormHoneyPot            = document.querySelector('[name=JoinFormHoneyPot').value;

        // Don't allow empty return
        if (formFirstName === '' || formEmailAddress === '') return false;

        // Ensure Honeypots are empty;
        if (JoinFormEmailAddress2 !== '' || JoinFormHoneyPot !== '') return false;

        let formEndPointCacheBuster = Math.round(Math.random() * (100000000 - 100000) + 100000);

        let formEndPoint = `https://winery2home.com:8890/wp/wp-json/gf/v2/forms/1/submissions?t=${formEndPointCacheBuster}`;
        
        let formData = new FormData();

        formData.append('input_1', formFirstName);
        formData.append('input_3', formEmailAddress);
        
        let requestOptions = {
            method: 'POST',
            body: formData,
            redirect: 'follow',
            cache: 'no-cache',
            referrerPolicy: 'same-origin',
            // headers: {
            //     // the content type header value is usually auto-set
            //     // depending on the request body
            //     "Content-Type": "text/plain;charset=UTF-8"
            // },
        };

        let result = fetch(formEndPoint, requestOptions)

                        .then(response => response.text())
                        .then(result => {
                            
                            if (JSON.parse(result).is_valid)
                            {
                                JoinFormResponse = $Store.Pages.Home.Tab3.Form.Success;
                            }
                            else
                            {
                                JoinFormResponse = $Store.Pages.Home.Tab3.Form.Error;
                            }
                        })
                        .catch(error => 
                        {
                            JoinFormResponse = $Store.Pages.Home.Tab3.Form.Error;
                        });

    }

    let Products = [];
    let ProductsActive = false;

    onMount((event) =>
    {   
    
        LoaderInitCallback({ 
            LoaderActive: true,
            LoaderType:  'circle',
            LoaderClassColor: '#FFFFFF',
            LoaderOptions: $Store.Pages.Home.Loader,
            LoaderCompleteCallback: (_Data) =>
            {   
                const StoreManager = new StoreManagerClass($Store);

                // Set the Wineries Data if not already set...
                if (_Data.Responses[0].status != 200 || _Data.Responses[0].ok) 
                {   

                    // Load & Store the Wineries List
                    $Store.API.Wineries.List = _Data.Results[1]; console.log('Wineries List', $Store.API.Wineries.List);

                    // Load & Store the featured Products
                    Products = $Store.API.Wineries.Featured = StoreManager.WineriesFilteredByFeaturedSet(_Data.Results[0], true);

                    // Activate the products
                    ProductsActive = true;

                    // Activate Tabs
                    TabsInit();
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
    
    <title>{ $Store.Pages.Home.Title }| { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.Home.Description }">

</svelte:head>

<svelte:window bind:outerWidth={ScreenWidth}/>

<main id="main" class="main main-home">

    <div id="tab-group-1" class="tab-group hidden" role="tablist" aria-label="Winery Products" data-tab-group-id="1">
        
        <ul class="tab-control" data-tab-group-id="1">
            <li class="tab tab-active"><button role="tab"><span><span class="sronly">{$Store.Pages.Home.Tab1.Header.Small} {$Store.Pages.Home.Tab1.Header.Large}</span></span></button></li>
            <li class="tab"><button role="tab"><span><span class="sronly">{$Store.Pages.Home.Tab2.Header.Small} {$Store.Pages.Home.Tab2.Header.Large}</span></span></button></li>
            <li class="tab"><button role="tab"><span><span class="sronly">{$Store.Pages.Home.Tab3.Header.Small} {$Store.Pages.Home.Tab3.Header.Large}</span></span></button></li>
        </ul>

        <div class="tab-panels">
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                <div>
                    <MastheadComponent Id={'id="Test"'} headersmall={$Store.Pages.Home.Tab1.Header.Small} header={$Store.Pages.Home.Tab1.Header.Large} body={$Store.Pages.Home.Tab1.Body}>
                        {#if ScreenWidth >= 768 }
                            <LinkComponent AttributeClass={"button button-wine white-text"} AttributeHref={'/shop'} AttributeTitle={'Shop All Wines'}>Shop All Wines</LinkComponent>
                        {/if}
                    </MastheadComponent>
                </div>
                <div>
                    <MapComponent AttributeClass={'map-home'}></MapComponent>
                    <button id="threejsmap" class="winery">Region Test</button>
                    {#if ScreenWidth <= 767 }
                        <LinkComponent AttributeClass={"button button-wine white-text"} AttributeHref={'/shop'} AttributeTitle={'Shop All Wines'}>Shop All Wines</LinkComponent>
                    {/if}
                </div>
            </div>
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                <div>
                    <MastheadComponent headersmall={$Store.Pages.Home.Tab2.Header.Small} header={$Store.Pages.Home.Tab2.Header.Large} body={$Store.Pages.Home.Tab2.Body}>
                        {#if ScreenWidth >= 768 }
                            <LinkComponent AttributeClass={"button button-wine white-text"} AttributeHref={'/shop'} AttributeTitle={'Shop All Wines'}>Shop All Wines</LinkComponent>
                        {/if}
                    </MastheadComponent>
                </div>
                <div>
                {#if ProductsActive}
                    <ProductsComponent ProductDisplayType={'ProductHome'} ProductsPerView={[1,1]} Products={Products}  AttributeClass={'products-home'}>
                        {#if ScreenWidth <= 767 }
                        <LinkComponent AttributeClass={"button button-wine white-text"} AttributeHref={'/shop'} AttributeTitle={'Shop All Wines'}>Shop All Wines</LinkComponent>
                        {/if}
                    </ProductsComponent>
                {/if}
                </div>
            </div>
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                <MastheadComponent class={''} headersmall={$Store.Pages.Home.Tab3.Header.Small} header={$Store.Pages.Home.Tab3.Header.Large} body={JoinFormResponse} />
                {#if JoinFormResponse == ''}
                <form class="form">
                    <input bind:value={JoinFormFirstName} type="text" name="JoinFormFirstName" id="JoinFormFirstName" required placeholder="First Name*" />
                    <input bind:value={JoinFormEmailAddress} type="email" name="JoinFormEmailAddress" id="JoinFormEmailAddress" required placeholder="Email Address*" />
                    <input bind:value={JoinFormEmailAddress2} type="hidden" name="JoinFormEmailAddress2" id="JoinFormEmailAddress2" class="hidden" />
                    <input bind:value={JoinFormHoneyPot} type="hidden" name="JoinFormHoneyPot" id="JoinFormHoneyPot" class="honeypot" />
                    <br />
                    <ButtonComponent bind:this="{ButtonSubmitJoinInstance}" Callback={ButtonSubmitJoinClickCallback} AttributeClass={'button button-wine submit'} AttributeDataset={''} AttributeTitle={$Store.Pages.Home.Tab3.Form.Label}>{$Store.Pages.Home.Tab3.Form.Label}</ButtonComponent>
                </form>
                {/if}
            </div>
        </div>

        <div class="tab-panels">
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                <ImagePictureComponent
                ImageId={''} 
                ImageClass='responsive-img-cover' 
                ImageSrc={'./lib/images/home-background-mobile-slide-2.jpg'} 
                ImageWidth={'414'} 
                ImageHeight={'896'} 
                ImageTitle={'Image Background'} 
                ImageAlt={'Image Background'} 
                ImageSources={ 
                    [
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-background-mobile-slide-2.jpg, ./lib/images/home-background-mobile-slide-2@2x.jpg 2x', 
                            Media: '(min-width: 0px) and (max-width: 767px)'
                        },
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-background-desktop-slide-2.jpg, ./lib/images/home-background-desktop-slide-2@2x.jpg 2x', 
                            Media: '(min-width: 768px) and (max-width: 10000000px)'
                        },
                    ]
                } />
            </div>
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                <ImagePictureComponent
                ImageId={''} 
                ImageClass='responsive-img-cover' 
                ImageSrc={'./lib/images/home-background-mobile-slide-2.jpg'} 
                ImageWidth={'414'} 
                ImageHeight={'896'} 
                ImageTitle={'Image Background'} 
                ImageAlt={'Image Background'} 
                ImageSources={ 
                    [
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-background-mobile-slide-2.jpg, ./lib/images/home-background-mobile-slide-2@2x.jpg 2x', 
                            Media: '(min-width: 0px) and (max-width: 767px)'
                        },
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-background-desktop-slide-2.jpg, ./lib/images/home-background-desktop-slide-2@2x.jpg 2x', 
                            Media: '(min-width: 768px) and (max-width: 10000000px)'
                        },
                    ]
                } />
            </div>
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                <ImagePictureComponent
                ImageId={''} 
                ImageClass='responsive-img-cover' 
                ImageSrc={'./lib/images/home-background-mobile-slide-3.jpg'} 
                ImageWidth={'414'} 
                ImageHeight={'896'} 
                ImageTitle={'Image Background'} 
                ImageAlt={'Image Background'} 
                ImageSources={ 
                    [
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-background-mobile-slide-3.jpg, ./lib/images/home-background-mobile-slide-3@2x.jpg 2x', 
                            Media: '(min-width: 0px) and (max-width: 767px)'
                        },
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/home-background-desktop-slide-3.jpg, ./lib/images/home-background-desktop-slide-3@2x.jpg 2x', 
                            Media: '(min-width: 768px) and (max-width: 10000000px)'
                        },
                    ]
                } />
            </div>
        </div>

    </div>

</main>


<style global lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;


    .main-home, 
    .tab-group,
    .tab-panels,
    .tab-panel { width: 100%; }

    .main-home, 
    .tab-group,
    .tab-panels,
    .tab-panel { height: 100%; }


    .tab-control,
    .tab-panels,
    .tab-panel { position: absolute; top: 0; left: 0%; }

    .tab-control { z-index: 3; }

    /* Hide scrollbar for Chrome, Safari and Opera */
    .tab-group .tab-panels:first-of-type { z-index: 2; overflow-x: hidden; overflow-y: scroll; overflow-x: hidden; -ms-overflow-style: none;  /* IE and Edge */ scrollbar-width: none;  /* Firefox */ }
    .tab-group .tab-panels:first-of-type::-webkit-scrollbar { display: none; }

    .tab-group.tab-panels:last-of-type { z-index: 1; }

    .tab-control,
    .tab { list-style: none; margin: 0; padding: 0; }

    .tab { position: relative; border-radius: 10px 10px; background: var(--primary-gray); overflow: hidden; }
    
    .tab button { position: absolute; border: none; margin: 0; padding: 0; bottom: 0; left: 0; background: transparent; width: 100%; height: 100%; }

    .tab span { width: 100%; height: 0%; }

    .tab-active span { display: inline-block; background-color: var(--primary-wine); height: 100%; }

    
    

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {  
        .tab-control { top: 45vh; }

        .tab { width: 1.65vw; height: 6vw; margin: 0 4vw 0 8vw; }

        .tab + .tab { margin-top: 2vw; }

        .tab-active { height: 20vw; }

        .tab-panel { text-align: center; }

        .main-home .masthead p  { margin-left: 12vw; margin-right: 12vw; }
        .main-home .form { margin-left: 19vw; margin-right: 19vw; }

    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {  

        .tab-control { top: 25vw; width: auto; }

        .tab-panels:first-of-type .tab-panel { display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 3vw; height: auto; }

        .tab { width: .35vw; height: 1vw; margin: 0 4vw 0 5.15vw; }

        .tab + .tab { margin-top: .5vw; }

        .tab-active { height: 5vw; }

        .tab-panels:first-of-type .tab-panel:last-of-type { display: initial; }

        .tab-panels:first-of-type .tab-panel:last-of-type form { width: 42vw; margin: -1.50vw 0 0 13.25vw; }

    }

</style>