import { writable, readable } from 'svelte/store';

const Store = {
    env: {
        apiRoot: process.env[process.env.type].apiRoot,
        css: '200px'
    },
    api: {
        wineries: writable('')
    },
    pages: {
        base: {
            title: 'Winery2Home.com',
        },
        pagenotfound: {
            title: 'Page Not Found',
            description: 'We\'re sorry. The page you were looking for was not found.',
        },
        home: {
            title: 'Welcome!',
            description: 'Home',
        },
        join: {
            title: 'Join',
            description: 'Join',
        },
        shop: {
            title: 'Shop',
            description: 'Shop',
        },
        aboutus: {
            title: 'About Us',
            description: 'About Us',
        },
        contactus: {
            title: 'About Us',
            description: 'About Us',
        },
        howitworks: {
            title: 'How It Works',
            description: 'How It Works',
        },
        accountlogin: {
            title: 'Account Login',
            description: 'Account Login',
        },
        agecheck: {
            title: 'Age Check',
            description: 'To visit our website you must be old enough to purchase and consume alcohol under the laws of your country of residence.',
        },
        agecheckdenied: {
            title: 'Age Check Denied',
            description: 'Your access has been denied due to not being of legal drinking age within your home country.',
        },
        privacypolicy: {
            title: 'Privacy Policy',
            description: 'Privacy Policy',
        },
        termsofservice: {
            title: 'Terms of Service',
            description: 'Terms of Service',
        }
    },
    animations: {
        page: {
            transition: {
                speed: 1000
            }
        }
    }
};


export { Store };