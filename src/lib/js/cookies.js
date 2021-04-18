
export class CookiesClass {

    Cookies()
    {
        return;
    }

    CookieExists (cname)
    {
        // Check if Cookie exists
        let cookie = this.CookieGet(cname);

        if (cookie && cookie !== "")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    CookieGet (cname)
    {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');

        // Return cookie by name
        for(var i = 0; i <ca.length; i++)
        {
            var c = ca[i];
            while (c.charAt(0) == ' ')
            {
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0)
            {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    
    CookieSet (cname, cvalue, exdays)
    {
        let d = new Date();
        
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        
        let expires = "expires="+d.toUTCString();
        
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

    }

    CookieRemove(cname)
    {   
        // Remove/Expire Cookie
        document.cookie = cname+'=; Max-Age=-99999999;';
    
    }
}