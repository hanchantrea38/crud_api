<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-md p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Categories</h1>
      <button @click="openCreateModal" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
        Add Category
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-4">
      Loading...
    </div>

    <!-- Categories Table -->
    <table v-else class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
          <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="category in categories" :key="category.id">
          <td class="px-6 py-4 whitespace-nowrap">{{ category.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap">{{ category.desc }}</td>
          <td class="px-6 py-4 whitespace-nowrap">
            <span :class="category.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
              {{ category.is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <button @click="editCategory(category)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
            <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <Teleport to="body">
      <!-- Create/Edit Modal -->
      <div v-if="showCreateModal || editingCategory" class="fixed inset-0 z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-gray-700/75" aria-hidden="true" @click="closeModal"></div>
        <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
          <div class="w-full max-w-lg overflow-hidden rounded-lg bg-white text-left shadow-xl">
          <form @submit.prevent="saveCategory">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ editingCategory ? 'Edit Category' : 'Create Category' }}</h3>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input v-model="form.name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea v-model="form.desc" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
              </div>
              <div class="mb-4">
                <label class="flex items-center">
                  <input v-model="form.is_active" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600">
                  <span class="ml-2 text-gray-700">Active</span>
                </label>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                {{ editingCategory ? 'Update' : 'Create' }}
              </button>
              <button @click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
              </button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const categories = ref([]);
const loading = ref(true);
const showCreateModal = ref(false);
const editingCategory = ref(null);
const form = ref({
  name: '',
  desc: '',
  is_active: true
});

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/categories');
    categories.value = response.data.data;
  } catch (error) {
    console.error('Error fetching categories:', error);
  } finally {
    loading.value = false;
  }
};

const openCreateModal = () => {
  editingCategory.value = null;
  form.value = { name: '', desc: '', is_active: true };
  showCreateModal.value = true;
};

const saveCategory = async () => {
  try {
    const data = {
      name: form.value.name,
      desc: form.value.desc,
      is_active: form.value.is_active ? 1 : 0
    };

    if (editingCategory.value) {
      await axios.put(`/api/categories/${editingCategory.value.id}`, data);
    } else {
      await axios.post('/api/categories', data);
    }
    closeModal();
    fetchCategories();
  } catch (error) {
    alert('Error saving category: ' + (error.response?.data?.message || error.message));
    console.error('Error saving category:', error);
  }
};

const editCategory = (category) => {
  editingCategory.value = category;
  form.value = { 
    name: category.name,
    desc: category.desc,
    is_active: !!category.is_active 
  };
  showCreateModal.value = true;
};

const deleteCategory = async (id) => {
  if (confirm('Are you sure you want to delete this category?')) {
    try {
      await axios.delete(`/api/categories/${id}`);
      fetchCategories();
    } catch (error) {
      console.error('Error deleting category:', error);
    }
  }
};

const closeModal = () => {
  showCreateModal.value = false;
  editingCategory.value = null;
  form.value = { name: '', desc: '', is_active: true };
};

onMounted(fetchCategories);
</script>
