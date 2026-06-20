<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-md p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Customers</h1>
      <button @click="openCreateModal" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
        Add Customer
      </button>
    </div>

    <div v-if="loading" class="text-center py-4">Loading...</div>

    <table v-else class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
          <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="customer in customers" :key="customer.id">
          <td class="px-6 py-4 whitespace-nowrap">{{ customer.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ customer.email }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ customer.phone }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ customer.gender }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <button @click="editCustomer(customer)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
            <button @click="deleteCustomer(customer.id)" class="text-red-600 hover:text-red-900">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-700/75" aria-hidden="true" @click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="relative z-10 w-full max-w-lg overflow-hidden rounded-lg bg-white text-left shadow-xl">
          <form @submit.prevent="saveCustomer">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <h3 class="text-lg font-medium text-gray-900 mb-4">{{ editingCustomer ? 'Edit Customer' : 'Create Customer' }}</h3>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input v-model="form.name" type="text" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input v-model="form.email" type="email" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <input v-model="form.phone" type="text" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                <select v-model="form.gender" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">{{ editingCustomer ? 'Update' : 'Create' }}</button>
              <button @click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
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

const customers = ref([]);
const loading = ref(true);
const showModal = ref(false);
const editingCustomer = ref(null);
const form = ref({ name: '', email: '', phone: '', gender: 'Male' });

const fetchCustomers = async () => {
  try {
    const response = await axios.get('/api/customers');
    customers.value = response.data.data;
  } catch (error) {
    console.error('Error fetching customers:', error);
  } finally {
    loading.value = false;
  }
};

const openCreateModal = () => {
  editingCustomer.value = null;
  form.value = { name: '', email: '', phone: '', gender: 'Male' };
  showModal.value = true;
};

const editCustomer = (customer) => {
  editingCustomer.value = customer;
  form.value = { 
    name: customer.name,
    email: customer.email,
    phone: customer.phone,
    gender: customer.gender
  };
  showModal.value = true;
};

const saveCustomer = async () => {
  try {
    const data = { ...form.value };
    if (editingCustomer.value) {
      await axios.put(`/api/customers/${editingCustomer.value.id}`, data);
    } else {
      await axios.post('/api/customers', data);
    }
    closeModal();
    fetchCustomers();
  } catch (error) {
    alert('Error saving customer: ' + (error.response?.data?.message || error.message));
  }
};

const deleteCustomer = async (id) => {
  if (confirm('Are you sure?')) {
    try {
      await axios.delete(`/api/customers/${id}`);
      fetchCustomers();
    } catch (error) {
      console.error('Error deleting customer:', error);
    }
  }
};

const closeModal = () => {
  showModal.value = false;
  editingCustomer.value = null;
};

onMounted(fetchCustomers);
</script>
