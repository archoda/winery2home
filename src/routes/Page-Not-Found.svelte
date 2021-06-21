<script>

    /*
        Imports
    */
    import { onMount } from 'svelte';
    import { Store } from '../lib/js/store.js';

    /*
        Exports
    */

</script>

<svelte:head>
    <title>{ $Store.Pages.PageNotFound.Title } | { $Store.Pages.Base.Title }</title>
	<meta name="description" property="description" content="{ $Store.Pages.PageNotFound.DescriptionTitle }">
</svelte:head>

<main id="main" class="main main-page-nof-found">
    <h1>Page Not Found</h1>
</main>

<style>
	
</style>