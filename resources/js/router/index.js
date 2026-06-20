import { createRouter, createWebHistory } from 'vue-router';
import CategoryList from '../components/CategoryList.vue';
import ProductList from '../components/ProductList.vue';
import CustomerList from '../components/CustomerList.vue';
import MovieList from '../components/MovieList.vue';

const routes = [
  {
    path: '/',
    redirect: '/categories'
  },
  {
    path: '/categories',
    name: 'categories.index',
    component: CategoryList
  },
  {
    path: '/products',
    name: 'products.index',
    component: ProductList
  },
  {
    path: '/customers',
    name: 'customers.index',
    component: CustomerList
  },
  {
    path: '/movies',
    name: 'movies.index',
    component: MovieList
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
