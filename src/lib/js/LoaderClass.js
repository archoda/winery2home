
// USE PROMISE ALL
// https://gomakethings.com/waiting-for-multiple-all-api-responses-to-complete-with-the-vanilla-js-promise.all-method/

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
            this.Cached = true;
            this.ResponseLoader = Cached.Responses;
            this.ResponseResults = Cached.Results;
            return this.ResponseResults;
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
        let Loader;

        // Loop throught the request and Loader.
        for (const Option of this.Options)
        {
            Loader = await this.Get(Option.Url);
        }
        
        return await Promise.all(this.ResponseLoader)
        .then( response =>
        {
            return { Cached: this.Cached, Cache: this.Cache, Responses: this.ResponseLoader, Results: this.ResponseResults };
        })
        .catch(error =>
        {
            return ['Error', error];
        });
    }



};
