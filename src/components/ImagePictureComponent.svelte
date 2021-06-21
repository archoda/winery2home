<script>
    export let ImageId = '';
    export let ImageClass = false;
    export let ImageWidth = '';
    export let ImageHeight = '';
    export let ImageTitle = '';
    export let ImageAlt = '';
    export let ImageSrc = '';
    export let ImageSources = [];

</script>

<picture>
    {#each ImageSources as Source, Index}
    <source class="{ImageClass} {Source.Lazy}" media="{Source.Media}" srcset="{Source.Srcset}" />
    {/each}
    <img id="{ImageId}" src="{ImageSrc}" class="responsive-img {ImageClass}" width="{ImageWidth}" height="{ImageHeight}" title="{ImageTitle}"  alt="{ImageAlt}" />
</picture>

<style lang="scss">
    
    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    .responsive-img { width: 100%; height: auto; }

    .responsive-img-cover { width: 100%; height: 100%; object-fit: cover; }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {  
    
    }

    @media (min-width: $mqMinWidthDesktop) and (max-width: $mqMaxWidthDesktop)
    {  
    
    }


</style>