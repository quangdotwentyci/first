<template>
    <div class="container">
        <br>
        <hr>
        <ul>
            <li v-for="task in tasks" :key="task.id">{{task.content}}</li>
        </ul>
        <form @submit.prevent="click">
            <input type="text" v-model="content">
        </form>
        <Button @click="click">Create new task</Button>
    </div>
</template>

<script>
    export default {
        props: ['userid'],
        data() {
            return {
                tasks: [],
                content: ''
            }
        },
        created() {
            axios.get('/task')
                .then((res) => {
                    this.tasks = res.data
                })
            window.Echo.channel('task.' + this.userid)
                .listen('TaskCreated', e => {
                    this.tasks.push(e.task)
                })
        },
        methods: {
            click() {
                axios.post('/task', {content: this.content})
                    .then(res => {
                        this.tasks.push(res.data)
                    })

                this.content = ''
            }
        },
    }
</script>
