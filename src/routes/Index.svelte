<script>
    /* LOOK INTO THIS FOR ROUTING
    https://routify.dev/
    https://easyroute.lyoha.info/page/navigation-guards?lang=en
     */

    /*
        Imports
    */

    import { onMount, getContext, setContext, beforeUpdate, afterUpdate } from 'svelte';
    import { Router, Route } from 'svelte-routing';
    import { Store } from '../lib/js/store.js';
    import StoreManagerClass from '../lib/js/StoreManagerClass.js';
    import anime from 'animejs';
    import { transition } from '../lib/js/transition.js';

    /* 
        Import Page/Routes
    */

    import PageNotFound from './Page-Not-Found.svelte';
    import Home from './Home.svelte';
    import Shop from './Shop.svelte';
    import HowItWorks from './How-It-Works.svelte';
    import AboutUs from './About-Us.svelte';
    import ContactUs from './Contact-Us.svelte';
    import PrivacyPolicy from './Privacy-Policy.svelte';
    import TermsOfService from './Terms-Of-Service.svelte';
    import AgeCheck from './Age-Check.svelte';
    import AgeCheckDenied from './Age-Check-Denied.svelte';

    /*
      Import Components
    */

    import Loader from '../components/Loader.svelte';
    import ModalComponent from '../components/ModalComponent.svelte';
    import ButtonMenu from '../components/Button-Menu.svelte';
    import ButtonComponent from '../components/ButtonComponent.svelte';
    import ButtonCloseComponent from '../components/ButtonCloseComponent.svelte';


    /*
        Exports
    */
    export let url = ''; // Used By Svelte-Routing DO NOT DELETE

    /*
        Store Init 
    */

    let StoreManager = new StoreManagerClass();

    // Set the session host;
    let SessionHost = window.location.protocol + '//' + window.location.hostname + ((window.location.port) ? ':' + window.location.port : ''); 
    console.log(SessionHost = 'https://07cbeb1f6efc.ngrok.io');
    
    // Set the session mode;
    let SessionMode = 'Browser';
    let mqStandAlone = '(display-mode: standalone)';

    if (navigator.standalone || window.matchMedia(mqStandAlone).matches) {
        SessionMode = 'Standalone';
    }

    // Set the session mode on body for css;
    document.querySelector('body').classList.add('session-mode-' + SessionMode.toLowerCase());

    $Store = {
        API: {
            //Root: 'https://fb949a2fb43c.ngrok.io', //SessionHost,
            Root: SessionHost,
            Mode: SessionMode,
            Cache: [],
            Wineries: { 
                List: [],
                All: [], // Filled during session runtime(s)
                Featured: [], // Filled during session runtime(s)
                Filtered: [],
                Maps: 
                [ 
                    /* Source: https://discovercaliforniawines.com/wine-map-winery-directory/ */
                    { 
                        Name: 'California',
                        Active: false,
                        Regions: [
                            { Key: 'CA-NC', Value: 'California, North Coast', Wineries: [] },
                            { Key: 'CA-CC', Value: 'California, Central Coast', Wineries: [] },
                            { Key: 'CA-SF', Value: 'California, Sierra Foothills', Wineries: [] },
                            { Key: 'CA-IV', Value: 'California, Inland Valleys', Wineries: [] },
                            { Key: 'CA-SN', Value: 'California, Southern', Wineries: [] },
                            { Key: 'CA-FN', Value: 'California, Far North', Wineries: [] },
                        ],
                    },
                    { 
                        Name: 'Washington',
                        Active: false,
                        Regions: [
                            { Key: 'WA-NC-Lake', Value: 'Washington, Lake', Wineries: [] },
                        ],
                    },
                    { 
                        Name: 'Oregon',
                        Active: false,
                        Regions: [
                            { Key: 'OR-NC-Lake', Value: 'Oregon, Lake', Wineries: [] },
                        ]
                    }
                ]
            }
        },
        Modal: {
            Class: '',
            Type: '',
            Active: false,
            Toggle: false,
            Data: {},
            Container: {
                Class: ''
            },
            Callback: {
                Init: () => { console.log('Modal Init Callback Called'); },
                Toggle: () => {},
                Close: () => {},
            }
        },
        Pages: {
            Active: 'Home',
            Base: {
                Title: 'Winery2Home.com',
            },
            PageNotFound: {
                Name: 'Page Not Found',
                Slug: 'page-not-found',
                Path: '/page-not-found',
                Title: 'Page Not Found',
                Description: 'We\'re sorry. The page you were looking for was not found.',
            },
            Home: {
                Name: 'Home',
                Slug: 'home',
                Path: '/',
                Title: 'Welcome!',
                Description: 'Home',
                Tab1:
                {
                    Header:
                    {
                        Small: 'Explore The',
                        Large: 'Wineries',
                    },
                    Body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et.'
                },
                Tab2:
                {
                    Header: 
                    {
                        Small: 'Discover Select',
                        Large: 'Wines',
                    },
                    Body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et.'
                },
                Tab3: 
                {
                    Header: 
                    {
                        Small: 'Register For Special',
                        Large: 'Offers',
                    },
                    Body: '',
                    Form: 
                    {
                        Label: 'Register Now',
                        Success: '<p>Thank you for registering. Keep and eye out for great Winery2Home offers coming to your inbox soon!</p>',
                        Error: 'We\'re sorry. Your registration could not be processed at this time - please try again soon.',
                    }
                },
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/0/true'] }, { Url: [SessionHost + '/wp/wp-json/wineries-list/false/']}], // Gets Featured Wines
            },
            Shop: {
                Name: 'Shop',
                Slug: 'shop',
                Path: '/shop',
                Title: 'Shop',
                Description: 'Shop',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/false/true'] }], // Gets All Wines
                LoaderSearch: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/filtered/false/false/false'] }] // Gets Filtered Wines
            },
            HowItWorks: {
                Name: 'How It Works',
                Slug: 'how-it-works',
                Path: '/how-it-works',
                Title: 'How It Works',
                Description: 'How It Works',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/1/false'] }],
            },
            AboutUs: {
                Name: 'About Us',
                Slug: 'about-us',
                Path: '/about-us',
                Title: 'About Us',
                Description: 'About Us',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/1/false'] }],
            },
            ContactUs: {
                Name: 'Conctact Us',
                Slug: 'contact-us',
                Path: '/contact-us',
                Title: 'Contact Us Us',
                Description: 'Contact Us',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/1/false'] }],
            },
            AgeCheck: {
                Name: 'Age Check',
                Slug: 'age-check',
                Path: '/age-check',
                Title: 'Age Check',
                Description: 'To visit our website you must be old enough to purchase and consume alcohol under the laws of your country of residence.',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/1/false'] }],
            },
            AgeCheckDenied: {
                Name: 'Age Check Denied',
                Slug: 'age-check-denied',
                Path: '/age-check-denied',
                Title: 'Age Check Denied',
                Description: 'Your access has been denied due to not being of legal drinking age within your home country.',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/1/false'] }],
            },
            PrivacyPolicy: {
                Name: 'Privacy Policy',
                Slug: 'privacy-policy',
                Path: '/privacy-policy',
                Title: 'Privacy Policy',
                Description: 'Privacy Policy',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/1/false'] }],
            },
            TermsOfService: {
                Name: 'Terms of Service',
                Slug: 'terms-of-service',
                Path: '/terms-of-service',
                Title: 'Terms of Service',
                Description: 'Terms of Service',
                Loader: [{ Url: [SessionHost + '/wp/wp-json/wineries/products/featured/1/false'] }],
            }
        },
        animations: {
            page: {
                transition: {
                    speed: 1000
                }
            }
        },
    };
    
    // Listen for Snipcart ready event
    document.addEventListener('snipcart.ready', () =>
    {
        let SnipcartDelay = setTimeout(() =>
        {
            SnipcartInit();
            clearTimeout(SnipcartDelay);

        }, 1000);
        
    });

    const SnipcartCheckoutCallback = (event) =>
    {
        // Toggle the snipcart view
        if (document.querySelector('.snipcart-cart--opened'))
        {
            Snipcart.api.theme.cart.close()
        } 
        else
        {
            Snipcart.api.theme.cart.open();
            SnipcartCheckoutWindowDetect();
        }
    }

    const SnipcartCheckoutWindowDetect = () =>
    {
        let SnipcartContainer = document.querySelector('.snipcart-modal__container');
        let SnipcartTimeout = null;
        
        if (!SnipcartContainer)
        {
            
            SnipcartTimeout = setInterval( () => {
                
                SnipcartCheckoutWindowDetect();
                clearTimeout(SnipcartTimeout);

            }, 10);
        }
        else
        {
            console.log(SnipcartContainer);
            SnipcartContainer.style.zIndex = 100000;
        }
    }

    const SnipcartInit = () =>
    {

        /* 
            Snipcart Events:
            https://docs.snipcart.com/v3/sdk/events
        */

        Snipcart.events.on('cart.created', async (cartItem) =>
        {   
            // On Mobile - change the header span
            document.querySelector('.snipcart-cart-header .snipcart-modal__header-summary-title span').innerHTML = 'Oder Details';
        });

        Snipcart.events.on('item.updated', async (cartItem) =>
        {
            console.log('Snipcart Event => Item Updated');
        });

        Snipcart.events.on('item.added', async (cartItem) =>
        {
            console.log('Snipcart Event => Item Added');
        });

        Snipcart.events.on('item.removed', async (cartItem) =>
        {
            console.log('Snipcart Event => Item Removed');
        });

        // Snipcart.events.on('cart.reset', (cartState) => 
        // {
        //     console.log('Snipcart Event => Cart Reset');
        //     await ();
        // });

        // Snipcart.events.on('shipping.selected', (shippingMethod) => {
        //     console.log('Snipcart Event => Shipping Selected');
        //     console.log(shippingMethod);
        // });
    }

    /*
         Loader Component Controls
    */

    let LoaderActive = false;
    let LoaderType = null;
    let LoaderClassColor = null;
    let LoaderOptions = null;
    let LoaderCompleteCallback = (data) => {};

    // setInterval(() => { console.log(LoaderActive); }, 1000);
    const LoaderComplete = (event) =>
    {   
        // Pass the results to the caller
        LoaderCompleteCallback(event.detail.data);

        // Show the page elements
        if (!document.querySelector('main').classList.value.indexOf('age-check') > -1)
        {
            anime({
                targets: 'header, .page, footer',
                opacity: [0, 1],
                duration: 250,
                direction: 'forward',
                easing: 'linear',
                loop: false,
                complete: () =>
                {
                    LoaderActive = false;
                }
            });
        }
    }

    const LoaderInitCallback = (_Args) =>
    {
        
        if (_Args.LoaderActive && _Args.LoaderOptions)
        {
            LoaderActive = _Args.LoaderActive;
            LoaderOptions = _Args.LoaderOptions;

            if (_Args.LoaderType) LoaderType = _Args.LoaderType;
            if (_Args.LoaderClassColor) LoaderClassColor = _Args.LoaderClassColor;
            if (_Args.LoaderCompleteCallback) LoaderCompleteCallback = _Args.LoaderCompleteCallback;
        }
    }

    /*
         Modal Component Controls
    */
    
    $: ModalClass = '';
    $: ModalType = '';
    $: ModalActive = false;

    /*
         ButtonMenu Component Controls
    */

    const ButtonMenuInstanceClickCallback = (event) =>
    {  
        NavMainToggle();
    }

    /*
        NavMain Controls
    */
   
    let NavMainActive = false;

    const NavMainToggle = (duration = 250) =>
    {
        
        let NavMain = document.getElementById('nav');

        NavMainActive = !NavMainActive;

        if (NavMainActive)
        {
            anime({
                targets: NavMain,
                opacity: {
                    value: [0, 1],
                    duration: duration,
                    direction: 'forward',
                    easing: 'linear',
                },
                begin: () =>
                {
                    nav.classList.remove('hidden');
                    nav.style.marginLeft = 0;
                },
                loop: false,
            });
        }
        else
        {
            anime({
                targets: NavMain,
                opacity: {
                    value: [1, 0],
                    duration: duration,
                    direction: 'forward',
                    easing: 'linear',
                    delay: 500,
                },
                complete: () =>
                {
                    nav.classList.add('hidden');
                    nav.style.marginLeft = -1000000000 + 'vw';
                },
                loop: false,
            });
        }
    }

    const NavMainLinkClick = (Event) => 
    {

        NavMainToggle();
    }

    onMount(async () =>
    {
        return () => {
            console.log('Home Page UnMount....');
        }
    });

    beforeUpdate(() =>
    {
    //     // Do something...
    //     console.log('BeforeUpdate Index.Svelte Called.....');
    });

    afterUpdate(() =>
    {
    //     // Do something...
    //     console.log('AfterUpdate Index.Svelte Called.....');
    });


