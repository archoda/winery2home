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
    <title>{ Store.pages.agecheckdenied.title } | { Store.pages.base.title }</title>
	<meta name="description" property="description" content="{ Store.pages.agecheckdenied.description }">
</svelte:head>

<main id="main" class="main main-account-login">
    <Masthead class={"slide hidden"} headersmall={"Website Access"} header={"Denied"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."} />
   
</main>

<style>
	
</style>