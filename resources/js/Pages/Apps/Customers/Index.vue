<template>
  <LayoutApp>

    <Head>
      <title>Customers - Aplikasi Kasir</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-user-circle"></i> CUSTOMERS</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">
                                        <Link href="/apps/customers/create" v-if="hasAnyPermission(['customers.create'])" class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                                        <input v-model="search" type="text" class="form-control" placeholder="search by customer name...">

                                        <button class="btn btn-primary input-group-text" type="submit"> <i class="fa fa-search me-2"></i> SEARCH</button>

                                    </div>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">No. Telp</th>
                                            <th scope="col">Address</th>
                                            <th scope="col" style="width:20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(customer, index) in customers.data" :key="index">
                                            <td>{{ customer.name }}</td>
                                            <td>{{ customer.no_telp }}</td>
                                            <td>{{ customer.address }}</td>
                                            <td class="text-center">
                                                <Link href="#" v-if="hasAnyPermission(['customers.edit'])" class="btn btn-success btn-sm me-2"><i class="fa fa-pencil-alt me-1"></i> EDIT</Link>
                                                <button v-if="hasAnyPermission(['customers.delete'])" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="customers.links" align="end"/>
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
import Pagination from "../../../Components/Pagination.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "@vue/reactivity";
import { Inertia } from "@inertiajs/inertia";

defineProps({
  customers: Array
});

const search = ref(''|| (new URL(document.location)).searchParams.get('q'));

const handleSearch = () => {
  Inertia.get("/apps/customers", {
    q: search.value
  });
}
</script>