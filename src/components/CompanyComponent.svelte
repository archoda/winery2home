<script>

    /*
        Imports
    */
    import { onMount, createEventDispatcher, tick } from 'svelte';
    import { Store } from '../lib/js/store.js';
    import anime from 'animejs';

    import MastheadComponent from './MastheadComponent.svelte';
    import ImageComponent from './ImageComponent.svelte';
    import ImagePictureComponent from './ImagePictureComponent.svelte';
    import LinkComponent from './LinkComponent.svelte';
    import ButtonCloseComponent from './ButtonCloseComponent.svelte';

    /*
        Exports
    */
    export let Wineries         = $Store.Modal.Data.Winery; console.log(Wineries.Region);
    let RegionSelected          = Wineries.Region.split(',');
    let Region                  = RegionSelected[1];
    let State                   = RegionSelected[0];
    $: Winery                   = {};

    export let Callback         = null;

    const WineryDetailsToggle = async() =>
    {

        let ModalPanels = document.querySelectorAll('.modal-panel-group');

        await tick(); // Wait a tick for details panel to mount...

        ModalPanels.forEach( (Item) => {
            
            if (Item.classList.contains('modal-panel-group-active'))
            {
                anime({
                    targets: Item,
                    opacity: [1, 0],
                    duration: 250,
                    direction: 'forward',
                    easing: 'linear',
                    loop: false,
                    begin: () => {},
                    complete: () => {
                        Item.classList.remove('modal-panel-group-active');
                    }
                });
            }
            else
            {
                anime({
                    targets: Item,
                    opacity: [Item.style.opacity, 1],
                    duration: 250,
                    direction: 'forward',
                    easing: 'linear',
                    loop: false,
                    begin: () => {
                        Item.classList.add('modal-panel-group-active');
                    },
                    complete: () => {}
                });
            }

        });
    }

    onMount(() => 
    {

    });

</script>


<div class="modal-panel modal-centered modal-panel-group modal-panel-group-active">

    <ButtonCloseComponent Callback={Callback} AttributeId={'modal-button-close'} AttributeClass={'modal-button-close'} AttributeTitle={'Modal Close'} />
    <MastheadComponent Class={'winery-details'} headersmall={'Wineries Of ' + Region} header={State}>

    <ul class="winery-detail-list">

        {#each Wineries.List as WineryListing }
            <li class="list-item">
                
                <button on:click={ () => { Winery = WineryListing; WineryDetailsToggle(); } } class="button list-item-button">
                    <span class="list-item-icon">
                        <ImageComponent ImageClass={['winery-detail-icon-arrow']} ImageSrc={$Store.API.Root + '/lib/images/icon-arrow.svg'} ImageWidth={'24'} ImageHeight={'13'} ImageTitle='Icon Arrow Graphical Icon' ImageAlt='Icon Arrow Graphical Icon' ImageSources={ [{ Lazy: '', Srcset: '', Media: '' }] } />
                    </span>
                    <span class="list-item-label">{@html WineryListing.name}</span>
                </button>
            
            </li>
        {/each}
    </ul>

    </MastheadComponent>
</div>

<div class="modal-panel modal-centered modal-panel-group">
    <ButtonCloseComponent Callback={ () => { WineryDetailsToggle({ Winery: null }) }} AttributeId={'modal-button-close'} AttributeClass={'modal-button-close'} AttributeTitle={'Modal Close'} />
    <MastheadComponent Class={'winery-details'} headersmall={Winery.name + ' Of ' + Region} header={State}/>
    
    <div id="tab-group-1" class="tab-group hidden" role="tablist" aria-label="Winery Details">

        <ul class="tab-control">
            <li class="tab tab-active">
                <button role="tab">
                    <span class="tab-label" aria-label="Video" title="Video">Video</span>
                    <span class="tab-bar"><span class="tab-bar-active"></span></span>
                </button>
            </li>
            <li class="tab tab-active">
                <button role="tab">
                    <span class="tab-label" aria-label="Map" title="Map">Map</span>
                    <span class="tab-bar"><span class="tab-bar-active"></span></span>
                </button>
            </li>
            <li class="tab tab-active">
                <button role="tab">
                    <span class="tab-label" aria-label="Gallery" title="Gallery">Gallery</span>
                    <span class="tab-bar"><span class="tab-bar-active"></span></span>
                </button>
            </li>
        </ul>

        <div class="tab-panels">
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">
                {#if Winery.explore}
                <div class="winery-details-video">
                    <div class="winery-detail-video-play">
                        <ImagePictureComponent
                            ImageId={''} 
                            ImageClass='' 
                            ImageSrc={'./lib/images/icon-video-play-button-mobile.svg'} 
                            ImageWidth={'414'} 
                            ImageHeight={'896'} 
                            ImageTitle={'Video Play Button Icon'} 
                            ImageAlt={'Video Play Button Icon'} 
                            ImageSources={ 
                                [
                                    { 
                                        Lazy: '', 
                                        Srcset: './lib/images/icon-video-play-button-mobile.svg', 
                                        Media: '(min-width: 0px) and (max-width: 767px)'
                                    },
                                    { 
                                        Lazy: '', 
                                        Srcset: './lib/images/icon-video-play-button-desktop.svg', 
                                        Media: '(min-width: 768px) and (max-width: 10000000px)'
                                    },
                                ]
                            } />
                    </div>
                    <video class="responsive winery-details-video" src="{Winery.explore.video.url}" preload="auto" autoplay="autoplay" poster="{Winery.explore.video.url}" muted="true" loop="loop" playsinline="true">Your browser does not support the video tag.</video>
                </div>
                {/if}
            </div>
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">Map</div>
            <div class="tab-panel hidden" tabindex="0" role="tabpanel">Gallery</div>
        </div>
        
        {#if Winery.explore}
            {@html Winery.explore.description}
        {/if}
        <LinkComponent AttributeClass={"button button-wine white-text"} AttributeHref={'/shop'} AttributeTitle={'Shop All Wines'}>Shop All Wines</LinkComponent>

    </div>
    
</div>

<style global lang="scss">

    .modal-panel-group .modal-button-close { display: none; }

    .modal-panel-group-active .modal-button-close { display: inline-block; }

    /* 
        WINERY VIDEO 
    */
    
    .winery-details-video { position: relative; }

    .winery-details-video,
    .winery-details-video video { width: 100%; height: auto; background-color: var(--primary-tan-dark) }

    .winery-detail-video-play { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }

    @media (min-width: 0px) and (max-width: 767px)
    {  
        .winery-detail-video-play { width: 20vw; height: auto; }
    }

</style>