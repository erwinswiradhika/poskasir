<template>
  <LayoutApp>
    <Head>
      <title>Add New Customer - Aplikasi Kasir</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-user-circle"></i> ADD NEW CUSTOMER</span>
                            </div>
                            <div class="card-body">

                                <Form @onSubmitData="saveCustomer($event)" :errors="errors" />
                          
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
import LayoutApp from "../../../Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Form from './Form.vue';
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";

const props = defineProps({
  errors: Object
});

const saveCustomer = (value) => {
  Inertia.post("/apps/customers", value, {
    onSuccess: () => {
      Swal.fire({
        title: 'Success!',
        text: 'Customer saved successfully.',
        icon: 'success',
        showConfirmButton: false,
        timer: 2000
      });
    }
  });
}
</script>