<script>
    /*
        Imports
    */
    import { writable, readable } from 'svelte/store';

    /*
        Exports
    */
    export let Class = '';
    export let Id;
    export let headersmall
    export let header
    export let body
</script>

<section if:id={Id} class="masthead {Class}">
    <h1><span class="small">{headersmall}</span><span>{header}</span></h1>
    <p>{body}</p>
</section>

<style lang="scss">

    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    /*
        -- MASTHEAD
    */

    .masthead { position: absolute; }
    .masthead h1, .masthead h1 * { color: var(--primary-wine); }
    .masthead h1 span { display: block; }
    .masthead h1 span:not(.small) { text-transform: uppercase; }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {   
        p { font-size: 3.15vw; }

        .masthead { text-align: center;}
        .masthead h1 span.small { font-size: 6vw; }
        .masthead h1 span:not(.small) { font-size: 14.5vw; margin: 0; }
        .masthead p { margin: -3.85vw 13vw 0; }
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {
        .masthead h1 span.small { font-size: 6vw; }
        .masthead h1 span:not(.small) { font-size: 14.5vw; }
    }
</style>