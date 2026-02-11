<template>
  <form @submit.prevent="submit">
    <div :class="'d-counter ' + classPrefix + '-counter'">
      <button :class="'d-counter__button ' + classPrefix + '-counter__button'" @click="onMinus">
        <i class="d-icon-minus d-counter__button-icon"></i>
      </button>
      <input
        @input="onEmit"
        type="text"
        v-model="this.d_value"
        class="d-counter__input"
        :min="this.d_min"
        name="count"
        :value="this.d_value"
        :step="d_step"
        :max="this.max"
      />
      <button :class="'d-counter__button ' + classPrefix + '-counter__button'" @click="onPlus">
        <i class="d-icon-plus d-counter__button-icon"></i>
      </button>
    </div>
  </form>
  <teleport to="body">
    <customModal v-model="this.modal_remain" class="product-not-available">
      <img src="/images/icons_milen/outOfStock2.png" alt="" />
      <b>У нас нет столько товаров :(</b>
      <p>Извините, но количество данного товара ограничено</p>
      <button
        class="d-button d-button-primary d-button-primary-small"
        @click="this.modal_remain = false"
      >
        Понятно
      </button>
    </customModal>
  </teleport>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import customModal from '@/shared/ui/Modal.vue'
// import InputNumber from 'primevue/inputnumber'

export default {
  name: 'CounterInput',
  emits: ['ElemCount'],
  props: {
    min: {
      type: Number,
      default: 0,
    },
    max: {
      type: Number,
      default: 999999999,
    },
    value: {
      type: Number,
      default: 0,
    },
    id: {
      type: Number,
      default: 0,
    },
    store_id: {
      type: Number,
      default: 0,
    },
    field: {
      type: String,
      default: '',
    },
    classPrefix: {
      type: String,
      default: 'd',
    },
    index: {
      type: Number,
      default: 0,
    },
    mini: {
      type: Boolean,
      default: false,
    },
    item: {
      type: Object,
      default() {
        return {}
      },
    },
    step: {
      type: Number,
      default: 1,
    },
  },
  data() {
    return {
      loading: true,
      d_min: this.min,
      d_max: this.max,
      d_value: this.value,
      d_step: this.step,
      modal_remain: false,
      debouncedSend: null,
    }
  },
  methods: {
    ...mapActions([]),
    submit() {},
    debounce(func, wait) {
      let timeout
      return (...args) => {
        clearTimeout(timeout)
        timeout = setTimeout(() => {
          func.apply(this, args)
        }, wait)
      }
    },
    onMinus() {
      // Уменьшаем на шаг
      let newValue = this.d_value - this.d_step
      if (newValue < this.d_min) {
        newValue = this.d_min
      }
      if (newValue % this.d_step !== 0) {
        newValue = Math.floor(newValue / this.d_step) * this.d_step
      }
      this.d_value = newValue
      this.debouncedSend()
      console.log('minus')
    },
    onPlus() {
      let newValue = Number(this.d_value) + Number(this.d_step)
      if (newValue > this.d_max) {
        newValue = this.d_max
        this.modal_remain = true
      }
      if (newValue % this.d_step !== 0) {
        newValue = Math.floor(newValue / this.d_step) * this.d_step
      }
      this.d_value = newValue
      console.log('plus')
      this.debouncedSend()
    },
    onEmit() {
      this.d_value = this.d_value.replace(/[^\d]/g, '')
      // Проверяем, что значение не меньше минимального
      if (this.d_value < this.d_min) {
        this.d_value = this.d_min
      }
      if (this.d_value > this.d_max) {
        this.d_value = this.d_max
      }
      // Округляем значение до кратности шагу
      if (this.d_value % this.d_step !== 0) {
        this.d_value = Math.floor(this.d_value / this.d_step) * Number(this.d_step)
      }
      console.log('input')
      this.debouncedSend()
    },
    send() {
      const data = {
        value: this.d_value,
        old_value: this.value,
        id: this.id,
        store_id: this.store_id,
        field: this.field,
        max: this.d_max,
        min: this.d_min,
        index: this.index,
        item: this.item,
      }
      console.log('emit')
      this.$emit('ElemCount', data)
    },
  },
  mounted() {
    this.debouncedSend = this.debounce(this.send, 500)
  },
  components: {
    customModal,
  },
  computed: {
    ...mapGetters([]),
  },
  watch: {
    value(newValue) {
      this.d_value = newValue
    },
  },
}
</script>
<style lang="scss">
.d-counter {
  .d-counter__input {
    color: #282828;
  }
}
.product-not-available {
  .modal-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 300px;
    text-align: center;
  }
  .d-button {
    box-shadow: none;
    display: inline-block;
  }
  b {
    margin: 15px 0;
    display: block;
  }
  p {
    margin-bottom: 10px;
  }
}
</style>
