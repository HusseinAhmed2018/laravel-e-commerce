<template>
    <div>
        <a class="btn btn-dark my-2" role="button" v-on:click="add_to_cart(productId)">Add to Cart</a>
    </div>
</template>

<script>
    import {bus} from "../app";

    export default {
        name : "AddToCartComponent",

        props: [
            "productId"
        ],
        data(){
            return {
            }
        },
        mounted() {
            console.log(this)
        },
        created() {
            console.log('Component created.' + this.productId)
        },
        methods:{
            add_to_cart(id)
            {
                axios.post('api/cart', {'id': id})
                    .then(function (response) {

                        bus.$emit('itemsCount', response.data.cart.totalQty)
                        alert(response.data.message)
                    })
                    .catch(error => {

                        if (error.response.status == 422) {
                            this.error = error.response.data.errors;
                        }
                    });
            }
        }
    }
</script>
