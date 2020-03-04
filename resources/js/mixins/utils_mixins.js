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
    }
}