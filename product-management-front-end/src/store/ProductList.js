import { defineStore } from 'pinia'
import axios from 'axios'




export const useProductStore = defineStore({
    id: 'product',
    state: () => ({
        products: [],
        error: null
    }),
    actions: {
        async fetchProducts() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/product/')
                this.products = response.data.product
                    // console.log('Fetched products:', this.products)
                this.error = null
            } catch (error) {
                console.error('Error fetching products:', error)
                if (error.message === 'Network Error') {
                    this.error = 'Can\'t access the server. Please check your network connection and try again.'
                } else {
                    this.error = 'No product found.'
                }
            }
        },

        async addProduct(productData) {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/product/', productData);
                // If the request was successful, add the new product to the store's list of products
                this.products.push(response.data);
                return true;
            } catch (error) {
                console.error('Error adding product:', error);
                if (error.response.status === 422) {
                    // If the request failed due to validation errors, set the error state of the store
                    this.error = error.response.data.error;
                }
                return false;
            }
        },
        // update quantity of the product after remove
        async updateProductonRemove(productId, payload) {
            try {
                const response = await axios.post(`http://127.0.0.1:8000/api/product/${productId}/editquantity`, payload);
                this.products.push(response.data);
                return true;
            } catch (error) {
                console.error('Error updating product:', error);
                if (error.response.status === 422) {
                    this.error = error.response.data.error;
                }
                return false;
            }
        },

        // remove product
        async Remove(productId) {
            //console.log('Removing product with ID:', productId);
            try {
                const response = await axios.delete(`http://127.0.0.1:8000/api/product/${productId}/delete`);
                this.products.push(response.data);
                return true;
            } catch (error) {
                console.error('Error deleting product:', error);
                if (error.response.status === 422) {
                    this.error = error.response.data.error;
                }
                return false;
            }
        },


        // Edit product. API request pull data get().
        async editpull(productId) {
            //  console.log(productId);
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/product/${productId}/edit`);

                const product = response.data.product;
                //   console.log(product);

                // Assign the properties to the corresponding variables
                this.productName = product['product-name'];
                this.productPrice = product.price;
                this.expirationDate = product['expiration-date'];
                this.quality = product.quality;
                this.image = product.image;
                //  console.log(this.productName);
                return product; // Return the product object
            } catch (error) {
                console.error('Error updating product:', error);
                if (error.response.status === 422) {
                    this.error = error.response.data.error;
                }
                return null; // Return null to indicate an error
            }
        },


        // Update the product Item
        async UpdateItem(productId, productData) {
            // console.log(productId);
            try {
                const response = await axios.post(`http://127.0.0.1:8000/api/product/${productId}/edit`, productData);
                this.products.push(response.data);
                return true;
            } catch (error) {
                console.error('Error updating product:', error);
                if (error.response.status === 422) {
                    this.error = error.response.data.error;
                }
                return false;
            }
        },













    }
})