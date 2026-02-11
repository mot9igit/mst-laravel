<template>
  <!-- <div class="d-table-min__col-id" v-if="cell_key == 'id'" :id="value[cell_key]">{{ cell_data.label }} {{ value[cell_key] }} </div>
  <div class="d-table-min__col-status" v-else-if="cell_data.type == 'status'"><span :style="
          'color: #fff;background-color: #' +
          value.status_color
        ">{{ value['status_name'] }}</span>
  </div> -->
  <div class="d-table-min__col-simple d-table-min__col-simple-html" v-if="cell_data.type == 'html'">
    <div class="cell_value-label">{{ cell_data.label }}</div>
    <div class="item_cell">{{ prepareHtml(value[cell_key]) }}</div>
  </div>
   <div class="d-table-min__col-simple d-table-min__col-comment" v-else-if="cell_data.type == 'prepare-html' && value[cell_key] != null">
    <div class="cell_value-label">{{ cell_data.label }}</div>
    <div class="item_cell">{{ prepareHtml(value[cell_key]) }}</div>
  </div>
  <div class="d-table-min__col-simple" v-else-if="cell_key != 'id' && cell_key != 'status' && cell_data.type != 'html' && cell_data.type != 'prepare-html'">

    <div class="cell_value-label">{{ cell_data.label }}</div>
    <div
      class="cell_value"
      v-if="cell_data.items"
      :class="cell_key == 'name'"
    >
        <div v-for="item in cell_data.items" :key="item" class="multyitem_cell">
          <span v-if="value[item] && item.includes('inn')">
            ИНН: {{ value[item] ? value[item] : '-' }}</span
          >
          <span v-if="value[item] && !item.includes('inn')" class="cell_value-inn">{{
            value[item]
          }}</span>
        </div>
    </div>
    <div  class="item_cell" v-else>{{ value[cell_key] }}</div>
  </div>
</template>

<script>

export default {
  name: 'tableCell',
  emits: [

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
.d-table-min__head{
  display: flex;
  flex-direction: column;
  align-items: end;
  width: 100%;
}
.d-table-min__row-sort-label{
  font-style: normal;
  font-weight: 600;
  font-size: 10px;
  line-height: 13px;
  text-align: right;
  color: #282828;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
}
.d-table-min__row-sort-label i{
  font-size: 9px;
  padding-bottom: 2px;
}
.d-table-min__row-sort-list{
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: start;
  gap: 8px;
  padding: 7px 12px;
  position: absolute;
  width: auto;
  max-width: 180px;
  height: auto;
  right: 0px;
  top: 18px;
  background: #FBFBFB;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.14), 0px 0px 2px rgba(0, 0, 0, 0.12);
  border-radius: 6px;
  z-index: 10;
}
.d-table-min__head-col{
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.d-table-min__row-sort-list{
  transition:  all 0.2s ease;
}
.d-table-min__row-sort-list-item{
  display: flex;
  gap: 8px;
  align-items: center;
  cursor: pointer;
}
.d-table-min__row-sort-list-item .p-checkbox {
  width: 12px;
  height: 12px;
  border: 1px solid #757575;
  border-radius: 12px;
}
.d-table-min__row-sort-list-item .p-checkbox-box {
  border: none;
  width: 12px;
  height: 12px;
  background-color: transparent;
}
.d-table-min__row-sort-list-item .p-checkbox-checked .p-checkbox-box {
  width: 8px;
  height: 8px;
  border-radius: 8px;
  margin: 1px;
}
.d-table-min__row-sort-list-item .p-checkbox-icon {
  font-size: 9px;
  width: 12px;
  height: 12px;
}
.d-table-min__row-sort-list-item .p-checkbox-checked .p-checkbox-icon {
  color: var(--p-checkbox-checked-background);
}
.d-table-min__row-sort-list-item label{
  font-style: normal;
  font-weight: 400;
  font-size: 8px;
  line-height: 10px;
  color: #757575;
}
.product-card__seller-button-icon-open{
  transform: rotate(-180deg);
  padding-bottom: 1px;
}
.d-table-min__body{
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  margin-top: 16px;
}
.d-table-min__row{
  display: flex;
  flex-direction: column;
  align-items: start;
  justify-content: center;
  padding: 14px 8px;
  gap: 4px;
  background: #F5F5F5;
  border-radius: 8px;
  width:100%;
  position: relative;
}
.d-table-min__row .d-table-min__col-simple{
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  border-top: 0.5px solid rgb(117 117 117 / 16%);
  padding-top: 6px;
  position: relative;
}
.d-table-min__row .d-table-min__col-simple:nth-child(2){
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  position: relative;
  border-top: none;
  padding-top: 0px;
}
.cell_value-label{
  width: 50%;
  font-weight: 500;
  font-size: 9px;
  line-height: 12px;
  color: #757575;
}
.d-table-min__row .item_cell, .d-table-min__row .multyitem_cell{
  font-style: normal;
  font-weight: 400;
  font-size: 8px;
  line-height: 10px;
  text-align: right;
  color: #282828;
}
.d-table-min__col-id{
  font-style: normal;
  font-weight: 600;
  font-size: 10px;
  line-height: 13px;
  color: #282828;
  width: max-content;
}
.d-table-min__col-status{
  display: flex;
  align-items: center;

}
.d-table-min__col-status span{
  font-style: normal;
  font-weight: 600;
  font-size: 9px;
  line-height: 12px;
  text-align: center;
  padding: 2px 8px;
  border-radius: 20px;
}

.d-table-min__col-comment{
  display: flex;
  flex-direction: column;
  align-items: start !important;
  gap: 6px;
}
.d-table-min__col-comment .item_cell{
  text-align: left;
  width: 90%;
}

</style>
