
// USE PROMISE ALL
// https://gomakethings.com/waiting-for-multiple-all-api-responses-to-complete-with-the-vanilla-js-promise.all-method/

export let loaderBegin = null;
export let loaderUpdate = null;
export let loaderComplete = null;

export default class FetchClass
{
    constructor(args)
    {
        this.options = args.options;
        this.responseFetch = [];
        this.responseData = [];
    }


    async Get(path)
    {
        await fetch(path)
        .then(response =>
        { 
            this.responseFetch.push(response); 
            return response.json();
        })
        .then(data => 
        { 
            this.responseData.push(data); return; 
        });
    };

    async PromiseAll()
    { 
        for (const path of this.options)
        {
            let fetch = await this.Get(path);
        }

        return await Promise.all(this.responseFetch)
        .then( response =>
        {
            return [this.responseFetch, this.responseData];
        })
        .catch(error =>
        {
            console.log('promise error', error);
        });
    }

};
