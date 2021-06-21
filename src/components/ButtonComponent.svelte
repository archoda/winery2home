<script>
    /*
        Import
    */
    import { onMount, afterUpdate, beforeUpdate, createEventDispatcher } from 'svelte';

    /*
        Exports
    */
    export let AttributeId = null;
    export let AttributeClass = null;
    export let AttributeTitle = null;
    export let AttributeDataset = {};
    export let Callback = null;
    
</script>

<button on:click={Callback} {AttributeId} class="{AttributeClass}" {...AttributeDataset} title="{AttributeTitle}"><slot /></button>

<style lang="scss">
    
</style>