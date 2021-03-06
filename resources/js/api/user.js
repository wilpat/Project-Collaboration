import {blackAxios} from '../config';

const headers = {
    'Accept': 'application/json'
}
const UserEndpoints =  {
    /**
     * Routes
     */

    login_url: 'auth/login',
    register_url: 'auth/register',
    logout_url: 'auth/logout',
    

    async login (dargs) {
        // console.log(this.headers);
        try {
            const response = blackAxios.post(this.login_url, dargs, {
                headers
            })
            return response
        } catch (e) {
            return false
        }
    },

    async register (dargs) {
        try {
            const response = blackAxios.post(this.register_url, dargs, {
                headers
            })
            return response
        } catch (e) {
            return false
        }
    },

    async logout (dargs) {
        try {
            const response = blackAxios.post(this.logout_url+'?token='+dargs.token)
            return response
        } catch (e) {
            console.log(e)
            return false
        }
    }

    
}

export default UserEndpoints