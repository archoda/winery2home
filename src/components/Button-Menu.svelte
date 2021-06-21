<script>

    /*
        Import
    */
    import { onMount, createEventDispatcher } from 'svelte';

    /*
        Exports
    */
    export let classColor = null;

    const ButtonMenuInstanceClickCallback = createEventDispatcher();

    const ButtonMenuClick = () =>
    {
        ButtonMenuInstanceClickCallback('click', { data: {} });
    }

</script>

<button on:click={ButtonMenuClick} id="button-menu" class="button-menu" title="Open Menu">
    <svg id="button-menu-icon" viewBox="0 0 254 7">
        <line class="button-menu-line" x1="0" y1="0" x2="450" y2="0" stroke="{classColor}" />
        <line class="button-menu-line" x1="0" y1="0" x2="450" y2="0" stroke="{classColor}" />
        <path id="button-menu-circle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="{classColor}" stroke="{classColor}" />
    </svg>
</button>

<style lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    #button-menu { z-index: 2000; top: 4vw; right: 4vw; border: none; background-color: transparent; overflow: hidden; }

    #button-menu,
    #button-menu-icon { position: absolute; }

    // #button-menu-icon { transform: translate(-50%, -50%); }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    { 
        #button-menu,
        #button-menu-icon { width: 5.5vw; height: 5.5vw; }


        #button-menu-icon { position: relative; }

        #button-menu-icon * { position: absolute; }
        
        .button-menu-line { stroke-width: 5vw; }
    }

</style>