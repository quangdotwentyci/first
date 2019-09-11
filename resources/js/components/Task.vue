<template>
    <div class="container">
        <br>
        <hr>
        <ul>
            <li v-for="task in tasks" :key="task.id">{{task.content}}</li>
        </ul>
        <form @submit.prevent="click">
            <input type="text" v-model="content" @keydown="onTap">
        </form>
        <span v-if="activePeer">{{activePeer}} is typing</span>
        <Button @click="click">Create new task</Button>
    </div>
</template>

<script>
    export default {
        props: ['userid'],
        data() {
            return {
                tasks: [],
                content: '',
                activePeer: '',
                typingTimer: false
            }
        },
        computed: {
            channel() {
                return window.Echo.private('task.' + this.userid);
            }
        },
        created() {
            axios.get('/task')
                .then((res) => {
                    this.tasks = res.data
                })
            this.channel
                .listen('TaskCreated', e => {
                    this.tasks.push(e.task)
                })
                .listenForWhisper('typing', this.flash)

            window.Echo.private('App.User.' + this.userid)
                .notification((notification) => {
                    console.log(notification);
                });
        },
        methods: {
            click() {
                axios.post('/task', {content: this.content})
                this.content = ''
            },
            onTap() {
                this.channel.whisper('typing', {name: 1})
            },
            flash(e) {
                console.log(e)
                this.activePeer = e.name
                const clearActive = () => {
                    this.activePeer = ''
                }
                if (this.typingTimer) clearInterval(this.typingTimer)
                this.typingTimer = setTimeout(clearActive, 1000)
            }
        },
    }
</script>
