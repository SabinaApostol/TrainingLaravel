<template>
    <h1>Login</h1>
    <form style="text-align: center">
        <input type="text" placeholder="Username" required v-model="username">
        <br>
        <input type="password" placeholder="Password" required v-model="password">
        <br>
        <button @click="save(username, password)">Save</button>
    </form>
    <span style="color: red">{{ errorMessage }}</span>
    <p>
        {{ username }}
    </p>
    <p>
        {{ password }}
    </p>
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

                    console.log(response)
                    window.location = '/'
                }
            }).catch((response) => {
                console.log(response)
                // window.location = '/'
            });

        }
    }
}
</script>
