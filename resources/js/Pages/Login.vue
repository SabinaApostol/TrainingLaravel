<template>
    <h1>Login</h1>
    <form style="text-align: center">
        <input type="text" placeholder="Email" required v-model="email">
        <br>
        <input type="password" placeholder="Password" required v-model="password">
        <br>
        <button type="submit" @click="save(email, password)">Login</button>
        <small style="color: red"><br>{{ error_credentials }} </small>
    </form>
</template>
<script>
export default {
    data() {
        return {
            email: null,
            password: null,
            errorMessage: null,
            error_password: '',
            error_credentials: null
        }
    },
    methods: {
        save(email, password) {
            axios.post('login', {'email': email, 'password': password}).then(() => {
                window.location = '/products'
            }).catch(() => {
                    if (! this.email || !this.password) {
                        this.error_credentials = 'All fields are required'
                    } else {
                        this.error_credentials = 'Invalid credentials'
                    }
                });
        }
    }
}
</script>
