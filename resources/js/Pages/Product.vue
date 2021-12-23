<template>
    <h1>{{ doc_title }}</h1>
    <form style="text-align: center;" @submit.prevent="submit(title, description, price, file)">
        <input class="width" type="text" name="title" v-model="title" placeholder="Title">
        <br>
        <small style="color: red">{{ error_title }}</small>
        <br>
        <input class="width" type="text" name="description" v-model="description" placeholder="Description">
        <br>
        <small style="color: red">{{ error_description }} </small>
        <br>
        <input class="width" type="number" step="0.01" name="price" v-model="price" placeholder="Price">
        <br>
        <small style="color: red">{{ error_price }} </small>
        <br>
        <input type="file" name="file" @change="selectFile" multiple>
        <button type="submit">Checkout</button>
        <br>
        <small style="color: red">{{ error_file }} </small>
    </form>
    <button @click="logout" style="position: absolute; bottom: 0pt;">Logout</button>
</template>
<script>
export default {
    data() {
        return {
            doc_title: 'Add/Edit product',
            path: [],
            product: null,
            title: null,
            description: null,
            price: null,
            file: null,
            error_title: null,
            error_description: null,
            error_price: null,
            error_file: null,
            errors: [],
            uri:null
        }
    },
    mounted() {
        this.path = window.location.pathname.split('/')
        if (this.path !== '/product') {
            axios.get('/productShow/' + this.path[2] + '/edit').then(response => {
                    if (response.data.error) {
                        window.location = '/'
                    } else {
                        this.product = response.data
                        this.title = this.product.title
                        this.description = this.product.description
                        this.price = this.product.price
                    }
                });
        }
    },
    methods: {
        show() {
            axios.get('/productShow').then(response => {
                if (response.data.error) {
                    window.location = '/'
                } else {
                    console.log(response)
                }
            });
        },
        getImage(product) {
            return './storage/images/' + product.image
        },
        selectFile(event) {
            this.file = event.target.files[0];
        },
        async submit(title, description, price, file) {
            this.path = window.location.pathname.split('/')
            this.uri = 'product/' + this.path[2]
            const data = new FormData();
            data.append('title', title);
            data.append('description', description);
            data.append('price', price);
            if (window.location.pathname === '/product') {
                data.append('file', file);
                axios.post('product', data).then(() => {
                   window.location = '/products'
                }).catch((error) => {
                    console.error(error)
                    this.error_title = error.response.data.error.title
                    this.error_description = error.response.data.error.description
                    this.error_price = error.response.data.error.price
                    this.error_file = error.response.data.error.file[0]
                });
            } else {
                if (file) {
                    data.append('file', file)
                }
                axios.post('/productUpdate/' + this.path[2], data).then(() => {
                    window.location = '/products'
                }).catch((error) => {
                    console.error(error)
                    this.error_title = error.response.data.error.title[0]
                    this.error_description = error.response.data.error.description[0]
                    this.error_price = error.response.data.error.price[0]
                    this.error_file = error.response.data.error.file[0]
                });
            }
        },
        logout() {
            axios.post('/logout').then(() => {
                window.location = '/'
            });
        }
    }
}
</script>
