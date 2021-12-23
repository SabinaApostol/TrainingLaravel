<template>
    <h1>{{ title }}</h1>
    <table>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Image</th>
        <th>Add to cart</th>
    </tr>
    <tr v-for="product in products" :key="product.id">
        <td>{{ product.title }}</td>
        <td>{{ product.description }}</td>
        <td>{{ product.price }}</td>
        <td><img :src="getImage(product)"/></td>
        <td>
            <button @click="add(product.id)">Add</button>
        </td>
    </tr>
    </table>
    <br>
    <div style="text-align: center;">
        <div>
            <router-link to="/cart">Go to cart</router-link>
        </div>
    </div>
    <router-link to="/login" style="position: absolute; bottom: 0pt; right: 0pt;">Login</router-link>
</template>
<script>

export default {
    data() {
        return {
            title: 'List of products',
            products: null,
            loggedIn: false
        }
    },
    mounted() {
        axios.get('/index').then(response => {
            this.products = response.data
        });
    },
    methods: {
        show() {
            axios.get('/index').then(response => {
                this.products = response.data
            });
        },
        getImage(product) {
            return './storage/images/' + product.image
        },
        add(id) {
            axios.post('/', {'id': id}).then(() => {

                    this.show()
            });
        },
        checkIfLogged() {
            return !!this.loggedIn;
        },
    }
}
</script>
<style>
h1 {
    text-align: center;
    font-size: 50pt;
}
table, th, td {
    border: 1px solid #000000;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}
img {
    height: 30px;
    width: 30px;
}
.width {
    width: 300px;
}
.center {
    margin-left: auto;
    margin-right: auto;
}
p, ul {
    text-align: center;
}
.error {
    color: red;
}

</style>
