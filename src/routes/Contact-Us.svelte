<script>

    /*
        Imports
    */
    import { onMount } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import { transition } from '../lib/js/transition.js';
    import anime from 'animejs';

    import Masthead from '../components/Masthead.svelte';

    /*
        Exports
    */
    // Used By Svelte-Routing - prevents console log warning
    export let location;

</script>

<svelte:head>
    <title>{ Store.pages.contactus.title } | { Store.pages.base.title }</title>
	<meta name="description" property="description" content="{ Store.pages.contactus.description }">
</svelte:head>

<main id="main" class="main main-contact-us">
    <Masthead class={"slide hidden"} headersmall={"Have Something To"} header={"Tell Us?"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."} />
    <input id="firstName" class="firstName" name="firstName" title="First Name" placeholder="First Name" value="" />
    <input id="emailAddress" class="emailAddress" name="emailAddress" title="Email Address" placeholder="First Name" value="" />
    <textarea id="message" class="message" name="message" title="Your Message" placeholder="Your Message"></textarea>
</main>

<style>
	
</style>