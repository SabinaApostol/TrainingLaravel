import { createWebHistory, createRouter } from "vue-router";
import Index from './Pages/Index.vue';
import Cart from './Pages/Cart.vue';
import Login from './Pages/Login.vue';
import Products from './Pages/Products.vue';
import Product from './Pages/Product.vue';
import Orders from './Pages/Orders.vue';
import Order from './Pages/Order.vue';

window.Vue = require('vue');
window.axios = require('axios');

const routes = [
    {
        path: '/',
        name: 'Index',
        component: Index
    },
    {
        path: '/cart',
        name: 'Cart',
        component: Cart
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/products',
        name: 'Products',
        component: Products
    },
    {
        path: '/product/:id/edit',
        name: 'Product',
        component: Product,
        alias: '/product'
    },
    {
        path: '/orders',
        name: 'Orders',
        component: Orders
    },
    {
        path: '/order/:id',
        name: 'Order',
        component: Order
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;
