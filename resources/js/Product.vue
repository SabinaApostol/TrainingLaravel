<template>
    <h1>{{ doc_title }}</h1>
    <form style="text-align: center;" @submit="save">
        <input class="width" type="text" name="title" v-model="title" placeholder="Title">
        <br>
        <input class="width" type="text" name="description" v-model="description" placeholder="Description">
        <br>
        <input class="width" type="number" step="0.01" name="price" v-model="price" placeholder="Price">
        <br>
        <input type="file" name="file" @change="selectFile" multiple>
        <button type="submit" value="Submit">Checkout</button>
        <br>
        <span style="color: red">{{ errorMessage }}</span>
    </form>
    <p v-if="errors.length">
        <b>Please correct the following error(s):</b>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
    </p>
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
            errorMessage: null,
            errors: [],
            uri:null
        }
    },
    mounted() {
        this.path = window.location.pathname.split('/')
        this.uri = 'product/' + this.path[2]
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
        save() {
            this.errors = [];
            if (!this.title) {
                this.errors.push('Title required.');
            }
            if (!this.description) {
                this.errors.push('Description required.');
            }
            if (!this.price) {
                this.errors.push('Price required.');
            }
            if (this.title && this.description && this.price) {
                const data = new FormData();
                data.append('title', this.title);
                data.append('description', this.description);
                data.append('price', this.price);
                if (window.location.pathname === '/product') {
                    if (!this.file) {
                        this.errors.push('Image required.');
                    }
                    data.append('file', this.file);
                    axios.post('product', data).then(response => {
                        if (response.data.error) {
                            this.errorMessage = response.data.errorMessage;
                        } else {
                            window.location = '/products'
                        }
                    }).catch(() => {
                        this.errorMessage = 'Please complete correctly all required fields!';
                    });
                } else {
                    if (this.file) {
                        data.append('file', this.file)
                    }
                    axios.post('/productUpdate/' + this.path[2], data).then(response => {
                        if (response.data.error) {
                            this.errorMessage = response.data.errorMessage;
                        } else {
                            window.location = '/products'
                        }
                    }).catch(() => {
                        this.errorMessage = 'Please complete correctly all required fields!';
                    });
                }
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
