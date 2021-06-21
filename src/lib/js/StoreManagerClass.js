/*
    Exports
*/
export default class StoreManagerClass
{

    constructor(_Store)
    {
        // Do Something...
    }

    WineriesAllSet(_Products)
    {
        let Products = Object.assign(_Products).map( (_Product) => 
        {
            return _Product;

        });
        
        return Products;
    }

    WineriesFilteredByFeaturedSet(_Products, _Boolean)
    {
        let Products = Object.assign(_Products).map( (_Product) => 
        {
            if (_Product.featured === _Boolean)
            {
                return _Product;
            }
            return Products;

        });
        
        return Products;
    }

    WineriesFilteredByRegionGet(_Wineries, _Regions)
    {

    }

    WineriesFilteredByVarietalGet(_Wineries, _Varietals)
    {

    }
}
