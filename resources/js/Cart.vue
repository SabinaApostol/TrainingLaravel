<template>
    <h1>{{ title }}</h1>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Remove from cart</th>
        </tr>
        <tr v-for="product in products" :key="product.id">
            <td>{{ product.title }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td><img :src="getImage(product)"/></td>
            <td>
                <button @click="remove(product.id)">Remove</button>
            </td>
        </tr>
    </table>
    <br>
    <form style="text-align: center;">
        <input type="text" placeholder="Name" required v-model="name" class="width">
        <br>
        <input type="email" placeholder="Email" required v-model="email" class="width">
        <br>
        <textarea cols="40" rows="10" required v-model="comments" placeholder="Comments"></textarea>
        <br>
        <button @click="checkout(name, email, comments)">Checkout</button>
        <br>
        <span style="color: red">{{ errorMessage }}</span>
    </form>
    <div style="text-align: center;">
            <router-link to="/">Go to index</router-link>
    </div>
    <router-link to="/login"  style="position: absolute; bottom: 0pt; right: 0pt;">Login</router-link>
</template>
<script>

export default {
    data() {
        return {
            title: 'Cart',
            products: null,
            name: null,
            email: null,
            comments: null,
            errorMessage: ''
        }
    },
    mounted() {
        axios.get('/cartShow').then(response => {
            this.products = response.data
        });
    },
    methods: {
        show() {
            axios.get('/cartShow').then(response => {
                this.products = response.data
            });
        },
        getImage(product) {
            return './storage/images/' + product.image
        },
        remove(id) {
            axios.post('/cart', {'id': id}).then(
                this.show()
            );
        },
        checkout(name, email, comments) {
            axios.post('/cart', {'name': name, 'email': email, 'comments': comments}).then( () => {
                    window.location = '/'
                })
                .catch(() => {
                    this.errorMessage = 'Please complete all required fields correctly!'
                });
        }
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
