<template>
    <div>
        <div class="field mb-6">
            <label class="label text-sm mb-2 block" title="title">Title:</label>

            <div class="control">

                <input 
                    class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full" 
                    type="text" 
                    placeholder="My next awesome project" 
                    name="title"
                    v-model="project.title"
                    required 
                    >
            </div>
            <template v-if="errors.title">
                <p class="text-red text-xs italic my-2" role="alert" v-for="(error, index) in errors.title" :key="index">
                    <strong>{{ error }}</strong>
                </p>
            </template>
        </div>


        <div class="field">
            <label class="description">Description:</label>
            <div class="control">
                <textarea 
                class="textarea bg-transparent border border-grey-light rounded p-2 text-ws w-full"
                placeholder=""
                name="description"
                style="min-height: 200px"
                v-model="project.description"
                required></textarea>
            </div>
            <template v-if="errors.description">
                <p class="text-red text-xs italic my-2" role="alert" v-for="(error, index) in errors.description" :key="index">
                    <strong>{{ error }}</strong>
                </p>
            </template>
        </div>
        

        <div class="field">
            <div class="control flex justify-between">
                <button class="button is-primary" @click="$emit('submitted', project)">{{ buttonText }}</button>
                <router-link :to="'/projects/'+project.id" class="button bg-green">Cancel </router-link>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'Form',
    props: {
        buttonText: {
            type: String,
            description: 'Text in the submission button'
        },
        project: {
            // type: Object,
            description: 'Project to be worked on',
            default:  () => {
                return {
                    title: '',
                    description: '',
                    id: ''
                }
            }
        },
        errors: {
            type: Object,
            description: 'Errors on submission'
        }
    },
    mounted () {

    },
    data() {
        return {
            
        }
    }
}
</script>