</script>


<svelte:head>

    <!-- SNIPCART -->
    <link rel="stylesheet" href="https://cdn.snipcart.com/themes/v3.2.0/default/snipcart.css" />
    <script async src="https://cdn.snipcart.com/themes/v3.2.0/default/snipcart.js"></script>
    <style>

        :root {
            .snipcart-button-primary
            {
                background-color: var(--bgColor-buttonPrimary,#1a4db3);
            }
        }
    </style>
    <!-- HOTJAR -->
	<!-- <script>
		(function(h,o,t,j,a,r){
			h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			h._hjSettings={hjid:1769770,hjsv:6};
			a=o.getElementsByTagName('head')[0];
			r=o.createElement('script');r.async=1;
			r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			a.appendChild(r);
		})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script> -->

	<!-- GOOGLE: Global site tag (gtag.js) - Google Analytics -->
	<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163724990-1"></script>
	<script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-163724990-1');
	</script> -->

    <!-- FLICKITY -->
    <script type="text/javascript" src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="preload stylesheet" as="style" type="text/css" href="https://unpkg.com/swiper/swiper-bundle.min.css">

</svelte:head>

<!-- OnionSkin -->
<!-- <div id="os" class="os">
    <picture>
        <source srcset="./lib/images/_onionskin-home-desktop.png" media="(min-width: 768px)" />
        <source srcset="./lib/images/_onionskin-home-mobile.png" />
        <img src="./lib/images/_onionskin-home-mobile.jpg" alt="onionskin"/>
    </picture>
</div> -->

<ModalComponent />

{#if LoaderActive }
<!-- NAVIGATION: Loader/Transition -->
<Loader LoaderType={LoaderType} LoaderClassColor={LoaderClassColor} LoaderOptions={LoaderOptions} on:message={LoaderComplete} />
{/if}

<!-- NAVIGATION: Button Toggle -->
<ButtonMenu classColor={"#900A4A"} on:click={ButtonMenuInstanceClickCallback} />
<ButtonComponent AttributeId={''} AttributeClass={'snipcart-checkout'} AttributeTitle={'snipcart-checkout'} Callback={SnipcartCheckoutCallback}>Checkout Open <span class="snipcart-items-count"></span></ButtonComponent>



<!-- NAVIGATION: Accessible Skip -->
<a id='nav-skip' class='sronly' href='#main'>
    Skip Navigation or Skip to Content
</a>


<!-- NAVIGATION -->
<nav id="nav" class="nav nav-main hidden" aria-label="main-menu" aria-expanded="false" aria-controls="menu-list" aria-haspopup="false">
    <ButtonCloseComponent  AttributeId={'nav-button-close'} AttributeClass={'nav-close'} AttributeTitle={'Nav Close'} Callback={ () => { NavMainToggle(); } } />
    <ul role="menu">
        <li role="menuitem"><a href="/" tabindex="-1" title="Home" on:click={NavMainLinkClick} use:transition>Home</a></li>
        <li role="menuitem"><a href="/shop" tabindex="-1" title="Shop" on:click={NavMainLinkClick} use:transition>Shop</a></li>
        <li role="menuitem"><a href="/how-it-works" tabindex="-1" title="How It Works" on:click={NavMainLinkClick} use:transition>How It Works</a></li>
        <li role="menuitem"><a href="/about-us" tabindex="-1" title="About Us" on:click={NavMainLinkClick} use:transition>About Us</a></li>
    </ul>
    <ul role="menu">
        <li role="menuitem"><a href="#" tabindex="-1" title="Shopping Cart" class="checkout" on:click={ (Event) => { NavMainToggle(); SnipcartCheckoutCallback(); Event.preventDefault(); Event.stopPropagation(); return false; } }>Shopping Cart</a></li>
        <!-- <li role="menuitem"><a href="/account-login" tabindex="-1" title="Account Login" on:click={NavMainLinkClick}>Account Login</a></li> -->
        <li role="menuitem"><a href="/contact-us" tabindex="-1" title="Contact Us" on:click={NavMainLinkClick} use:transition>Contact Us</a></li>
        <li role="menuitem"><a href="/privacy-policy" tabindex="-1" title="Privacy Policy" on:click={NavMainLinkClick} use:transition>Privacy Policy</a></li>
        <li role="menuitem"><a href="/terms-of-service" tabindex="-1" title="Terms of Service" on:click={NavMainLinkClick} use:transition>Terms of Service</a></li>
        <!-- <li role="menuitem"><a href="/bad-path" tabindex="-1" title="Bad Path" on:click={test}>Bad Path</a></li> -->
    </ul>
</nav>


<!-- HEADER -->
<header id="header" class="header hidden">
    <a href="/" class="logo" title="home" use:transition>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 197.198">
            <g id="W2HLogo" transform="translate(-66.746 -35.695)">
              <g id="LogoText" transform="translate(66.746 125.076)">
                <path id="2" data-name="2" d="M145.074,281.083c11.821,0,16.647,5.946,16.647,13.779,0,5.946-3.147,11.191-13.36,21.753l-9.232,9.652h11.961c4.476,0,5.246-.28,5.945-3.077l.49-4.477c.21-.909.489-1.188,1.539-1.188h3.008c1.049,0,1.119.489.979,1.329L162.07,329.9c-.21,2.169-.77,2.309-2.379,2.309H130.525c-1.049,0-1.4-.28-1.4-1.4v-2.028c0-1.469.56-2.168,2.448-4.057l11.541-12.1c8.6-8.883,10.492-12.94,10.492-17.486,0-4.827-2.309-8.394-8.464-8.394a14.184,14.184,0,0,0-7.694,2.1,4.785,4.785,0,0,1,1.959,4.056,4.9,4.9,0,0,1-5.176,4.967,4.592,4.592,0,0,1-4.686-4.826C129.546,286.119,135.421,281.083,145.074,281.083Z" transform="translate(-92.225 -225.305)" fill="#93014a"/>
                <path id="Winery" d="M89.828,229.6,99.34,188.47c.35-1.469.419-1.679,1.4-1.679h6.015c.979,0,.979.35,1.4,1.749l10.352,39.1,7.973-32.1a8.936,8.936,0,0,0,.35-1.959c0-1.259-.909-1.4-3.778-1.4-.909,0-1.258-.419-1.258-1.259v-2.938c0-1.049.07-1.19,1.539-1.19H137.25c.909,0,1.119.21,1.119,1.259v2.8c0,.7-.07,1.329-1.119,1.329-3.567,0-3.917.14-4.826,3.847L121.863,236.1c-.42,1.539-.63,1.749-2.029,1.749h-5.316c-1.259,0-1.469-.7-1.749-1.749l-9.722-37.77L94.514,236.1c-.35,1.539-.7,1.749-1.749,1.749H85.7c-.909,0-1.4-.28-1.749-1.678L72.9,195.954c-.979-3.567-1.4-3.777-4.336-3.777-1.609,0-1.819-.35-1.819-1.749v-2.448c0-.98.21-1.19,1.189-1.19H84.722c.979,0,1.189.28,1.189,1.19v3.007c0,.77-.21,1.189-1.049,1.189-3.077,0-4.057.07-4.057,1.4a10.684,10.684,0,0,0,.35,2.1Zm53.915-33.24a4.57,4.57,0,0,0,4.729-4.754c0-2.8-1.892-4.69-4.162-4.69-2.585,0-4.6,2.02-4.6,5.015C139.708,194.73,141.473,196.358,143.743,196.358ZM196.372,231.7a13.4,13.4,0,0,1-2.448.35c-1.4,0-2.1-.979-2.1-3.078V211.482c0-8.813-4.826-12.24-11.4-12.24-5.736,0-10.562,2.308-12.52,7.414V201.9c0-1.4-.28-1.959-1.539-1.959l-9.792.56c-1.049.07-1.329.35-1.329,1.329V204.7c0,.839.28,1.259,1.189,1.259,3.917,0,4.476.42,4.476,2.518V228.9c0,2.588-.769,3.008-3.077,3.008h-5.881c-2.308,0-3.077-.42-3.077-3.008v-27c0-1.4-.35-1.959-1.609-1.959l-10.212.629c-.979.07-1.259.209-1.259,1.329v2.588c0,.839.14,1.4,1.259,1.468l2.378.07c1.4.07,1.959.559,2.028,2.028V228.9c0,2.588-.77,3.008-3.078,3.008H136.7c-1.119,0-1.259.28-1.259,1.049v3.078c0,.979.279,1.259,1.259,1.259H173.08c.98,0,1.329-.28,1.329-1.259v-3.078c0-.769-.21-1.049-1.329-1.049H171.4c-2.309,0-3.078-.42-3.078-3.008V220.5c0-9.512,3.217-15.038,9.582-15.038,4.686,0,6.5,2.938,6.5,7.134v17.906c0,5.875,3.777,7.134,6.925,7.134a12.486,12.486,0,0,0,4.9-.629,1.4,1.4,0,0,0,.98-1.469V232.4C197.211,231.7,196.931,231.626,196.372,231.7Zm32.5-20.7c0,6.855-4.546,11.541-14.758,11.541a33.461,33.461,0,0,1-9.232-1.329c.489,7.834,3.846,10.911,11.33,10.911a25.107,25.107,0,0,0,9.373-1.748,10.781,10.781,0,0,1,2.658-1.049c.559,0,.7.28.7.979v3.078c0,.979-.209,1.4-1.4,2.028-2.518,1.329-7.064,2.378-11.96,2.378-13.219,0-18.536-7.624-18.536-18.885,0-11.751,5.875-19.655,17.416-19.655C223.764,199.241,228.87,203.578,228.87,210.992ZM204.88,216.1a36.011,36.011,0,0,0,8.6,1.259c5.456,0,8.534-2.168,8.534-6.435,0-4.2-2.658-6.364-7.554-6.364C209.216,204.558,205.578,207.985,204.88,216.1Zm27.251-10.142c-.909,0-1.19-.419-1.19-1.259v-2.868c0-.979.28-1.259,1.329-1.329l10.142-.56c1.259,0,1.608.56,1.608,1.959v7.344c.98-3.427,4.127-10,11.751-10,5.106,0,7.2,2.8,7.2,6.785a4.508,4.508,0,0,1-4.546,4.616,4.4,4.4,0,0,1-3.917-5.945c-6.715.21-10.492,10.072-10.492,17.486V228.9c0,2.588.77,3.008,3.078,3.008h3.077c1.119,0,1.329.28,1.329,1.049V236.1c0,.909-.28,1.189-1.329,1.189H231.851c-.98,0-1.259-.28-1.259-1.259v-3.078c0-.839.21-1.049,1.259-1.049h1.608c2.308,0,3.148-.56,3.148-3.008V208.474C236.607,206.376,236.048,205.956,232.131,205.956ZM269.368,242.4a4.248,4.248,0,0,1,4.266,4.477,4.635,4.635,0,0,1-2.028,3.847,8.63,8.63,0,0,0,1.4.14c3.077,0,5.6-1.679,7.344-6.715l1.539-4.407L270,209.383c-1.329-3.007-1.539-3.357-3.777-3.357h-.909c-1.049,0-1.259-.629-1.259-1.4V201.76c0-.98.279-1.189,1.259-1.189h15.948c.979,0,1.188.209,1.188,1.259v2.8c0,.7-.279,1.329-1.188,1.329H280c-1.678,0-2.378.14-2.378.98a7.191,7.191,0,0,0,.56,2.1l7.2,20.7,7.414-20.983c.77-2.378.419-2.8-2.1-2.8h-.839c-1.049,0-1.259-.489-1.259-1.259v-2.868c0-1.049.279-1.259,1.259-1.259H304.2c1.049,0,1.259.209,1.259,1.259v2.658c0,.769-.14,1.468-1.189,1.468h-1.4c-1.818,0-2.588.21-3.637,3.217l-12.869,35.6c-2.728,7.694-6.506,9.933-12.591,9.933-4.826,0-8.742-2.8-8.742-7.624C265.031,244.5,266.64,242.4,269.368,242.4Z" transform="translate(-66.746 -186.791)" fill="#93014a"/>
                <path id="Home" d="M243.161,304.67V290.82c0-2.658-.7-3.287-2.937-3.287h-1.609c-1.119,0-1.329-.211-1.329-1.12v-2.937c0-1.119.35-1.329,1.329-1.329h16.927c.979,0,1.259.21,1.259,1.329v2.937c0,.909-.21,1.12-1.259,1.12h-1.679c-2.238,0-2.868.419-2.868,3.287v33.153c0,2.868.77,3.288,3.007,3.288h1.539c1.119,0,1.329.21,1.329,1.049v3.078c0,.909-.28,1.259-1.329,1.259H238.615c-.979,0-1.259-.28-1.259-1.259v-3.078c0-.77.209-1.049,1.259-1.049h1.539c2.238,0,3.007-.629,3.007-3.288V310.055H220.569v13.919c0,2.868.769,3.288,3.007,3.288h1.539c1.189,0,1.329.21,1.329,1.049v3.078c0,.909-.28,1.259-1.329,1.259H208.189c-.979,0-1.259-.28-1.259-1.259v-3.078c0-.77.21-1.049,1.259-1.049h1.539c2.238,0,3.007-.629,3.007-3.288V290.82c0-2.658-.7-3.287-2.938-3.287h-1.609c-1.119,0-1.329-.211-1.329-1.12v-2.937c0-1.119.35-1.329,1.329-1.329h16.927c.98,0,1.259.21,1.259,1.329v2.937c0,.909-.209,1.12-1.259,1.12h-1.678c-2.238,0-2.868.419-2.868,3.287V304.67ZM274.89,294.6c12.731,0,17.766,8.743,17.766,19.444,0,10.632-5.035,19.515-17.766,19.515-12.66,0-17.626-8.883-17.626-19.515C257.265,303.34,262.231,294.6,274.89,294.6Zm-9.862,19.515c0,8.533,2.868,14.129,9.862,14.129,7.064,0,9.933-5.6,9.933-14.129,0-8.6-2.868-14.2-9.933-14.2C267.9,299.913,265.028,305.509,265.028,314.112Zm41.8.49v9.652c0,2.588.56,3.007,2.168,3.007h1.469c1.049,0,1.259.21,1.259,1.049v3.078c0,.979-.28,1.259-1.259,1.259H295.008c-.98,0-1.329-.28-1.329-1.259v-3.078c0-.839.21-1.049,1.329-1.049h1.4c2.169,0,3.008-.56,3.008-3.007V303.83c0-2.1-.56-2.518-4.547-2.518-.909,0-1.119-.419-1.119-1.259v-2.868c0-.979.28-1.259,1.259-1.329l10.142-.56c1.329,0,1.679.56,1.679,1.959v3.217c2.1-4.127,6.3-5.875,11.4-5.875,4.756,0,8.6,2.028,10.142,6.854,2.028-4.826,6.574-6.854,12.171-6.854,6.3,0,10.912,3.427,10.912,12.24v17.486c0,2.1.769,3.077,2.168,3.077a13.463,13.463,0,0,0,2.378-.349c.56-.07.839,0,.839.7V330.9a1.4,1.4,0,0,1-.979,1.469,12.738,12.738,0,0,1-4.9.629c-3.217,0-6.925-1.259-6.925-7.134V307.956c0-4.2-1.678-7.064-5.945-7.064-6.015,0-8.953,4.965-8.953,13.709v9.652c0,2.588.77,3.007,2.938,3.007h1.539c1.049,0,1.259.21,1.259,1.049v3.078c0,.979-.279,1.259-1.259,1.259H318.09c-1.049,0-1.259-.28-1.259-1.259v-3.078c0-.839.14-1.049,1.259-1.049h1.4c1.678,0,2.238-.56,2.238-3.007v-16.3c0-4.2-1.679-7.064-5.946-7.064C309.7,300.893,306.829,305.858,306.829,314.6Zm81.078-8.253c0,6.854-4.547,11.541-14.759,11.541a33.466,33.466,0,0,1-9.232-1.329c.489,7.834,3.847,10.912,11.331,10.912a25.106,25.106,0,0,0,9.373-1.749,10.815,10.815,0,0,1,2.658-1.049c.56,0,.7.28.7.979v3.078c0,.98-.21,1.4-1.4,2.028-2.518,1.329-7.065,2.379-11.96,2.379-13.22,0-18.536-7.624-18.536-18.886,0-11.751,5.875-19.654,17.416-19.654C382.8,294.6,387.906,298.933,387.906,306.348Zm-23.991,5.105a36.019,36.019,0,0,0,8.6,1.259c5.456,0,8.534-2.169,8.534-6.435,0-4.2-2.658-6.365-7.555-6.365C368.251,299.913,364.615,303.34,363.915,311.453Z" transform="translate(-123.976 -225.739)" fill="#93014a"/>
              </g>
              <g id="LogoMark" transform="translate(105.688 35.695)">
                <path id="Bottle" d="M304.2,131.371q-.056,5.773-.111,11.547c-.052,1.826-.51,5.844-2.164,7.646-1.558,1.7-7.421,2.014-11.372,2.011l-21.565-.018-51.165-.041-15.462-.012c-3.348,0-6.887.259-9.663-.679-10.6-3.579-11.711-16.1-21.735-19.047-4.261-1.253-18.239-.86-18.239-.86l-14.127.017-.032-14.633h28.61c4.81,0,7.38-2.309,8.581-3.9.632-.838.2-.994-.981-.428a17.419,17.419,0,0,1-7.407,1.752H138.558l-.008-3.407s15.783-.07,20-.067c4.54,0,9.438.348,13.225-.929,8.656-2.92,10.7-14.748,19.443-18.379A25.953,25.953,0,0,1,199.4,90.46l.383-.02v3.613c-.26,0-1.908.008-3.148.1a11.37,11.37,0,0,0-7.145,2.994c-.473.455-.877.868-1.219,1.239-1.548,1.671-.451,1.214,1.316.524a15.408,15.408,0,0,1,3.767-.8c4.346-.386,6.231-.395,6.231-.395h.2V107.6a9.316,9.316,0,0,0-3.091,7.341,8.986,8.986,0,0,0,8.934,8.838c4.637,0,9.562-3.139,9.562-9.273a8.054,8.054,0,0,0-3.048-6.761l-.053-10.026h78.839s4.622-.035,6.788,2.094c2.608,2.565,2.6.454,2.486-.323-.248-1.629-.263-2.97-1.159-3.912-1.348-1.417-8.623-1.521-8.623-1.521H212.07l-.02-3.721.676,0c22.811-.04,74.523-.021,79.639.3,4.192.259,7.184.084,9.266,2.341C305.013,96.631,304.209,120.919,304.2,131.371ZM134.549,110a1.816,1.816,0,0,0-1.949,1.363c-.039,6.712-.017,20.581-.017,20.581a2.153,2.153,0,0,0,2.156,1.676,2.04,2.04,0,0,0,2.082-1.68l-.15-20.613A2.009,2.009,0,0,0,134.549,110Z" transform="translate(-132.577 -58.005)" fill="#151011"/>
                <path id="Flag" d="M276.567,57.146V35.695h-29.4v50.48a7.436,7.436,0,1,0,8.7.067V57.329Z" transform="translate(-178.101 -35.695)" fill="#93014a" fill-rule="evenodd"/>
              </g>
            </g>
          </svg>          
    </a>
</header>

<!-- MAIN  -->
<Router url="{url}">
    <Route path={$Store.Pages.Home.Path} component={Home} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.Shop.Path} component={Shop} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.Shop.Path + '/*'} component={Shop} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.HowItWorks.Path} component={HowItWorks} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.AboutUs.Path} component={AboutUs} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.ContactUs.Path} component={ContactUs} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.PrivacyPolicy.Path} component={PrivacyPolicy} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.TermsOfService.Path} component={TermsOfService} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.AgeCheck.Path} component={AgeCheck} LoaderInitCallback={LoaderInitCallback} />
    <Route path={$Store.Pages.AgeCheckDenied.Path} component={AgeCheckDenied} LoaderInitCallback={LoaderInitCallback} />
    <Route component={PageNotFound} />
