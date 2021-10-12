<template>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"> </th>
                        <th scope="col">Product</th>
                        <th scope="col">Available</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-right">Price</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products">
                        <td><img src="https://dummyimage.com/50x50/55595c/fff" /> </td>
                        <td>{{ product.item.name }}</td>
                        <td>In stock</td>
                        <td>
                            <div class="input-group number-spinner">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" id="dwn-btn" v-on:click="dwn(product.item.id , $event)">-</button>
                                </span>
                                    <input type="text" class="form-control text-center" v-model=" product.qty ">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" data-dir="up" v-on:click="up(product.item.id , $event)">+</button>
                                </span>
                            </div>
<!--                            <input class="form-control" type="text" v-model=" product.qty " />-->
                        </td>
                        <td class="text-right">{{ product.price }} €</td>
                        <td class="text-right"><button class="btn btn-sm btn-danger" v-on:click="remove(product.item.id , $event)">x</button> </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong>{{ totalPrice }} €</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    <a class="btn btn-block btn-light" href="/">Continue Shopping</a>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <button class="btn btn-lg btn-block btn-success text-uppercase">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {bus} from "../app";

export default {
    name: "CartDetailsComponent",
    data() {
        return{
            cartPage : false,
            products : [],
            scrolled: false,
            totalPrice : Number
        }
    },
    methods: {
        get_cart_item(){
            var  vm = this;

            axios.get('/api/old_cart/').then(response => {

                var cart_items = [];
                var totalPrice = 0;
                var totalQty = 0;

                if (response.data.cart != null)
                {
                    var cart_items = response.data.cart.items;
                    totalPrice = response.data.cart.totalPrice;
                    totalQty = response.data.cart.totalQty
                }

                vm.products = [];
                vm.totalPrice = totalPrice;

                $.each( cart_items, function( key, value ) {
                    vm.products.push(value);
                });

                bus.$emit('itemsCount', totalQty)
            });
        },
        dwn : function(id,event)
        {
            axios.get('/api/reduce/' + id).then(response => {

                var oldValue = $(event.target).closest('.number-spinner').find('input').val().trim();
                var newVal = 0;

                if (oldValue > 1) {
                    newVal = parseInt(oldValue) - 1;
                } else {
                    newVal = 1;
                }

                $(event.target).closest('.number-spinner').find('input').val(newVal);

                this.get_cart_item();
            });
        },
        up : function(id,event)
        {

            axios.get('/api/increase/' + id).then(response => {

                var oldValue = $(event.target).closest('.number-spinner').find('input').val().trim();
                var newVal = 0;

                newVal = parseInt(oldValue) + 1;

                $(event.target).closest('.number-spinner').find('input').val(newVal);

                this.get_cart_item();
            });
        },
        remove : function(id,event)
        {

            axios.get('/api/remove/' + id).then(response => {

                this.get_cart_item();
            });
        },
    },
    created() {
        this.get_cart_item();

    }
}
</script>

<style scoped>

</style>
