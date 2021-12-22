import { createWebHistory, createRouter } from "vue-router";
import Index from './Index.vue';
import Cart from './Cart.vue';
import Login from './Login.vue';
import Products from './Products.vue';
import Product from './Product.vue';
import Orders from './Orders.vue';
import Order from './Order.vue';

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
