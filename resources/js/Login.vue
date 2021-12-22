<template>
    <h1>Login</h1>
    <form style="text-align: center">
        <input type="text" placeholder="Email" required v-model="email">
        <br>
        <input type="password" placeholder="Password" required v-model="password">
        <br>
        <button @click="save(email, password)">Login</button>
        <br>
        <span style="color: red; text-align: center">{{ errorMessage }}</span>
    </form>
</template>
<script>
export default {
    data() {
        return {
            email: null,
            password: null,
            errorMessage: null
        }
    },
    methods: {
        save(email, password) {
            axios.post('login', {'email': email, 'password': password}).then(() => {
                window.location = '/products'
            });
        }
    }
}
</script>
