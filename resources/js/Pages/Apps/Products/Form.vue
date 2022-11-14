<template>
    <div class="mb-3">
          <input class="form-control" @input="form.image = $event.target.files[0]" :class="{ 'is-invalid': errors.image }" type="file">
      </div>
      <div v-if="errors.image" class="alert alert-danger">
        {{ errors.image }}
      </div>

      <div class="row">
          <div class="col-md-6">
              <div class="mb-3">
                  <label class="fw-bold">Barcode</label>
                  <input class="form-control" v-model="form.barcode" :class="{ 'is-invalid': errors.barcode }" type="text" placeholder="Barcode / Code Product">
              </div>
              <div v-if="errors.barcode" class="alert alert-danger">
                  {{ errors.barcode }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                  <label class="fw-bold">Category</label>
                  <select class="form-select" :class="{ 'is-invalid': errors.category_id }" v-model="form.category_id">
                      <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.name }}</option>
                  </select>
              </div>
              <div v-if="errors.category_id" class="alert alert-danger">
                  {{ errors.category_id }}
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col-md-6">
              <div class="mb-3">
                  <label class="fw-bold">Title Product</label>
                  <input class="form-control" v-model="form.title" :class="{ 'is-invalid': errors.title }" type="text" placeholder="Title Product">
              </div>
              <div v-if="errors.title" class="alert alert-danger">
                  {{ errors.title }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                  <label class="fw-bold">Stock</label>
                  <input class="form-control number-format" v-model="form.stock" :class="{ 'is-invalid': errors.stock }" type="text" placeholder="Stock">
              </div>
              <div v-if="errors.stock" class="alert alert-danger">
                  {{ errors.stock }}
              </div>
          </div>
      </div>

      <div class="mb-3">
          <label class="fw-bold">Description</label>
          <textarea class="form-control" v-model="form.description" :class="{ 'is-invalid': errors.description }" type="text" rows="4" placeholder="Description"></textarea>
      </div>
      <div v-if="errors.description" class="alert alert-danger">
          {{ errors.description }}
      </div>

      <div class="row">
          <div class="col-md-6">
              <div class="mb-3">
                  <label class="fw-bold">Buy Price</label>
                  <input class="form-control number-format" v-model="form.buy_price" :class="{ 'is-invalid': errors.buy_price }" type="text" placeholder="Buy Price">
              </div>
              <div v-if="errors.buy_price" class="alert alert-danger">
                  {{ errors.buy_price }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                  <label class="fw-bold">Sell Price</label>
                  <input class="form-control number-format" v-model="form.sell_price" :class="{ 'is-invalid': errors.sell_price }" type="text" placeholder="Sell Price">
              </div>
              <div v-if="errors.sell_price" class="alert alert-danger">
                  {{ errors.sell_price }}
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col-12">
              <button class="btn btn-primary shadow-sm rounded-sm" @click="submitData">SAVE</button>
              <button class="btn btn-warning shadow-sm rounded-sm ms-3" type="reset">RESET</button>
          </div>
      </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue';

const props = defineProps({
  errors: Object,
  categories: Array,
  product: {
    type: Object,
    default(rawProps) {
        return {
            barcode: '',
            category_id: '',
            title: '',
            stock: '',
            description: '',
            buy_price: '',
            sell_price: '',
        }
    }
  }
});

const emit = defineEmits(["onSubmitData"]);

const form = reactive({
  image: '',
  barcode: props.product.barcode ?? '',
  category_id: props.product.category_id ?? '',
  title: props.product.title ?? '',
  description: props.product.description,
  buy_price: props.product.buy_price,
  sell_price: props.product.buy_price,
  stock: props.product.stock,
});

const submitData = (event) => {
  emit("onSubmitData", form);
}

onMounted(() => {
    form.category_id = props.product.category_id != "" ? props.product.category_id : props.categories[0].id;
});
</script>