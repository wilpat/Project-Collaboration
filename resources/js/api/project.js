import {blackAxios} from '../config';

const headers = {
    'Accept': 'application/json'
}
const ProjectEndpoints =  {
    /**
     * Routes
     */

    project: 'projects',
    

    async all (dargs) {
        try {
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
        const response = blackAxios.post(this.project+ '/' + dargs.id,{_method: 'delete'}, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    },

    async update (dargs) {
        try {
        delete dargs.user;
        delete dargs.users;
        delete dargs.tasks;
        delete dargs.token;
        // console.log('Headers: ',headers)
        const response = blackAxios.post(this.project+ '/' + dargs.id, {_method: 'patch', ...dargs}, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    },

    async inviteUser (dargs) {
        try {
        const response = blackAxios.post(this.project+ '/' + dargs.project_id +'/invitations', {email:dargs.email}, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    },

    
}

export default ProjectEndpoints