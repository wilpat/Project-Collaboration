import {blackAxios} from '../config';

const headers = {
    'Accept': 'application/json'
}
const ProjectEndpoints =  {
    setToken (token) {
        headers.authorization = `Bearer ${token}`
        return true
    },

    /**
     * Routes
     */

    project: 'projects',
    register: 'auth/create',
    

    async all (dargs) {
        try {
        ProjectEndpoints.setToken(dargs.token)
        const response = blackAxios.get(this.project, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    },

    async create (dargs) {
        try {
        ProjectEndpoints.setToken(dargs.token)
        delete dargs.token;
        const response = blackAxios.post(this.project, dargs, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    },

    async get (dargs) {
        try {
        ProjectEndpoints.setToken(dargs.token)
        const response = blackAxios.get(this.project + '/' + dargs.id, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    },

    async delete (dargs) {
        try {
        ProjectEndpoints.setToken(dargs.token)
        const response = blackAxios.post(this.project+ '/' + dargs.id,{_method: 'delete'}, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    }

    
}

export default ProjectEndpoints