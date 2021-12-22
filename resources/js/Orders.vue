<template>
    <h1>{{ doc_title }}</h1>
    <table>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Total</th>
            <th>Details</th>
        </tr>
        <tr v-for="order in orders">
            <td>{{ order.date }}</td>
            <td>{{ order.name }}</td>
            <td>{{ order.email }}</td>
            <td>{{ order.sum }}</td>
            <td>
                <router-link :to="createLink(order.id)">See details</router-link>
            </td>
        </tr>
    </table>
    <button @click="logout" style="position: absolute; bottom: 0pt;">Logout</button>
</template>
<script>
export default {
    data() {
        return {
            doc_title: 'Orders',
            orders: null,
        }
    },
    mounted() {
        axios.get('/ordersShow').then(response => {
            if (response.data.error) {
                window.location = '/'
            } else {
                this.orders = response.data
            }
        });
    },
    methods: {
        createLink(id) {
            return '/order/' + id
        },
        logout() {
            axios.post('/logout').then(() => {
                window.location = '/'
            });
        }
    }
}
</script>
