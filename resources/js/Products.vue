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
                <a :href="createLink(product.id)">Edit</a>
            </td>
            <td>
                <button @click="deleteProd(product.id)">Remove</button>
            </td>
        </tr>
    </table>
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
            return '/product/' + id
        },
        deleteProd(id) {
            axios.post('/products', {'id': id}).then(
                this.show()
            );
        }
    }
}
</script>
