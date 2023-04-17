<template>
  <div class="bg-green-200 min-h-screen">
    <AppNavbar />
    <div class="overflow-x-auto">
      <div class="flex-1 p-4">
        <router-view />
      </div>

      <div class="flex-1 p-4">
        <ul v-if="$route.path === '/'" class="flex flex-wrap -mx-4">
          <li v-for="product in products" :key="product.id" class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 px-4 mb-4">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg">
              <div class="relative max-w-xs mx-auto" style="height: 256px;">
                <div class="absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: 'url(' + product.image + ')', filter: 'blur(5px)' }"></div>
                <img :src="product.image" alt="Product Image" class="w-full h-full object-contain z-20 rounded-md" style="position: relative; padding: 8px; border-radius: 8px;">
              </div>
              <div class="p-4">
                <p class="text-gray-600 font-bold inline-block w-1/4">{{ product['product-name'] }}</p>
                <p class="text-gray-600 font-bold inline-block w-3/4 text-right">Price: {{ product.price }}php</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import AppNavbar from './components/Navbar.vue'
import { useProductStore } from './store/ProductList.js'

export default {
  name: 'App',
  components: {
    AppNavbar,
  },
  data() {
    return {
      products: [],
    }
  },
  async created() {
    const productStore = useProductStore()
    await productStore.fetchProducts() // Wait for the fetchProducts action to complete
    this.products = productStore.products // Populate the products data in the component
  },
}
</script>
