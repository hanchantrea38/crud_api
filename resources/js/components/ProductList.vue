<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-md p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Products</h1>
      <button @click="openCreateModal" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
        Add Product
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-4">
      Loading...
    </div>

    <!-- Products Table -->
    <table v-else class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
          <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="product in products" :key="product.id">
          <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ product.category?.name || 'N/A' }}</td>
          <td class="px-6 py-4 whitespace-nowrap">${{ product.price }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ product.qty }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <button @click="editProduct(product)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
            <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Create/Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-700/75" aria-hidden="true" @click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative z-10 w-full max-w-lg overflow-hidden rounded-lg bg-white text-left shadow-xl">
          <form @submit.prevent="saveProduct">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ editingProduct ? 'Edit Product' : 'Create Product' }}</h3>
              
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <select v-model="form.category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                  <option value="">Select Category</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input v-model="form.name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea v-model="form.description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                  <input v-model="form.price" type="number" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Quantity</label>
                  <input v-model="form.qty" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                {{ editingProduct ? 'Update' : 'Create' }}
              </button>
              <button @click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const products = ref([]);
const categories = ref([]);
const loading = ref(true);
const showModal = ref(false);
const editingProduct = ref(null);
const form = ref({
  category_id: '',
  name: '',
  description: '',
  price: 0,
  qty: 0
});

const fetchData = async () => {
  try {
    const [prodRes, catRes] = await Promise.all([
      axios.get('/api/products'),
      axios.get('/api/categories')
    ]);
    products.value = prodRes.data.data;
    categories.value = catRes.data.data;
  } catch (error) {
    console.error('Error fetching data:', error);
  } finally {
    loading.value = false;
  }
};

const openCreateModal = () => {
  editingProduct.value = null;
  form.value = { category_id: '', name: '', description: '', price: 0, qty: 0 };
  showModal.value = true;
};

const editProduct = (product) => {
  editingProduct.value = product;
  form.value = { 
    category_id: product.category_id,
    name: product.name,
    description: product.description,
    price: product.price,
    qty: product.qty
  };
  showModal.value = true;
};

const saveProduct = async () => {
  try {
    const data = {
      category_id: form.value.category_id,
      name: form.value.name,
      description: form.value.description,
      price: form.value.price,
      qty: form.value.qty
    };

    if (editingProduct.value) {
      await axios.put(`/api/products/${editingProduct.value.id}`, data);
    } else {
      await axios.post('/api/products', data);
    }
    closeModal();
    fetchData();
  } catch (error) {
    alert('Error saving product: ' + (error.response?.data?.message || error.message));
    console.error('Error saving product:', error);
  }
};

const deleteProduct = async (id) => {
  if (confirm('Are you sure you want to delete this product?')) {
    try {
      await axios.delete(`/api/products/${id}`);
      fetchData();
    } catch (error) {
      console.error('Error deleting product:', error);
    }
  }
};

const closeModal = () => {
  showModal.value = false;
  editingProduct.value = null;
};

onMounted(fetchData);
</script>
