<script>

    /*
        Imports
    */
    import { onMount } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import { transition } from '../lib/js/transition.js';
    import anime from 'animejs';

    import Masthead from '../components/MastheadComponent.svelte';
    
    /*
        Exports
    */

</script>

<svelte:head>
    <title>{ $Store.Pages.HowItWorks.Title } | { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.HowItWorks.Description }">
</svelte:head>

<main id="main" class="main main-how-it-works">
    <Masthead class={"slide hidden"} headersmall={"How It"} header={"Works"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."} />
</main>

<style>
</style>