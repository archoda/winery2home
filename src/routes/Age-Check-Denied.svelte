<script>
    
     /*
        Imports
    */
    import { onMount } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import StoreManagerClass from '../lib/js/StoreManagerClass.js';
    import { transition } from '../lib/js/transition.js';
    import anime from 'animejs';


    import MastheadComponent from '../components/MastheadComponent.svelte';
    
    /*
        Exports
    */
    export let LoaderInitCallback;

    onMount((event) =>
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
    <title>{ $Store.Pages.AgeCheckDenied.Title } | { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.AgeCheckDenied.Description }">
</svelte:head>

<main id="main" class="main main-account-login">
    <MastheadComponent Class={''} headersmall={"Website Access"} header={"Denied"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."} />
</main>

<style>
	
</style>