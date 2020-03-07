const crypto = require('crypto');

export default {
    data: function () {
        return {
            notificationSystem: {
              options: {
                ballon: {
                  position: 'topRight'
                },
                info: {
                  position: 'topRight'
                },
                success: {
                  position: 'topRight'
                },
                warning: {
                  position: 'topRight'
                },
                error: {
                  position: 'topRight'
                }
              }
            }
        }
    },

    methods: {
        cleanObject (object) {
            delete object.created_at
            delete object.updated_at
            return object
        },
        gravatar(email) {
            let hash = crypto.createHash('md5').update(email).digest("hex");
            return `https://s.gravatar.com/avatar/${hash}?s=60`;

        },
        handleError (error, customMessage='') {
            // console.log(error);
            if (error.message === 'Network Error') {
              this.$toast.error('Connection not established, please check your internet connection', '', this.notificationSystem.options.error)
            } else if(error.response.status === 401 ){
              this.$toast.error(customMessage ? customMessage : 'You have been logged out.', '', this.notificationSystem.options.error)
            }else if(error.response.status === 422 ){
                this.$toast.error(customMessage ? customMessage : 'Invalid data given.', '', this.notificationSystem.options.error)
            }else if(error.response.status === 404 ){
                this.$toast.error(customMessage ? customMessage : 'Not found.', '', this.notificationSystem.options.error)
            }else {
                this.$toast.error(error.message, '', this.notificationSystem.options.error)
            }
        }
    }
}