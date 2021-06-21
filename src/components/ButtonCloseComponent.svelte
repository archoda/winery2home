<script>

    /*
        Import
    */
    import { Store } from '../lib/js/store.js';
    import ImageComponent from './ImageComponent.svelte';

    /*
        Exports
    */
    export let AttributeId = 'button-close';
    export let AttributeClass = '';
    export let AttributeDataset = {};
    export let AttributeTitle = '';
    export let Callback;


</script>

<button on:click={Callback} id="{AttributeId}" title="{AttributeTitle}" class="button-close {AttributeClass}" {...AttributeDataset}>
    <ImageComponent ImageClass={['button-close-icon']} ImageSrc={$Store.API.Root + '/lib/images/Button-Close-Circle.svg'} ImageWidth={'400'} ImageHeight={'400'} ImageTitle='Modal Close' ImageAlt='Modal Close Icon' ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />                    
</button>

<style lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    button { margin: 0; padding: 0; border: none; background-color: transparent; }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    { 

    }


</style>