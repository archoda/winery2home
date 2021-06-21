<script>

    /*
        Imports
    */
    import { onMount, beforeUpdate, afterUpdate, tick } from 'svelte';  
    import { Store } from '../lib/js/store.js';
    import StoreManagerClass from '../lib/js/StoreManagerClass.js';
    import TabsClass from '../lib/js/TabsClass.js';
    import anime from 'animejs';

    import MastheadComponent from '../components/MastheadComponent.svelte';
    import ProductComponent from '../components/Product.svelte';
    import CompanyComponent from '../components/CompanyComponent.svelte';
    import ImageComponent from './ImageComponent.svelte';
    import ButtonCloseComponent from '../components/ButtonCloseComponent.svelte';
    import ImagePictureComponent from '../components/ImagePictureComponent.svelte';

    /*
        Exports
    */

    let Modal;    
    let ModalId = 'modal';
    let ModalClass = '';
    let ModalType = '';
    let ModalActive = false;
    let ModalData = {};

    let ModalContainerClass = '';

    let ModalTabs;

    $: {
        if ($Store.Modal.Active)
        {
            ModalInit();
        }
    }

    const ModalPanels = [];

    export const ModalTest = () =>
    {
        console.log('Modal Test Called');
    }

    export const ModalClose = () =>
    {
        console.log('ModalClose Called....');
        Modal = document.getElementById(ModalId);
            Modal.style.zIndex = ModalZIndexSetTop({ TargetId: ModalId });
            
            anime.timeline({
                loop: false,
            }).add({
                targets: '#modal',
                direction: 'forward',
                easing: 'linear',
                opacity: {
                    value: [1,0],
                    duration: 250,
                    delay: 250,
                },
                delay: 0,
                complete: () => 
                {

                    ModalType = $Store.Modal.Type = '';
                    ModalData = $Store.Modal.Data = {};
                    ModalActive = $Store.Modal.Active = false;

                }
        });
    }

    const ModalPanelGroupToggle = () => {

    }

    const ModalPanelGroupOpen = () =>
    {
        console.log('Modal PanelOpen Top Called');
    }

    const ModalPanelGroupClose = () =>
    {   
        ModalClose();
    }

    const ModalInit = () =>
    {
        let ModalReady = setTimeout(() => 
        {
            Modal = document.getElementById(ModalId);
            Modal.style.zIndex = ModalZIndexSetTop({ TargetId: ModalId });
            
            anime.timeline({
                loop: false,
            }).add({
                targets: '#modal',
                direction: 'forward',
                easing: 'linear',
                opacity: {
                    value: [0,1],
                    duration: 500,
                    delay: 250,
                },
                delay: 0,
                complete: () => 
                {

                    ModalTabs = new TabsClass({ Target: document.querySelector('.modal') });
                    ModalTabs.TabsInit();
                    console.log('Modal Tabs Init Called...');

                }
            });

            clearTimeout(ModalReady);

        }, 10);
    }

    const ModalZIndexSetTop = (_Args) =>
    {
        let ZIndex = null;
        let ZIndexTop = 1;

        document.querySelectorAll('body > *').forEach((_Element, _Index) => { 
            
            ZIndex = window.getComputedStyle(_Element).zIndex;
            
            if (_Element.getAttribute('id') !== _Args.TargetId && Number(ZIndex) > ZIndexTop) ZIndexTop = ZIndex;

        });

        return Number(ZIndexTop) + 1;
    }

    const ModalPanelZIndexSetTop = (_Args) =>
    {
        let ZIndex = null;
        let ZIndexTop = 1;

        document.querySelectorAll('modal > *').forEach((_Element, _Index) => { 
            
            ZIndex = window.getComputedStyle(_Element).zIndex;

            if (_Element.getAttribute('id') !== _Args.Target && Number(ZIndex) > ZIndexTop) ZIndexTop = ZIndex;

        });

        return Number(ZIndexTop) + 1;
    }


    onMount(() =>
    {  
       
    });

    

</script>


