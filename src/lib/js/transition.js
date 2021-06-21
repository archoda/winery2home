import { navigate } from "svelte-routing/src/history.js";
import { shouldNavigate, hostMatches } from "svelte-routing/src/utils.js";

const transitionTriggerMethod = (event, bipass = false) =>
{
    const anchor = event.currentTarget;
    
    if ( bipass === true || (anchor.target !== "_blank" && hostMatches(anchor) && shouldNavigate(event) )) {
        
        // Perform Page Transistion
        let transitionDelay = setInterval(() => {
            
            navigate(anchor.pathname + anchor.search, { replace: anchor.hasAttribute("replace") });

            clearInterval(transitionDelay);

            // console.log('transitionTriggerMethod method', event)
            // console.log('transitionTriggerMethod anchorTarget', anchor.target)
            // console.log('transitionTriggerMethod anchor.pathname', anchor.pathname)
            // console.log('transitionTriggerMethod hostMatches(anchor)', hostMatches(anchor))
            // console.log('transitionTriggerMethod shouldNavigate(event)', shouldNavigate(event))

        }, 100);
    }
}

const transition = (node) => 
{
    // console.log('Use Transition for Node', node);

    function onClick(event)
    {
        // console.log('Use Transition Click Triggered for Node', event.target);
        
        transitionTriggerMethod(event);

        event.preventDefault();
        event.stopPropagation();
    }

    // Bind the event listener
    node.addEventListener("click", onClick);

    // Unbind the event listener
    return {
        destroy()
        {
            node.removeEventListener("click", onClick);
        }
    };

}

export { transition, transitionTriggerMethod };