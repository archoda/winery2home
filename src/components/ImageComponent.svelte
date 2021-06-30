<script>
    export let ImageId = '';
    export let ImageClass = [];
    export let ImageWidth = '';
    export let ImageHeight = '';
    export let ImageTitle = '';
    export let ImageAlt = '';
    export let ImageSrc = '';
    export let ImageSources = [
		{ Lazy: false, Srcset: ['source1.jpg, source2x.jpg 2x'], Media: '(max-width: 799px)' },
	];

</script>


<img src="{ImageSrc}" class="responsive-img {[...ImageClass]}" width="{ImageWidth}" height="{ImageHeight}" title="{ImageTitle}"  alt="{ImageAlt}" />

<style lang="scss">
    
    $mqMinWidthMobile: 0px;
    $mqMaxWidthMobile: 767px;

    $mqMinWidthDesktop: 768px;
    $mqMaxWidthDesktop: 1000000000px;

    .responsive-img { width: 100%; height: auto; }

    @media (min-width: $mqMinWidthMobile) and (max-width: $mqMaxWidthMobile)
    {  
    
    }


</style>