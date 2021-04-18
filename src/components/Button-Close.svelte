<script>

    /*
        Import
    */
    import { onMount, createEventDispatcher } from 'svelte';

    /*
        Exports
    */
    export let classColor = null;

    const ButtonClickCallback = createEventDispatcher();

    const ButtonCloseClick = () =>
    {
        ButtonClickCallback('click', { data: {} });
    }

</script>

<!-- <button on:click={ButtonCloseClick} id="button-close" title="Close" class="button-close hidden">
    <svg id="button-close-circle-solid" viewBox="0 0 36 36">
        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="{classColor}" stroke="{classColor}" />
    </svg>
    <svg id="button-close-circle-line" viewBox="0 0 36 36">
        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{classColor}" stroke-width=".45" />
    </svg>
</button> -->

<style lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    #button-close { z-index: 20000000; top: 4vw; right: 4vw; border: none; background-color: transparent; }

    #button-close,
    #button-close-circle-solid,
    #button-close-circle-line { position: absolute; }

    #button-close-circle-solid,
    #button-close-circle-line { transform: translate(-50%, -50%); }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    { 
        #button-close,
        #button-close-circle-solid,
        #button-close-circle-line { width: 5.5vw; height: 5.5vw; }
    }


</style>