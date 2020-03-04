import {blackAxios} from '../config';

const headers = {
    'Accept': 'application/json'
}
const UserEndpoints =  {
    setToken (token) {
        headers.authorization = `Bearer ${token}`
        return true
    },

    /**
     * Routes
     */

    login: 'auth/login',
    register: 'auth/create',
    

    async userLogin (dargs) {
        // console.log(this.headers);
        try {
        const response = blackAxios.post(this.login, dargs, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    },

    async userRegister (dargs) {
        try {
        const response = blackAxios.post(this.register, dargs, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    }

    
}

export default UserEndpoints