</Router>

<!-- FOOTER -->
<footer id="footer" class="footer hidden">
    <p>
        <a href="/privacy-policy" title="Do Not Sell My Personal Information" use:transition><strong>Do Not Sell My Personal Information</strong></a>
        <br />@Copyright 2021. All Rights Reserved. Winery2Home, LLC.
    </p>
</footer>

<!-- SNIPCART -->
<!-- data-cart-custom1-name="Confirm you're of legal age to purchace alcohol?"
    data-cart-custom1-options="true|false"
    data-cart-custom1-required="true" -->
<div class="snipcart-wrapper-checkout">
    <div id="snipcart" data-config-modal-style="full" data-api-key="OTdhZmI1OGEtNmE1Ny00NWEwLTgwNDUtZDlkZjdmYzUyMWUwNjM3NTA0ODYxMTExODQ3MDE4" hidden >
        <payment section="top">
            <fieldset class="snipcart-form__set">
                <div class="snipcart-form__field">
                    <div class="snipcart-form__field-checkbox">
                        <snipcart-checkbox name="ageConsentConfirm" required></snipcart-checkbox>
                        <snipcart-label for="ageConsentConfirm" class="snipcart__font--tiny snipcart-form__label--checkbox">
                            I confirm, I am of legal drinking age.
                        </snipcart-label>
                    </div>
                </div>
            </fieldset>
        </payment>
    </div>
