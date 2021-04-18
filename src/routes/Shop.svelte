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
    <title>{ Store.pages.shop.title } | { Store.pages.base.title }</title>
	<meta name="description" property="description" content="{ Store.pages.shop.description }">
</svelte:head>

<main id="main" class="main main-shop">
    <Masthead class={""} headersmall={"Shop The"} header={"Wineries"} body={""} />
</main>

<style>
	
</style>