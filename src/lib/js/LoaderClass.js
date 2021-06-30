
// USE PROMISE ALL
// https://gomakethings.com/waiting-for-multiple-all-api-responses-to-complete-with-the-vanilla-js-promise.all-method/

import { select_option } from "svelte/internal";

export default class LoaderClass
{
    constructor(_Args)
    {
        this.Options = _Args.options ?? {};
        this.Cache = _Args.Cache ?? [];
        this.Cached = false;
        this.ResponseLoader = [];
        this.ResponseResults = [];
    }

    CacheExists(path)
    {
        let CacheI = -1;
        let CachedPath = false;

        for (const Cache of this.Cache)
        {
            CacheI++;
            
            if (Cache?.Responses[0]?.url == path)
            {
                CachedPath = true;
                break; 
            }
        }

        return (CachedPath) ? this.Cache[CacheI] : null;
    }

    CacheUpdate()
    {
        // Manage Cache
        if (this?.Cache[0] != undefined)
        {
            this.Cache = [Array.from(this.Cache), { Responses: this.ResponseLoader, Results: this.ResponseResults }];
        }
        else
        {
            this.Cache = [{ Responses: this.ResponseLoader, Results: this.ResponseResults }];
        }
    }

    async Get(path)
    {   
        let Cached = this.CacheExists(path);
        
        // Loader Cached
        if (Cached)
        {
            console.log('Finish Cached Loader...')
                
            let Delay = await setTimeout( async () => 
            {
                await new Promise((resolve, reject) => {
                        
                    
                    this.Cached = true;
                    this.ResponseLoader = Cached.Responses;
                    this.ResponseResults = Cached.Results;

                    clearTimeout(Delay);
                    console.log('Finish Cached Loader Finished...');
                        // Return empty object to avoide promise json error
                    resolve({});
                });

            }, 1000);
        }
        // Loader New
        else
        { 
            await fetch(path)
            .then(response =>
            { 
                this.ResponseLoader.push(response); 
                return response.json();
            })
            .then(data => 
            { 
                this.ResponseResults.push(data); 
                this.CacheUpdate();
                return; 
            });
        }
    };

    async Post(path)
    {
        // Do Something...
    }

    async PromiseAll()
    { 
        if (this.Options[0].Url === '')
        {
            return await new Promise( (resolve, reject) => setTimeout( async() => {

                var ResultInit = { type: "basic", redirected: false, status : 200 , "ok" : true, statusText: '', body: '' };

                let Result = await new Response({}, ResultInit);

                this.Cached = this.Cache;
                this.ResponseLoader.push(Result);
                this.ResponseResults.push({});
                
                resolve({ Cached: this.Cached, Cache: this.Cache, Responses: this.ResponseLoader, Results: this.ResponseResults });
                
            }, 1000));
        }
        else
        {
            let Loader;

            // Loop throught the request and Loader.
            for (const Option of this.Options)
            {
                console.log('Loader Url called...', Option.Url);
                Loader = await this.Get(Option.Url); 
            }
            
            return await Promise.all(this.ResponseLoader)
            .then( response =>
            {
                console.log('Finished Loader Promise All', { Cached: this.Cached, Cache: this.Cache, Responses: this.ResponseLoader, Results: this.ResponseResults })
                return { Cached: this.Cached, Cache: this.Cache, Responses: this.ResponseLoader, Results: this.ResponseResults };
            })
            .catch(error =>
            {
                return ['Error', error];
            });
        }
    }



};
