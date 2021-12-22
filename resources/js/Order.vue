<template>
    <h1>{{ doc_title }}</h1>
    <table>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <tr>
            <td>{{ order.date }}</td>
            <td>{{ order.name }}</td>
            <td>{{ order.email }}</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
        </tr>
        <tr v-for="product in products">
            <td>{{ product.title }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td><img :src="getImage(product)"/></td>
        </tr>
    </table>
    <button @click="logout" style="position: absolute; bottom: 0pt;">Logout</button>
</template>
<script>
export default {
    data() {
        return {
            doc_title: 'Orders',
            order: [],
            products: [],
            path: []
        }
    },
    mounted() {
        this.path = window.location.pathname.split('/')
        axios.get('/orderShow/' + this.path[2]).then(response => {
            if (response.data.error) {
                window.location = '/'
            } else {
                this.order = response.data.order
                this.products = response.data.products
            }
        });
    },
    methods: {
        getImage(product) {
            return '../storage/images/' + product.image
        },
        logout() {
            axios.post('/logout').then(() => {
                window.location = '/'
            });
        }
    }
}
</script>
