<script>
    /*
        DOCS 
        ---------------------
        https://www.w3schools.com/tags/tag_a.asp
    */
    
    
    /*
        Import
    */
    import { onMount, createEventDispatcher } from 'svelte';
    import { transition } from '../lib/js/transition.js';

    /*
        Exports
    */
    export let AttributeId = null;
    export let AttributeClass = null;
    export let AttributeTitle = null;
    export let AttributeDataset = {};
    export let AttributeHref = null;
    export let AttributeTarget = '_self';

    export let AttributeHrefLang = null; // Must supply key=value pair string
    export let AttributeType = null; // Must supply key=value pair string
    export let AttributeMedia = null; // Must supply key=value pair string
    export let AttributePing = null; // Must supply key=value pair string
    export let AttributeRefererPolicy = null; // Must supply key=value pair string
    export let AttributeRel = null; // Must supply key=value pair string

    export let Callback = () => {};
    
</script>

<a href="{AttributeHref}" use:transition target="{AttributeTarget}" {AttributeId} class="{AttributeClass}" {...AttributeDataset} title="{AttributeTitle}" {AttributeHrefLang} {AttributeType} {AttributeMedia} {AttributePing} {AttributeRefererPolicy} {AttributeRel}>
    <slot />
</a>

<style lang="scss">
    
</style>