</div>

<style global lang="scss">

    /*
        GLOBAL VARS
    */
    
    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    :root {

        --primary-white: rgba( 255, 255, 255, 1 ); /* #FFFFFF; */

        --primary-black: rgba( 0, 0, 0, 1 ); /* #000000; */

        --primary-gray: rgba( 173, 171, 163, 1 ); /* #ADABA3; */

        --primary-tan: rgba( 245, 242, 231, 1 ); /* #F5F2E7; */
        --primary-tan-medium: rgba( 237, 234, 223, 1 ); /* #EDEADF; */
        --primary-tan-dark: rgba( 198, 193, 178, 1 ); /* #C6C1B2; */

        --primary-wine-light: rgba( 190, 98, 144, 1 ); /* #BE6290 */
        --primary-wine: rgba( 144, 10, 74 , 1 ); /* #900A4A */
        --primary-wine-dark: rgba( 72 , 5, 37, 1 ); /* #480525 */


        /* https://docs.snipcart.com/v3/setup/theming */

        /* 
            SNIPCART MODAL
        */

        --bgColor-modal: var(--primary-tan);
        --bgColor-modalVeil: var(--primary-tan);
        .snipcart-cart-summary { background-color: var(--primary-tan); }

        /* 
            SNIPCART TEXT COLORS
        */

        // --color-default: var(--primary-tan-dark); 
        --color-alt: var(--primary-tan-dark);
        --color-icon: var(--primary-wine);

        /* 
            SNIPCART COLOR: LINKS
        */
        --color-link: var(--primary-wine);
        --color-link-hover: var(--primary-wine-dark);
        --color-link-active: var(--color-link);
        --color-link-focus: var(--color-link);
        
        /* 
            SNIPCART COLORS: SECONDARY
        */

        --color-buttonSecondary: var(--primary-wine);
        --color-buttonSecondary-hover: var(--color-buttonSecondary);
        --color-buttonSecondary-active: var(--color-buttonSecondary);
        --color-buttonSecondary-focus: var(--color-buttonSecondary);

        /* 
            SNIPCART BUTTON COLORS: PRIMARY
        */

        --bgColor-buttonPrimary: var(--primary-wine);
        
        /* 
            SNIPCART BUTTON COLORS: SECONDARY
        */
        --bgColor-info: var(--primary-tan-medium);
        --bgColor-buttonSecondary: var(--bgColor-info);
        --bgColor-buttonSecondary-hover: var(--bgColor-info);
        --bgColor-buttonSecondary-active: var(--bgColor-info);
        --bgColor-buttonSecondary-focus: var(--bgColor-info);
        
        
        /* 
            SNIPCART BORDER COLORS: INPUT
        */
        --borderColor-input-hover: var(--primary-wine);
        --borderColor-input-focus: var(--borderColor-input-hover);
        --borderColor-input-checked: var(--borderColor-input-hover);

        /*
            SNIPCART BADGE COLORS: BORDER
        */

        /* Default (completed) */
        --color-badge: var(--primary-wine);
        --borderColor-badge: var(--primary-white);
        --bgColor-badge: var(--primary-white);

        /* Active */
        --color-badge-active: var(--primary-white);
        --borderColor-badge-active: var(--primary-wine);
        --bgColor-badge-active: var(--primary-wine);

        /* Disabled */
        --color-badge-disabled: var(--primary-tan-dark);
        --borderColor-badge-disabled: var(--primary-tan-dark);
        --bgColor-badge-disabled: var(--primary-tan);

        /*
            SNIPCART INPUT
        */

        --bgColor-input: var(--primary-white);
        --bgColor-input-hover: var(--bgColor-input);
        --bgColor-input-focus: var(--bgColor-input);
        --bgColor-input-checked: var(--primary-wine);
        --bgColor-input-autofill: var(--primary-white);
        --color-input-checked: var(--primary-white);

    }

    /*
        GLOBAL RESETS
    */

    *,
    *::before,
    *::after { box-sizing: border-box; }

    html, body { width: 100%; height: 100%; margin: 0; border: 0; padding: 0; }

    html { font-family: 'Domine', 'Arial', 'Helvetica', sans-serif; color: var(--primary-black); background-color: var(--primary-tan); }
    
    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {   
        html { font-size: 3.5vw; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {   
        html { font-size: .85vw; }
    }

    body { overflow: hidden; }

    .hidden { opacity: 0; }
    .hidden-collapsed { opacity: 0; display: none; }
    .honeypot { display: none; position: fixed; top: -10000000; left: -1000000000; }
    
    /*
        GLOBAL SCREEN READER TEXT
    */

    .sronly { position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden; }
    .sronly:focus { color: black; display: inline-block; height: auto; width: auto; position: static; margin: auto; }

    /*
        GLOBAL FONTS
    */

    @font-face {
        font-family: 'Domine';
        src: url('../fonts/Domine/Domine-VariableFont_wght.ttf') format('truetype');
        /*font-display: swap;*/
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('../fonts/Montserrat/Montserrat-Medium.ttf') format('truetype');
        font-weight: 500;
        /*font-display: swap;*/
    }

    @font-face {
        font-family: 'Montserrat-Light';
        src: url('../fonts/Montserrat/Montserrat-Light.ttf') format('truetype');
        font-weight: 300;
        /*font-display: swap;*/
    }

    a, abbr, acronym, address, area, article, aside, b, blockquote, body, 
    button, caption, cite, code, col, colgroup, data, datalist, dd, del, 
    details, dfn, dialog, div, dl, dt, em, fieldset, figcaption, figure, footer,
    form, header, input, ins, kbd, label, legend, li, main, mark, meter, nav, 
    ol, optgroup, option, output, p, param, pre, progress, q, rp, rt, ruby,
    s, samp, section, select, small, span, strong, sub, summary, sup, textarea,
    track, u, ul, var, wbr { 
        font-variation-settings: 'wght' 400; 
        line-height: 1.45; 
    }

    *:not(p) { line-height: 1.10; }

    h1,h2 { margin: 0; padding: 0; color: var(--primary-wine); }

    h1,h2,h3,
    h1 *,h2 *, h3 * { font-family: 'Domine', 'Arial', 'Helvetica', sans-serif; font-variation-settings: 'wght' 500; }

    h4,h5,h6 { font-variation-settings: 'wght' 400 !important; }
    
    
    * *:last-of-type:is(p) { padding-bottom: 0; }

    a, a:active, a:visited, a:focus { color: var(--primary-black); text-decoration: none; border: none; outline: none; outline-style: none; -moz-outline-style: none; }

    a.wine-text, a.wine-text:active, a.wine-text:visited, a.wine-text:focus { color: var(--primary-wine); }

    a.white-text, a.white-text:active, a.white-text:visited, a.white-text:focus { color: var(--primary-white); }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {   
        p,
        ul,
        *:not(div) + a,
        *:not(div) + p,
        *:not(div) + ul,
        *:not(div) + li { margin: 2.5vw 0 0; }

        h2,
        h2 *:not(div) { font-size: 4vw; margin: 0; }
        *:not(div) + h2 { margin: 8vw 0 0; }
        // h2 + *:not(div) { margin-top: 2.5vw; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {

        // *:not(strong) {  font-size: 1vw; margin: 0; }

        // * + p { margin: 1.5vw 0 0; }

        // h2 { font-size: 1.5vw; margin: 0; }
        // * + h2 { margin: 2vw 0 0; }
        // h2 + * { margin-top: 1.5vw; }
    }

    /*
        GLOBAL SNIPCART
    */
    
    .snipcart-wrapper-checkout { position: absolute; z-index: 90; top: 0; right: 0; }
    .snipcart-cart-header .snipcart-cart-header__icon:nth-child(1),
    .snipcart-cart-header .snipcart-modal__close-icon,
    .snipcart-cart-header .snipcart-cart-header__count { display: none; }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {
        .snipcart-cart-header .snipcart-modal__header-summary-title { margin-right: 19vw; }
        .snipcart-cart-header .snipcart-modal__header-summary-title span { content: "Order Summary"; }
    }

    /*
        GLOBAL HEADER
    */

    header { z-index: 10; position: absolute; left: 0; top: 0; }

    header .logo,
    header .logo svg { height: auto; }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {
        header .logo svg { width: 18vw; margin: 4.5vw 0 0 5vw; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {
        header .logo svg { width: 8vw; margin: 2vw 0 0 3.25vw; }
    }
    

    /*
        GLOBAL FOOTER
    */
    
    .footer { position: fixed; z-index: 3; width: 100%; text-align: center; }
    

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {
        .footer { bottom: -1vw; } 

        .footer *:not(a),
        .footer a, .footer a * { font-size: 2.5vw; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {
        .footer { bottom: 0; } 

        .footer *:not(a),
        .footer a, .footer a * { font-size: .75vw; }
    }

    /*
        GLOBAL NAV
    */

    #nav { z-index: 2000; position: fixed; top: 0; left: 0; margin-left: -100000000vw; display: flex; width: 100%; height: 100%; background-color: var(--primary-tan); align-items: center; justify-content: center; flex-flow: column; }

    #nav ul,
    #nav ul li { width: 100%; margin: 0; border: 0; padding: 0; text-align: center; list-style: none; }

    .nav-close { position: absolute; top: 4vw; right: 4vw; }

    #nav ul:first-of-type li * { font-variation-settings: 'wght' 500; color: var(--primary-wine); }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {

        #nav ul:first-of-type li + li { margin-top: 4vw; }

        #nav ul:first-of-type li * { font-size: 8vw; }

        #nav ul:last-of-type { margin-top: 8vw; }

        #nav ul:last-of-type li + li { margin-top: 2.35vw; }

        #nav ul:last-of-type li * { font-size: 5.15vw; color: var(--primary-black); }

        // #nav ul:last-of-type li:nth-of-type(3),
        // #nav ul:last-of-type li:last-of-type { margin-top: 8vw; }

    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {   

        #nav { display: grid; grid-template-columns: 1fr 1fr; }

        .nav-close { top: 1.5vw; right: 2vw; width: 4vw; grid-column: 1/span 2; }

        #nav ul:first-of-type { padding-left: 26vw; }
        #nav ul:last-of-type { padding-right: 26vw; }

        #nav ul:first-of-type li + li { margin-top: 1vw; }

        #nav ul:first-of-type li * { font-size: 3vw; }

        #nav ul:last-of-type li * { font-size: 1vw; color: var(--primary-black);  margin: .25vw 0; display: inline-block; }

        // #nav ul:last-of-type li:nth-of-type(3),
        // #nav ul:last-of-type li:last-of-type { margin-top: 1.5vw; }

    }

    /*
        GLOBAL FORMS
    */

    .form input,
    .form textarea {
        -webkit-appearance: none;
    }

    .form input,
    .form textarea { font-family: "Montserrat-Light", "Arial", "Helvetica", sans-serif; width: 100%; background-color: var(--primary-tan); border: 2px solid var(--primary-tan-dark); }

    .form input:focus,
    .form textarea:focus { outline: none; border: 2px solid var(--primary-wine); }
    
    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {   
        // .form { margin: 0 19vw; }

        .form input,
        .form textarea { font-size: 4vw; text-align: center; padding: 1.25vw 2vw;  }

        .form * + input,
        .form * + textarea { margin-top: 2vw; }

        .form button { margin-top: 2vw; }
    }


    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {   
        // .form { margin: -2vw 22vw 0; }

        .form input { font-size: 1.25vw; padding: .5vw .5vw; width: 14vw; }

        .form input + input { margin-top: 2vw; }

        .form button { margin-top: 1vw; }
    }

    /*
        GLOBAL MAIN
    */

    #main { position:relative; width: 100%; height: 100%; display: flex; align-items: center; justify-content: start; flex-flow: column; transform-style: preserve-3d; -webkit-transform-style: preserve-3d; }

    button,
    .button { cursor: pointer; border: none; font-family: 'Montserrat-Medium', 'Arial', 'Helvetica', sans-serif; color: var(--primary-black); text-align: center; text-transform: uppercase; background-color: transparent }

    .button-wine { background-color: var(--primary-wine); color: var(--primary-white); }


    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {   
        .main { padding: 0 12vw 0; }

        .main ul { text-align: left; }

        .main * + ul { margin-top: 2.5vw; }

        .main ul li + li { margin-top: 1.5vw; }

        .button { font-size: 3.85vw; padding: 2vw 4.75vw; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {   
        // .main { text-align: left; padding: 0 4vw 0vw; overflow: scroll; }

        .button { font-size: 1.2vw; padding: 0.5vw 1.25vw; }
    }

    /* 
        GLOBAL MODAL   
    */
    
    .modal { }

    /*
        GLOBAL PRODUCTS
    */

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    { 
        

    }

</style>