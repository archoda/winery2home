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
    import ButtonComponent from '../components/ButtonComponent.svelte';
    
    /*
        Exports
    */
    export let LoaderInitCallback;
   

    /*
        JOIN FORM CONTROLLS
    */

    let ContactUsFormFirstName = '';
    let ContactUsFormEmailAddress = '';
    let ContactUsFormMessage = '';
    let ContactUsFormMessage2 = '';
    let ContactUsFormHoneyPot = '';
    $: ContactUsFormResponse = '';
    export let ButtonSubmitContacUsInstance;

    function ButtonSubmitContacUsClickCallback(detail)
    {
        let ContactUsFormFirstName      = document.querySelector('[name=ContactUsFormFirstName').value;
        let ContactUsFormEmailAddress   = document.querySelector('[name=ContactUsFormEmailAddress').value;
        let ContactUsFormMessage        = document.querySelector('[name=ContactUsFormMessage').value;
        let ContactUsFormMessage2       = document.querySelector('[name=ContactUsFormMessage2').value;
        let ContactUsFormHoneyPot       = document.querySelector('[name=ContactUsFormHoneyPot').value;

        // Don't allow empty return
        if (ContactUsFormFirstName === '' || ContactUsFormEmailAddress === '') return false;

        // Ensure Honeypots are empty;
        if (ContactUsFormMessage2 !== '' || ContactUsFormHoneyPot !== '') return false;

        let formEndPointCacheBuster = Math.round(Math.random() * (100000000 - 100000) + 100000);

        let formEndPoint = `https://winery2home.com:8890/wp/wp-json/gf/v2/forms/2/submissions?t=${formEndPointCacheBuster}`;
        
        let formData = new FormData();

        formData.append('input_2.3', ContactUsFormFirstName);
        formData.append('input_3', ContactUsFormEmailAddress);
        formData.append('input_4', ContactUsFormEmailAddress);
        
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
                        // .then(result => console.log(result))
                        // .catch(error => console.log('error', error));
                        .then(result => {
                            
                            if (JSON.parse(result).is_valid)
                            {
                                ContactUsFormResponse = $Store.Pages.ContactUs.Form.Success;
                            }
                            else
                            {
                                ContactUsFormResponse = $Store.Pages.ContactUs.Form.Error;
                            }
                        })
                        .catch(error => 
                        {
                            ContactUsFormResponse = $Store.Pages.ContactUs.Form.Error;
                        });
    }


    onMount((event) =>
    {   
    
        LoaderInitCallback({ 
                LoaderActive: true,
                LoaderType:  'circle',
                LoaderClassColor: '#FFFFFF',
                LoaderOptions: $Store.Pages.ContactUs.Loader,
                LoaderCompleteCallback: (_Data) =>
                {   
                    const StoreManager = new StoreManagerClass($Store);

                    console.log(_Data);
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
    <title>{ $Store.Pages.ContactUs.Title } | { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.ContactUs.Description }">
</svelte:head>

<main id="main" class="main main-contact-us">
    <MastheadComponent class={"slide hidden"} headersmall={"Have Something To"} header={"Tell Us?"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."}>
        {#if ContactUsFormResponse === '' }
        <div class="form">
            <input bind:value={ContactUsFormFirstName} id="ContactUsFormFirstName" name="ContactUsFormFirstName" title="First Name" placeholder="First Name" />
            <input bind:value={ContactUsFormEmailAddress} id="ContactUsFormEmailAddress" name="ContactUsFormEmailAddress" title="Email Address" placeholder="Email Address" />
            <textarea bind:value={ContactUsFormMessage} id="ContactUsFormFormMessage" name="ContactUsFormMessage" title="Your Message" placeholder="Your Message Here"></textarea>
            <input bind:value={ContactUsFormMessage2} id="ContactUsFormMessage2" name="ContactUsFormMessage2" hidden />
            <input bind:value={ContactUsFormHoneyPot} id="ContactUsFormHoneyPot" name="ContactUsFormHoneyPot" class="honeypot" />
            <ButtonComponent AttributeClass="button button-wine submit" AttributeTitle="Send Message" bind:this="{ButtonSubmitContacUsInstance}" Callback={ButtonSubmitContacUsClickCallback}>Send Message</ButtonComponent>
        </div>
        {:else}
            {@html ContactUsFormResponse}
        {/if}
    </MastheadComponent>
</main>

<style global lang="scss">

    $mqMinWidthMobile: 0px; 
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;


    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    { 
        .main-contact-us .form { margin: 4vw 7vw; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    { 
        // .main-contact-us .form { margin: 2vw; }
    }
</style>