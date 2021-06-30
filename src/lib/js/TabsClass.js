import anime from 'animejs';

export default class TabsClass
{
    constructor($_Args)
    {
        this.Target = $_Args.Target;
    }

    
    TabsToggleCallbackAfter(TabPanel)
    {
        // Do something...
    }

    TabsToggleCallbackBefore(TabPanel)
    {
        // Do something...
    }

    TabsToggle(_Args, Event)
    { 
        let TabClass = _Args.TabClass;
        let TabGroup = _Args.TabGroup;
        let TabGroupIndex = _Args.TabGroupIndex;
        let TabControl = _Args.TabControl;
        let TabPanels = _Args.TabPanels;
        let TabButtonIndex = _Args.TabButtonIndex;
        let TabTransitionSpeed = _Args.TabTransitionSpeed;
        
        TabControl.querySelectorAll('li').forEach((Tab, TabIndex) => {

            let Span = Tab.querySelector('span');

            if (TabIndex != TabButtonIndex)
            {
                Tab.classList.remove('tab-active');
            }
            else
            {
                Tab.classList.add('tab-active');
            }
        });

        TabPanels.forEach((TabPanel, TabPanelIndex) =>
        {   
            TabPanel.querySelectorAll('.tab-panel').forEach((Panel, PanelIndex) =>
            {
                
                if (PanelIndex != TabButtonIndex)
                {
                    Panel.classList.remove('tab-panel-active');

                    anime({
                        targets: Panel,
                        opacity: [Panel.style.opacity,0],
                        duration: TabTransitionSpeed,
                        direction: 'forward',
                        easing: 'linear',
                        loop: false,
                        complete: () => 
                        {
                            Panel.style.transform = "translate(-1000000000vw, -1000000000vw)";
                            Panel.style.opacity = 0;
                        }
                    });

                }
                else
                {
                    Panel.classList.add('tab-panel-active');

                    anime({
                        targets: Panel,
                        opacity: [Panel.style.opacity,1],
                        duration: TabTransitionSpeed,
                        direction: 'forward',
                        easing: 'linear',
                        loop: false,
                        begin: () =>
                        {
                            Panel.removeAttribute('style');
                            TabClass.TabsToggleCallbackBefore(Panel);
                        },
                        complete: () =>
                        {
                            Panel.style.opacity = 1;
                            TabClass.TabsToggleCallbackAfter(Panel);
                        }
                    });

                }

            });

        });

    };

    TabsInit(_Args)
    {   

        let TabTransitionSpeed = (_Args?.TransitionSpeed) ? _Args?.TransitionSpeed : 500;

        let TabGroups = this.Target.querySelectorAll('.tab-group');
       
        TabGroups.forEach((TabGroup, TabGroupIndex) => {

            let TabControl = TabGroup.querySelector('.tab-control');
            let TabPanels = TabGroup.querySelectorAll('.tab-panels');

            TabControl.querySelectorAll('li').forEach((TabButton, TabButtonIndex) =>
            {
                let TabGroupData = {
                        TabClass: this,
                        TabGroupIndex: TabGroupIndex,
                        TabGroup: TabGroup,
                        TabButton: TabButton,
                        TabButtonIndex: TabButtonIndex,
                        TabControl: TabControl,
                        TabPanels: TabPanels,
                        TabTransitionSpeed: TabTransitionSpeed,
                };


                // Init Tabs Toggle
                if (TabButtonIndex === 0) this.TabsToggle(TabGroupData, null);

                anime({
                    targets: TabGroup,
                    opacity: [TabGroup.style.opacity,1],
                    duration: TabTransitionSpeed,
                    direction: 'forward',
                    loop: false,
                    complete: () => {
                        TabGroup.style.opacity = 1;
                    }
                });

                TabButton.addEventListener('click', this.TabsToggle.bind(Event, TabGroupData), false);
            });
        
        });
    }
}