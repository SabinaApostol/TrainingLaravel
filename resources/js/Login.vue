<template>
    <h1>Login</h1>
    <form style="text-align: center">
        <input type="text" placeholder="Username" required v-model="username">
        <br>
        <input type="password" placeholder="Password" required v-model="password">
        <br>
        <button @click="save(username, password)">Save</button>
        <br>
        <span style="color: red; text-align: center">{{ errorMessage }}</span>
    </form>
</template>
<script>
export default {
    data() {
        return {
            username: null,
            password: null,
            errorMessage: null
        }
    },
    methods: {
        save(username, password) {
            axios.post('login', {'username': username, 'password': password}).then((response) => {
                if (! response.data.error) {
                    window.location = '/products'
                } else {
                    this.errorMessage = 'Invalid credentials'
                }
            }).catch(() => {
                this.errorMessage = 'Please complete all fields'
            });

        }
    }
}
</script>
