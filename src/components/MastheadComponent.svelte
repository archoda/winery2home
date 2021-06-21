<script>
    /*
        Imports
    */

    /*
        Exports
    */
    export let Class = '';
    export let Id = '';
    export let headersmall
    export let header
    export let body
    export let Reverse;

</script>

<div {Id} class="masthead {Class}">
    {#if Reverse }
        <h1>
            <span class="large">{@html header}</span>
            <span class="small">{@html headersmall}</span>
        </h1>
    {:else}
        <h1>
            <span class="small">{@html headersmall}</span>
            <span class="large">{@html header}</span>
        </h1>
    {/if}
    {#if body}
    <p>{@html body}</p>
    {/if}
    <slot />
</div>

<style global lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    /*
        -- MASTHEAD
    */

    //.masthead { position: absolute; }
    h1, h1 span { display: block; color: var(--primary-wine); }
    .large { text-transform: uppercase; }
    .button { display: inline-block; }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {   
        .masthead { text-align: center; padding: 12.5vh 0 0; }

        .large { font-size: 14.5vw; }
        .small { font-size: 6vw; }
        
        .large + .small { margin: -2vw 0 0; }
        .small + .large { margin: -1vw 0 0; }

        .masthead *+p { margin: -.05vw 0 0; }

        .reverse p { margin-top: 2.05vw; }

        .button { margin: 5vw 0 10vw; }


        /*
            MODAL WINERY DETAILS MASTHEAD
        */

        .winery-details { padding: 0; }
        .winery-details h1 { margin-bottom: 8vw; }
        .winery-details .large { font-size: 12vw; }
        .winery-details .small { font-size: 4.5vw; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {
        .masthead { padding: 21.75vw 0 0 13.25vw; width: 100%; height: auto; }

        h1 { margin: 0; padding: 0; }
        h1 .small { font-size: 3vw; }
        h1 .large { font-size: 6.5vw; margin: -.55vw 0 0; }
        
        .masthead *+p { width: 70%; margin: 0 26vw 0 0; }

        .reverse p { margin-top: 1.5vw; }

        .button { margin: 2vw 0; }

        .center { text-align: center; padding: 11.35vw 0 0 0vw; }
    }
</style>