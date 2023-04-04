<template>
    <div>
      <!-- Add Product Modal -->
      <div
        class="fixed inset-0 z-50 flex items-center justify-center overflow-x-auto overflow-y-scroll"
        style="background-color: rgba(0, 0, 0, 0.5)"
        v-if="showModaledit"
      >
        <div class="bg-white w-1/2 md:w-3/4 lg:w-2/3 xl:w-1/2 rounded-lg p-6">
          <!-- Modal Header -->
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-medium">Edit Product</h2>
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
       <!-- <h1>{{productId}}</h1> -->
            
        <!-- Modal Content -->

<div class="mb-2">
  <label for="product-name" class="block text-l font-medium text-gray-800 mb-1">Product Name</label>
  <input v-model="productName" type="text" name="product-name" id="product-name" class="px-2 py-1 h-8 block w-full border shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 border-black rounded-md">
  <label :class="{'mb-0': productNameError}" v-show="productNameError" style="color:red">Product name is required.</label>
</div>

<div class="mb-2">
    <label for="price" class="block text-l font-medium text-gray-800 mb-1">Price</label>
    <input v-model="productPrice" @keyup="numberOnly"  type="text" name="price" id="price" class="px-2 py-1 h-8 block w-full border shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 border-black rounded-md">
    <label v-show="productPriceError" style="color:red">Product price is required.</label>
  </div>
  

  <div class="mb-2">
    <label for="expiration-date" class="block text-l font-medium text-gray-800 mb-1">Expiration Date</label>
    <input v-model="expirationDate"   type="date" name="expiration-date" id="expiration-date" class="px-2 py-1 h-8 block w-full border shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 border-black rounded-md" :min="minDate">
    <label v-show="expirationDateError" style="color:red">Date is required.</label>
  </div>

  <div class="mb-2">
  <label for="quality" class="block text-l font-medium text-gray-800 mb-1">Quality</label>
  <input v-model="quality" type="text"  name="quality" id="quality" class=" px-2 py-1 h-8 block w-full border shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 border-black rounded-md">
  <label v-show="qualityError" style="color:red">Product quality is required.</label>
</div>


<!-- To be study on how to set the value of input file. from the API request to the oreginal filename for update reason -->

<!-- <div class="mb-2">
  <label for="image" class="block text-l font-medium text-gray-800 mb-1">Image</label>
  <input ref="imageInput" type="file" name="image" id="image" class="px-2 py-1 h-8 block w-full border shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 border-black rounded-md" accept="image/png, image/jpeg" @change="handleImageInput">
  <img v-if="imageUrl" :src="imageUrl" alt="Current Image" class="max-w-full h-auto mt-2">
  <label v-show="imageError" style="color:red">{{ imageErrorMessage }}</label>
</div> -->

<!-- <div class="mb-2">
  <label for="image" class="block text-l font-medium text-gray-800 mb-1">Image</label>
  <input v-model="image" type="file" name="image"  id="image" class="px-2 py-1 h-8 block w-full border shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 border-black rounded-md" accept="image/png, image/jpeg" @change="handleImageInput">
  <label v-show="imageError" style="color:red">{{ imageErrorMessage }}</label>
</div> -->

    
    
   
    <!-- Your input fields go here -->
    <div class="flex justify-end mt-4">
      <!-- Modal Footer Buttons -->
      <button
  class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
  type="submit"
  @click="Update"
>
  Save
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

//   import { EditProduct } from '../store/ProductList.js';

   import { useProductStore } from '../store/ProductList.js'

   export default {
    name: "EditProduct",

    props: {
      showModaledit: {
        type: Boolean,
        required: true,
      },
      productId: {
        type: Number,
        required: true,
      },
    },

    methods: {
      closeModal() {
        this.$emit("updateedit:show-modaledit", false);
      },
      handleImageInput(event) {
        
  const file = event.target.files[0];
  const fileExtension = file.name.split('.').pop().toLowerCase();
  if (fileExtension !== 'jpg' && fileExtension !== 'jpeg' && fileExtension !== 'png') {
    this.imageError = true;
    this.imageErrorMessage = "Invalid file type. Please select a JPG or PNG image.";
    this.image = null;
  } else {
    this.image = file;
    this.imageError = false;
    this.imageErrorMessage = "";
  }
},

numberOnly(event) {
  const pattern = /^[0-9]*\.?[0-9]*$/;
  if (!pattern.test(event.target.value)) {
    event.target.value = event.target.value.replace(/[^\d]/g, '');
    this.productPrice = event.target.value;
  }
},

async Update() {
  var error = false;

  if (this.productName === "") {
    this.productNameError = true;
    error = true;
  } else {
    this.productNameError = false;
  }

  if (this.productPrice === "") {
    this.productPriceError = true;
    error = true;
  } else {
    this.productPriceError = false;
  }

  if (this.expirationDate === "") {
    this.expirationDateError = true;
    error = true;
  } else if (new Date(this.expirationDate) < new Date()) {
    this.expirationDateError = true;
    error = true;
  } else {
    this.expirationDateError = false;
  }

  if (this.quality === "") {
    this.qualityError = true;
    error = true;
  } else {
    this.qualityError = false;
  }

  if (this.image === null) {
    this.imageError = true;
    error = true;
  } else {
    this.imageError = false;
  }

  if (error) {
    return;
  } else {
    const productData = {
      productName: this.productName,
      productPrice: this.productPrice,
      expirationDate: this.expirationDate,
      quality: this.quality,
    };

    const { productId } = this;

    const formData = new FormData();
    formData.append("product-name", productData.productName);
    formData.append("price", productData.productPrice);
    formData.append("expiration-date", productData.expirationDate);
    formData.append("quality", productData.quality);
    // formData.append("image", this.image);

    const success = await useProductStore().UpdateItem(productId,formData);

    
    if (success) {
      console.log('Product Updated successfully');
      this.closeModal();
       // find way to reaload the Table body after removinf / updating the data
    

    } else {
      console.error('Failed to add product');
    }
  }
},















    },

    data() {
      return {
        productName: "",
        productNameError: false,
        productPrice: "",
        productPriceError: false,
        expirationDate: "",
        expirationDateError: false,
        quality: "",
        qualityError: false,
        image: null,
        imageError: false,
        imageErrorMessage: "Invalid file type. Please select a JPG or PNG image.",

      };
    },


    computed: {
      minDate() {
        const today = new Date().toISOString().split("T")[0];
        return today;
      },
    },

    async mounted() {
  const productStore = useProductStore();
  const product = await productStore.editpull(this.productId);

  // Assign the properties to the corresponding variables
  this.productName = product['product-name'];
  this.productPrice = product.price;
  this.expirationDate = product['expiration-date'];
  this.quality = product.quality;
  this.image = product.image;

//  console.log(this.productName);

},


















  

   }

</script>















