import {blackAxios} from '../config';

const headers = {
    'Accept': 'application/json'
}
const TaskEndpoints =  {
    /**
     * Routes
     */

    task: 'tasks/',
    

    async all (dargs) {
        try {
        const response = blackAxios.get(this.task, {
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
        const response = blackAxios.post(`projects/${dargs.id}/${this.task}`, dargs, {
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
        dargs._method = 'patch';
        const response = blackAxios.post('projects/' + dargs.project_id +'/'+this.task + dargs.id, dargs, {
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
        const response = blackAxios.post(this.task + dargs.id,{_method: 'delete'}, {
            headers
        })
        return response
        } catch (e) {
        console.log(e)
        return false
        }
    }

    
}

export default TaskEndpoints