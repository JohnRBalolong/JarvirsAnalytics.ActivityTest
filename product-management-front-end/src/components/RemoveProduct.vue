<template>
    <div>
      <!-- Add Product Modal -->
      <div
        class="fixed inset-0 z-50 flex items-center justify-center overflow-x-auto overflow-y-scroll"
        style="background-color: rgba(0, 0, 0, 0.5)"
        v-if="showModalremove"
      >
        <div class="bg-white w-1/2 md:w-3/4 lg:w-2/3 xl:w-1/2 rounded-lg p-6">
          <!-- Modal Header -->
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-medium">Remove Product</h2>
            <button class="text-gray-500 hover:text-gray-800" @click="closeModal">
              <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-6 h-6">
                <path
                  fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-9.293a1 1 0 00-1.414-1.414L9 8.586 7.707 7.293a1 1 0 00-1.414 1.414L7.586 10l-1.293 1.293a1 1 0 001.414 1.414L9 11.414l1.293 1.293a1 1 0 001.414-1.414L10.414 10l1.293-1.293z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
          </div>
  
         
       <!-- Modal Content -->
    <div v-if="!isRemovingConfirmed">
      <h1 class="text-lg">{{ productName }} on stock {{ productQuantity }}</h1>
      <br />
      <h1 class="text-lg">How many {{ productName }}'s on stock you want to remove?</h1>
      <br />
      <div class="mb-2">
        <input v-model="quantity" @input="numberOnly" type="text" name="quantity" id="quantity" class="px-2 py-1 h-8 block w-full border shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 border-black rounded-md" />
      </div>
    </div>
    
    
    <div v-else>
        <h1 v-if="quantity < productQuantity" class="text-lg">
        Are you sure you want to remove "{{ quantity }}" {{ productName }}?
      </h1>
      <h1 v-if="quantity >= productQuantity" class="text-lg">
        Are you sure you want to remove all {{ productName }}?
      </h1>
      <!-- <h1 class="text-lg">OK to confirm removing {{ quantity }} {{ productName }}</h1> -->
    </div>
    <!-- Your input fields go here -->
    <div class="flex justify-end mt-4">
      <!-- Modal Footer Buttons -->
      <button
        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
        type="submit"
        @click="isRemovingConfirmed ? removeProduct() : isRemovingConfirmed = true"
      >
        {{ isRemovingConfirmed ? 'OK' : 'Remove' }}
      </button>

              <button
                class="bg-gray-300 text-gray-800 py-2 px-4 rounded hover:bg-gray-400 ml-4"
                type="button"
                @click="closeModal"
              >
                Cancel
              </button>
            </div>
         
        </div>
      </div>
    </div>
  </template>
  


  <script>
  

   import { useProductStore } from '../store/ProductList.js'

  export default {
    name: "RemoveProduct",
    props: {
      showModalremove: {
        type: Boolean,
        required: true,
      },
      productId: {
        type: Number,
        required: true,
      },
      productName: {
        type: String,
        required: true,
      },
      productQuantity: {
        type: Number,
        required: true,
      },
    },
    data() {
      return {
        quantity: "",
        isRemovingConfirmed: false,
      };
    },
    methods: {
      closeModal() {
        this.$emit("updateremove:show-modalremove", false);
      },
  
      // implement remove product logic
      async removeProduct() {
    const { productId, productQuantity } = this;
    const newvalue = productQuantity - this.quantity;

    // Your logic to remove the product here
    if (this.quantity < productQuantity) {
        const payload = { id: productId, quantity: newvalue };
        const success = await useProductStore().updateProductonRemove(productId, payload);
        
        if (success) {
           // console.log('Updated successfully');
            this.closeModal();
             // find way to reaload the Table body after removinf / updating the data
          


        } else {
            console.error('Failed to Update');
        }
    } else {
        const success = await useProductStore().Remove(productId);

        if (success) {
           // console.log('Removed successfully');
            this.closeModal();

            // find way to reaload the Table body after removinf / updating the data
           
        } else {
            console.error('Failed to Remove');
        }
    }
},
  
      numberOnly(event) {
        const enteredValue = event.target.value.replace(/[^\d]/g, "");
        const maxQuantity = this.productQuantity;
        if (enteredValue > maxQuantity) {
          event.target.value = maxQuantity;
          this.quantity = maxQuantity;
        } else {
          event.target.value = enteredValue;
          this.quantity = enteredValue;
        }
      },


    },
  };
  </script>