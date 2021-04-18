<script>
    
    /*
        Imports
    */
	import { transition } from '../lib/js/transition.js';
	import { Store } from '../lib/js/store.js';

    import Masthead from '../components/Masthead.svelte';

    /*
        Exports
    */
    // Used By Svelte-Routing - prevents console log warning
    export let location;

</script>

<svelte:head>
    <title>{ Store.pages.aboutus.title } | { Store.pages.base.title }</title>
	<meta name="description" property="description" content="{ Store.pages.aboutus.description }">
</svelte:head>

<main id="main" class="main main-about-us">
    
    <Masthead class={"slide hidden"} headersmall={"Get To Know Who"} header={"We Are"} body={"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat."} />
    
</main>

<style global lang="scss">

</style>