<template>
    <h1>{{ title }}</h1>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <tr v-for="product in products" :key="product.id">
            <td>{{ product.title }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td><img :src="getImage(product)"/></td>
            <td>
                <router-link :to="createLink(product.id)">Edit</router-link>
            </td>
            <td>
                <button @click="deleteProd(product.id)">Delete</button>
            </td>
        </tr>
    </table>
    <br>
    <div style="text-align: center;">
        <router-link to="/product">Add</router-link>
    </div>
    <button @click="logout" style="position: absolute; bottom: 0pt;">Logout</button>
</template>
<script>
export default {
    data() {
        return {
            title: 'Products',
            products: null,
        }
    },
    mounted() {
        axios.get('/productsShow').then(response => {
            if (response.data.error) {
                window.location = '/'
            } else {
                this.products = response.data
            }
        });
    },
    methods: {
        show() {
            axios.get('/productsShow').then(response => {
                if (response.data.error) {
                    window.location = '/'
                } else {
                    this.products = response.data
                }
            });
        },
        getImage(product) {
            return './storage/images/' + product.image
        },
        createLink(id) {
            return '/product/' + id + '/edit'
        },
        deleteProd(id) {
            axios.post('/products', {'id': id}).then(() => {
                    this.show()
            });
        },
        logout() {
            axios.post('/logout').then(() => {
                window.location = '/'
            });
        }
    }
}
</script>