{#if $Store.Modal.Active && $Store.Modal.Type !== ''}

    <div id="modal" class="modal {ModalClass}">

        {#if $Store.Modal.Type === 'WineryDetails'}
            <CompanyComponent AttributeClass='winery-list' Callback={ModalClose} />
        {/if}
        
        {#if $Store.Modal.Type === 'ProductDetails'}
            <div class="modal-panel">
                <ButtonCloseComponent AttributeId={'modal-panel-button-close'} AttributeClass={'modal-button-close'} AttributeTitle={'Modal Close'} Callback={ModalClose} />                   
                <ProductComponent AttributeClass={'product-details'} Winery={$Store.Modal.Data.Product.winery.name} Id={$Store.Modal.Data.Product.winery.id} WPId={$Store.Modal.Data.Product.winery.wpid} Region={$Store.Modal.Data.Product.winery.region} Product={$Store.Modal.Data.Product} ProductDisplayType={$Store.Modal.Type} />
            </div>
        {/if}

        <div class="modal-background">
            <!-- <ImagePictureComponent
                ImageId={''} 
                ImageClass='responsive-img-cover' 
                ImageSrc={'./lib/images/_fpo_product-details-mobile.jpg'} 
                ImageWidth={'414'} 
                ImageHeight={'896'} 
                ImageTitle={'Modal Background'} 
                ImageAlt={'Modal Background'} 
                ImageSources={ 
                    [
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/_fpo_product-details-mobile.jpg, ./lib/images/_fpo_product-details-mobile@2x.jpg 2x', 
                            Media: '(min-width: 0px) and (max-width: 767px)'
                        },
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/modal-background-desktop.jpg, ./lib/images/modal-background-desktop-slide-2@2x.jpg 2x', 
                            Media: '(min-width: 768px) and (max-width: 10000000px)'
                        },
                    ]
                } /> -->
            <ImagePictureComponent
                ImageId={''} 
                ImageClass='responsive-img-cover' 
                ImageSrc={'./lib/images/modal-background-mobile.jpg'} 
                ImageWidth={'414'} 
                ImageHeight={'896'} 
                ImageTitle={'Modal Background'} 
                ImageAlt={'Modal Background'} 
                ImageSources={ 
                    [
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/modal-background-mobile.jpg, ./lib/images/modal-background-mobile@2x.jpg 2x', 
                            Media: '(min-width: 0px) and (max-width: 767px)'
                        },
                        { 
                            Lazy: '', 
                            Srcset: './lib/images/modal-background-desktop.jpg, ./lib/images/home-background-desktop-slide-2@2x.jpg 2x', 
                            Media: '(min-width: 768px) and (max-width: 10000000px)'
                        },
                    ]
                } />
        </div>

    </div>
{/if}


<style global lang="scss">

    /*
        GLOBAL VARS
    */
    

    /*
        MODAL
    */

    /* Hide scrollbar for IE, Edge and Firefox */
    .modal-panel { overflow-y: scroll; overflow-x: hidden; -ms-overflow-style: none;  /* IE and Edge */ scrollbar-width: none;  /* Firefox */ }
    
    /* Hide scrollbar for Chrome, Safari and Opera */
    .modal-panel::-webkit-scrollbar {
        display: none;
    }

    #modal { position: absolute; top: 0; left: 0; opacity: 0; }

    .modal-panel { position: absolute; top: 0; left: 0; }

    #modal,
    .modal-panel,
    .modal-background { width: 100%; height: 100%; }

    .modal-panel-group { display: none; height: 0; }
    .modal-panel-group-active { display: grid; height: 100%; }

    #modal,
    .modal-background { overflow: hidden; }

    .modal-background { background-color: var(--primary-tan); }

    .modal-button-close { cursor: pointer; position: fixed; z-index: 2; border: none; background-color: transparent; }

    .modal-centered { display: grid; align-items: center; }

    .winery-details ul,
    .winery-details li { list-style: none; margin: 0; padding: 0; }

    .winery-details li span { display: inline-block; }

    @media (min-width: 0) and (max-width: 767px)
    {   

        /*
            MODAL
        */

        .modal-button-close { top: 6.5vw; right: 3vw;  }

        .winery-details .list-item-icon { width: 3vw; }

        .winery-details .list-item-label { margin-left: 3vw; transform: translate(0, -1.25vw); }

        .winery-details .list-item-button { margin: 0; }
    
        .winery-details .list-item-button + .list-item-button { margin: 10vw 0 0; }

    }

    @media (min-width: 767px) and (max-width: 1000000000px)
    { 
        /*
            MODAL
        */

        .modal-button-close { top: 1.5vw; right: 1.5vw; width: 4vw; }
    }

</style>