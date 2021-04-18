<script>

    /*
        Imports
    */
    import { onMount } from 'svelte';
    import { Store } from '../lib/js/store.js';

    /*
        Exports
    */
    // Used By Svelte-Routing - prevents console log warning
    export let location;

</script>

<svelte:head>
    <title>{ Store.pages.pagenotfound.title } | { Store.pages.base.title }</title>
	<meta name="description" property="description" content="{ Store.pages.pagenotfound.description }">
</svelte:head>

<main id="main" class="main main-page-nof-found">
    <h1>Page Not Found</h1>
</main>

<style>
	
</style>