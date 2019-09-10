<template>
    <div class="container">
        <Button @click="click">Create new User</Button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            click() {
                axios.post('/broad')
            }
        },
    }
</script>
