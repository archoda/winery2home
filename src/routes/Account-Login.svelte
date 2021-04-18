
<script>

    /*
        Imports
    */
	import { transition } from '../lib/js/transition.js';
	import { Store } from '../lib/js/store.js';

    /*
        Exports
    */
    // Used By Svelte-Routing - prevents console log warning
    export let location;

</script>

<svelte:head>
    <title>{ Store.pages.accountlogin.title } | { Store.pages.base.title }</title>
	<meta name="description" property="description" content="{ Store.pages.accountlogin.description }">
</svelte:head>

<main id="main" class="main main-account-login">
    <h1>Account Login</h1>
</main>

<style>
</style>