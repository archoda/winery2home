<script>
	import Router from './routes/Index.svelte';
    //import { Store } from './lib/js/store.js';
    
    // let oldHref = '';

	// let htmlBody = document.querySelector("body")
	// let observer = new MutationObserver(
    //     function(mutations)
    //     {

    //         mutations.forEach(function(mutation) {

    //             if (oldHref != document.location.href) {

    //                 oldHref = document.location.href;

    //                 /* Changed ! your code here */
	// 				console.log('page change...');

    //             }

    //         });

    //     }
    // );

    // observer.observe(
    //     htmlBody, 
    //     {
    //         childList: true,
    //         subtree: true
    //     }
    // );

</script>

<Router />

<style>
    
</style>