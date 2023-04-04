<template>
    <br />
  
    <h1 class="text-center font-bold text-3xl">Product List</h1>
    <hr class="border border-gray-900 ">
    <br>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-11 z-0">
  
        <button
  class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 mb-2"
  @click="showModal = true"
>
  Add new product
</button>

<!-- <ProductTable
       
      /> -->

  
      <table  class="w-full text-sm text-left text-white dark:text-white">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
          <tr>
            <th scope="col" class="px-6 py-3">
              Product Id
            </th>
            <th scope="col" class="px-6 py-3">
              Product name
            </th>
            <th scope="col" class="px-6 py-3">
              Price
            </th>
            <th scope="col" class="px-6 py-3">
              Quantity
            </th>
            <th scope="col" class="px-6 py-3">
              Expiration date
            </th>
            <th scope="col" class="px-6 py-3">
              Quality
            </th>
  
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <tbody >
          <tr v-if="$product.error" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
            <td colspan="6">
              <div class="px-6 py-4 text-red-500 font-bold text-center">
                {{ $product.error }}
              </div>
            </td>
          </tr>
          <tr v-else  v-for="(product, index) in $product.products" :key="index" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
            <td class="px-6 py-4">
              {{ product.id }}
            </td>
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ product['product-name'] }}
            </th>
            <td class="px-6 py-4">
              {{ product.price }}
            </td>
            <td class="px-6 py-4">
              {{ product.quantity }}
            </td>
            <td class="px-6 py-4">
              {{ product['expiration-date'] }}
            </td>
            <td class="px-6 py-4">
              {{ product.quality }}
            </td>
            <td class="flex items-center px-6 py-4 space-x-3">
              <a @click="showModaledit = true; selectedProduct = product" class="cursor-pointer font-medium text-blue-900 dark:text-blue-600 hover:underline">Edit</a>
  <p>|</p>
  <a @click="showModalremove = true; selectedProduct = product" class="cursor-pointer font-medium text-red-900 dark:text-red-600 hover:underline">Remove</a>

</td>
          </tr>
        </tbody>
      </table>
    </div>

    <AddProductItem :show-modal="showModal" @update:showModal="showModal = $event" v-if="showModal" />

    <EditProduct :show-modaledit="showModaledit" :product-id="selectedProduct.id"  @updateedit:show-modaledit="showModaledit = $event" v-if="showModaledit" />

    <RemoveProduct :show-modalremove="showModalremove" :product-id="selectedProduct.id" :product-name="selectedProduct['product-name']" :product-quantity="selectedProduct.quantity" @updateremove:show-modalremove="showModalremove = $event" v-if="showModalremove" />



</template>





  <script>

  import { useProductStore } from '../store/ProductList.js'
  import {  onMounted } from 'vue'
  import AddProductItem from "@/components/AddProductItem.vue";
  import RemoveProduct from "@/components/RemoveProduct.vue";
  import EditProduct from "@/components/EditProduct.vue"; 

 

  export default {

    components: {
    AddProductItem,
    EditProduct,
    RemoveProduct,
   


  },
  
  



  data() {
    return {
      showModal: false,
      showModaledit: false,
      showModalremove: false,

      // Other data properties go here
    };

  },

    setup() {
      const $product = useProductStore()
  
      onMounted(() => {
        $product.fetchProducts()
      })

      return {
        $product,
      
      }
    }
  }
  </script>
  