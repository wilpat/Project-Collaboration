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
    

    async allProjects (dargs) {
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

    async deleteProject (dargs) {
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