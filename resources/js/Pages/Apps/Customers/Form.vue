<template>

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="fw-bold">Full Name</label>
        <input class="form-control" v-model="form.name" :class="{ 'is-invalid': errors.name }" type="text" placeholder="Full Name">
      </div>
      <div v-if="errors.name" class="alert alert-danger">
        {{ errors.name }}
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label class="fw-bold">No. Telp</label>
        <input class="form-control" v-model="form.no_telp" :class="{ 'is-invalid': errors.no_telp }" type="text" placeholder="No. Telp">
      </div>
      <div v-if="errors.no_telp" class="alert alert-danger">
        {{ errors.no_telp }}
      </div>
    </div>
  </div>
  <div class="mb-3">
    <label class="fw-bold">Address</label>
    <textarea class="form-control" v-model="form.address" :class="{ 'is-invalid': errors.address }" type="text" rows="4" placeholder="Address"></textarea>
  </div>
  <div v-if="errors.address" class="alert alert-danger">
    {{ errors.address }}
  </div>
  <div class="row">
    <div class="col-12">
      <button class="btn btn-primary shadow-sm rounded-sm" @click="submitData">SAVE</button>
      <button class="btn btn-warning shadow-sm rounded-sm ms-3" type="reset">RESET</button>
    </div>
  </div>

</template>

<script setup>
import { reactive } from 'vue';

const props = defineProps({
  errors: Array,
  customer: {
    type: Object,
    default(rawProps) {
      return {
        name: '',
        no_telp: '',
        address: ''
      }
    }
  }
});

const form = reactive({
  name: props.customer.name,
  no_telp: props.customer.no_telp,
  address: props.customer.address,
});

const emit = defineEmits(["onSubmitData"]);

const submitData = (event) => {
  emit("onSubmitData", form);
}
</script>