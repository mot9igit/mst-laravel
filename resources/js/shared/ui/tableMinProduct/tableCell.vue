<template>
  <div class="d-table-min-product__col-simple" v-if="cell_key != 'name' && cell_key != 'image' && cell_key != 'actions'">
    <div class="d-table-min-product__cell-label">{{ cell_data.label }}</div>
    <div  class="d-table-min-product__cell-value">{{ value[cell_key] }}</div>
  </div>
  <div class="d-table-min-product__col-sales" v-if="cell_key != 'name' && cell_key != 'image' && cell_key == 'actions'">
    <div class="product-card-vertical__promo-all order-product-actions" @click.prevent="this.$emit('saleModal', value)" v-if="countSales(value[cell_key]) > 0">
      <div class="d-table-min-product__cell-label">Акции</div>
      <div  class="red-badge">{{ countSales(value[cell_key]) }}</div>
      <i class="d-icon-arrow-right product-card-vertical__seller-button-icon"></i>
    </div>
  </div>
</template>

<script>

export default {
  name: 'tableCell',
  emits: [
    "saleModal"
  ],
  props: {

    cell_data: {
      type: Object,
      default: () => {
        return {}
      },
    },
    cell_key: {
      type: String,
      default: null,
    },
    value: {
      type: Object,
      default: () => {
        return {}
      },
    },
    link_params: {
      type: Object,
      default: () => {
        return {}
      },
    },

  },
  data() {
    return {
      blank: {},
      numbers: {},
      chart_options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            display: false,
          },
          title: {
            display: false,
            text: 'График',
          },
        },
      },
      widths: {},
    }
  },
  computed: {
    isChecked: {
      get() {
        return this.selectedItems.includes(this.value.id)
      },
      set(value) {
        console.log(value)
        // Пустой сеттер, так как изменения обрабатываются в toggleSelection
      },
    },
    linkParams() {
      const linkparams = {}
      if (this.cell_data.type === 'link') {
        for (const key in this.cell_data.link_params) {
          if (
            this.cell_data.link_params[key] !== 'id' &&
            this.cell_data.link_params[key] !== 'store_id' &&
            this.cell_data.link_params[key] !== 'vendor_id' &&
            this.cell_data.link_params[key] !== 'pagetitle'
          ) {
            linkparams[key] = this.cell_data.link_params[key]
          } else {
            linkparams[key] = this.value[this.cell_data.link_params[key]]
          }
        }
      }
      return linkparams
    },
  },
  methods: {
    countSales(sale){
      let count = 0
      for(var i in sale){
        if(sale[i].enabled == 1){
          count++
        }
      }
      return count
    },
    toggleSelection(id) {
      console.log(id)
      if (this.selectedItems.includes(id)) {
        // console.log('da')
        // console.log(this.selectedItems.filter(item => item !== id))
        this.$emit(
          'checkElem',
          this.selectedItems.filter((item) => item !== id),
        )
        // this.selectedItems = this.selectedItems.filter(item => item !== id);
      } else {
        // console.log('net')
        // this.selectedItems.push(id)
      }
      // const newSelectedItems = [...this.selectedItems]
      // const itemId = this.value.id
      // const index = newSelectedItems.indexOf(itemId)

      // if (index === -1) {
      //   // Добавляем элемент
      //   newSelectedItems.push(itemId)
      // } else {
      //   // Удаляем элемент
      //   newSelectedItems.splice(index, 1)
      // }

      // // Эмитим событие для обновления selectedItems в родительском компоненте
      // this.$emit('update:selectedItems', newSelectedItems)
    },
    actionElem(action) {
      if (action === 'delete') {
        this.$emit('deleteElem', this.value)
      }
      if (action === 'update') {
        this.$emit('updateElem', this.value)
      }
      if (action === 'edit') {
        this.$emit('editElem', this.value)
      }
      if (action === 'click') {
        this.$emit('clickElem', this.value)
      }
      if (action === 'approve') {
        this.$emit('approveElem', this.value)
      }
      if (action === 'disapprove') {
        this.$emit('disapproveElem', this.value)
      }
      if (action === 'view') {
        this.$emit('viewElem', this.value)
      }
    },
    editValue(number, name) {
      this.$emit('editNumber', { value: number, id: this.value.id, name: name })
    },
    actionCell(id) {
      this.$emit('actionCell', id)
    },
    prepareHtml(code){
      if(code){
        let new_string = code.replace(/<(.|\n)*?>/g, ' ')
        new_string = new_string.replace(/\&nbsp;/g, ' ')
        new_string = new_string.replace(/\n/g, '')
        if(new_string.length > 120){
          new_string = new_string.substring(0,120)+"..."
        }

        return new_string
      }else{
        return ''
      }

    },
  },
  components: {

  },
  mounted() {
    this.blank = this.cell_data
    if (this.blank.type === 'actions') {
      for (const key in this.blank.available) {
        if (
          Object.prototype.hasOwnProperty.call(this.blank.available[key], 'link') &&
          Object.prototype.hasOwnProperty.call(this.blank.available[key], 'link_values')
        ) {
          if (this.blank.available[key].link && this.blank.available[key].link_values) {
            const link = this.blank.available[key].link
            const values = this.blank.available[key].link_values
            if (!values.includes(Number(this.value[link]))) {
              delete this.blank.available[key]
            }
          }
        }
      }
    }
    if (this.cell_data.type === 'number') {
      this.numbers[this.cell_key] = this.value[this.cell_key]
    }
  },
  unmounted() {
    this.numbers[this.cell_key] = this.value[this.cell_key]
  },
}
</script>

<style lang="scss">
  .d-table-min-product__col-sales{
    position: absolute;
    top:0;
    right: 0;
  }
  .d-table-min-product__content{
    position: relative;
  }
  .order-product-actions{
    font-size: 9px;
    display: flex;
    gap: 4px;
    cursor: pointer;
  }
  @media (width <=600px) {
  .order-product-actions{
    font-size: 12px;
    display: flex;
    gap: 4px;
    cursor: pointer;
  }
  .d-table-min-product__col-sales{
    bottom:0;
    top: auto;
    right: 0;
    height: fit-content;
  }
  .d-table-min-product__col-all{
    position: relative;
  }
  }
</style>
