import { navigate } from "svelte-routing/src/history.js";
import { shouldNavigate, hostMatches } from "svelte-routing/src/utils.js";
import { stop_propagation } from "svelte/internal";
import { Store } from './store.js';


export const TrantitionBeforeCallback = () => { };

function transitionTriggerMethod(event, bipass = false)
{
    
    let pageNotFound = true;

    const anchor = event.currentTarget;
    console.log('method', event)
    console.log('anchorTarget', anchor.target)
    console.log('anchor.pathname', anchor.pathname)
    // console.log('hostMatches(anchor)', hostMatches(anchor))
    // console.log('shouldNavigate(event)', shouldNavigate(event))

    if ( bipass === true || (anchor.target === "" && hostMatches(anchor) && shouldNavigate(event) )) {
        
        event.preventDefault();

        // Check for 404 Pages - check global Window.__routes set in /svelte-router routes....
        for (const [key, value] of Object.entries(window.__approutes))
        {   
            if (anchor.pathname === value._path && value._path.indexOf('#') === -1)
            {
                pageNotFound = false;
                break;
            }
        }

        // Set/Reset the pathname if not a found page...
        anchor.pathname = (pageNotFound) ? '/page-not-found' : anchor.pathname;

        // Perform Page Transistion
        let transitionDelay = setInterval(() => {
            
        
            navigate(anchor.pathname + anchor.search, { replace: anchor.hasAttribute("replace") });

            clearInterval(transitionDelay);

        }, Store.animations.page.transition.speed);
    }
}

function transition(node)
{
    function onClick(event)
    {
        transitionTriggerMethod(event);
    }

    // Bind the event listener
    node.addEventListener("click", onClick);

    // Unbind the event listener
    return {
        destroy() {
            node.removeEventListener("click", onClick);
        }
    };

}


export { transition, transitionTriggerMethod };