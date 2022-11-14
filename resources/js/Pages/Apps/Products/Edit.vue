<template>
  <LayoutApp>
    <Head>
      <title>Add New Product - Aplikasi Kasir</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shopping-bag"></i> ADD NEW PRODUCT</span>
                            </div>
                            <div class="card-body">

                                <FormProduct :product="product" @onSubmitData="receiveData($event)" :errors="errors" :categories="categories"></FormProduct>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
  </LayoutApp>
</template>

<script setup>
import LayoutApp from '../../../Layouts/App.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import FormProduct from "./Form.vue"
import { reactive } from 'vue';
import Swal from 'sweetalert2';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  errors: Object,
  categories: Array,
  product: Object
});

function receiveData(value) {
  Inertia.put(`/apps/products/${props.product.id}`, {
    ...value,
    _method: 'PATCH'
  }, {
    onSuccess: () => {
      Swal.fire({
        title: 'Success',
        text: 'Product has been updated',
        icon: 'success'
      })
    }
  });
}
</script>