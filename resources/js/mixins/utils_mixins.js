const crypto = require('crypto');

export default {
    data: function () {
        return {

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

        }
    }
}